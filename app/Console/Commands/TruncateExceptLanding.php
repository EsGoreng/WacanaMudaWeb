<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TruncateExceptLanding extends Command
{
    protected $signature = 'db:truncate-except-landing';

    protected $description = 'Truncate all tables except landing_page_settings';

    public function handle()
    {
        $exceptTables = [
            'landing_page_settings',
            'migrations',
        ];

        Schema::disableForeignKeyConstraints();

        $tables = DB::select('SHOW TABLES');

        foreach ($tables as $table) {
            $tableName = array_values((array) $table)[0];

            if (! in_array($tableName, $exceptTables)) {
                DB::table($tableName)->truncate();
            }
        }

        Schema::enableForeignKeyConstraints();

        $this->info('Database cleaned. Tables kept: '.implode(', ', $exceptTables));
    }
}
