import Lenis from "lenis";

// Inisialisasi Singleton (Hanya dibuat sekali)
let lenis;

const initLenis = () => {
    // Cek apakah sudah ada instance, jika belum buat baru
    if (!lenis) {
        const scrollElement = document.getElementById("main-content") || window;

        lenis = new Lenis({
            wrapper: scrollElement === window ? window : scrollElement,
            // content logic biasanya otomatis dideteksi Lenis, tapi bisa diexplicitkan
            duration: 1.2,
            easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
            direction: "vertical",
            gestureDirection: "vertical",
            smooth: true,
            smoothTouch: false,
            touchMultiplier: 2,
        });

        // Loop Animation Frame cukup dijalankan sekali saja
        function raf(time) {
            lenis.raf(time);
            requestAnimationFrame(raf);
        }
        requestAnimationFrame(raf);
    }
};

// Jalankan saat load awal
initLenis();

// Hook ke Livewire
document.addEventListener("livewire:navigated", () => {
    // Jangan destroy & create ulang (berat di memori).
    // Cukup reset scroll ke atas.
    if (lenis) {
        lenis.scrollTo(0, { immediate: true });

        // Opsional: panggil resize jika konten berubah drastis dan Lenis tidak mendeteksi otomatis
        // lenis.resize();
    } else {
        initLenis(); // Fallback jika navigasi pertama via ajax
    }
});
