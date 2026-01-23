<div class='group flex items-center gap-4 p-3 rounded-lg transition-all duration-200 hover:bg-gray-50 dark:hover:bg-gray-800/50'
    style='width: 100%;'>
    <div class='relative flex-shrink-0' style='width: 96px; height: 96px;'>
        <img src='{$thumb}' alt='{$desc}'
            class='w-full h-full object-cover rounded-xl shadow-md ring-1 ring-gray-200 dark:ring-gray-700 group-hover:ring-2 group-hover:ring-blue-400 transition-all'
            loading='lazy' />
        <div
            class='absolute inset-0 rounded-xl bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity'>
        </div>
    </div>
    <div class='flex-1 min-w-0 space-y-1.5'>
        <h4 class='font-semibold text-sm text-gray-900 dark:text-gray-100 truncate leading-tight'>
            {$desc}
        </h4>
        <div class='flex items-center gap-2 text-xs'>
            <span class='text-gray-600 dark:text-gray-400'>
                by <span class='font-medium text-gray-700 dark:text-gray-300'>{$userName}</span>
            </span>
            <span class='text-gray-400 dark:text-gray-600'>•</span>
            <span class='inline-flex items-center gap-1 text-gray-500 dark:text-gray-400'>
                <svg class='w-3.5 h-3.5' fill='currentColor' viewBox='0 0 20 20'>
                    <path fill-rule='evenodd'
                        d='M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z'
                        clip-rule='evenodd' />
                </svg>
                {$likes}
            </span>
        </div>
        <div
            class='inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-gray-100 dark:bg-gray-800 text-xs text-gray-600 dark:text-gray-400'>
            <svg class='w-3 h-3' fill='currentColor' viewBox='0 0 20 20'>
                <path d='M10 12a2 2 0 100-4 2 2 0 000 4z' />
                <path fill-rule='evenodd'
                    d='M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z'
                    clip-rule='evenodd' />
            </svg>
            Unsplash
        </div>
    </div>
</div>
