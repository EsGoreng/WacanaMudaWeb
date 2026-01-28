import Lenis from "lenis";

let lenis;

const initLenis = () => {
    const wrapperElement = document.querySelector("#main-content") || window;
    const contentElement =
        document.querySelector("#main-content > div") ||
        document.documentElement;

    if (lenis) lenis.destroy();

    lenis = new Lenis({
        wrapper: wrapperElement === window ? window : wrapperElement,
        content: contentElement,
        duration: 1.0,
        easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
        smoothWheel: true,
        touchMultiplier: 1.5,
    });

    lenis.on("scroll", ({ scroll, direction }) => {
        window.dispatchEvent(
            new CustomEvent("lenis-scroll", {
                detail: {
                    scroll: scroll,
                    direction: direction,
                },
            }),
        );
    });

    function raf(time) {
        lenis.raf(time);
        requestAnimationFrame(raf);
    }
    requestAnimationFrame(raf);
};

document.addEventListener("DOMContentLoaded", initLenis);

document.addEventListener("livewire:navigated", () => {
    initLenis();
    lenis.scrollTo(0, { immediate: true });

    setTimeout(() => {
        if (lenis) lenis.resize();
    }, 100);
});

window.lenis = lenis;
