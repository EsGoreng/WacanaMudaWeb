@php
    /**
     * Helper function untuk membuat string box-shadow CSS secara acak.
     * Ini menggantikan fungsi SASS yang sebelumnya menyebabkan error.
     */
    function generateStarShadows($number_of_stars)
    {
        $shadows = [];
        for ($i = 0; $i < $number_of_stars; $i++) {
            // Koordinat X dan Y acak antara 1px sampai 2000px
            $x = rand(1, 2000);
            $y = rand(1, 2000);
            $shadows[] = "{$x}px {$y}px #FFF";
        }
        return implode(', ', $shadows);
    }

    // --- UBAH JUMLAH BINTANG DI SINI ---
    $smallStars = generateStarShadows(400); // Jumlah bintang kecil
    $mediumStars = generateStarShadows(100); // Jumlah bintang sedang
    $largeStars = generateStarShadows(100); // Jumlah bintang besar
@endphp

<div class="fixed inset-0 z-[-1] overflow-hidden pointer-events-none bg-zinc-900 hidden dark:block">
    <div id="stars"></div>
    <div id="stars2"></div>
    <div id="stars3"></div>
</div>

<style>
    /* Layer 1: Bintang Kecil */
    #stars {
        width: 1px;
        height: 1px;
        background: transparent;
        box-shadow: {{ $smallStars }};
        animation: animStar 50s linear infinite;
    }

    #stars:after {
        content: " ";
        position: absolute;
        top: 2000px;
        width: 1px;
        height: 1px;
        background: transparent;
        box-shadow: {{ $smallStars }};
    }

    /* Layer 2: Bintang Sedang */
    #stars2 {
        width: 2px;
        height: 2px;
        background: transparent;
        box-shadow: {{ $mediumStars }};
        animation: animStar 100s linear infinite;
    }

    #stars2:after {
        content: " ";
        position: absolute;
        top: 2000px;
        width: 2px;
        height: 2px;
        background: transparent;
        box-shadow: {{ $mediumStars }};
    }

    /* Layer 3: Bintang Besar */
    #stars3 {
        width: 3px;
        height: 3px;
        background: transparent;
        box-shadow: {{ $largeStars }};
        animation: animStar 150s linear infinite;
    }

    #stars3:after {
        content: " ";
        position: absolute;
        top: 2000px;
        width: 3px;
        height: 3px;
        background: transparent;
        box-shadow: {{ $largeStars }};
    }

    @keyframes animStar {
        from {
            transform: translateY(0px);
        }

        to {
            transform: translateY(-2000px);
        }
    }
</style>
