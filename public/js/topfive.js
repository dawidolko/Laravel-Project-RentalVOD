document.addEventListener("DOMContentLoaded", function () {
    function setTopFiveFramesSize() {
        const frames = document.querySelectorAll(".topfive .frame");
        const browserWidth = window.innerWidth;
        let calcFrameWidth = 0;
        let calcFrameHeight = 0;

        if (browserWidth < 768) {
            calcFrameWidth = (browserWidth - browserWidth * 0.2) / 5 - 15;
            calcFrameHeight = browserWidth * 0.1;
        } else if (browserWidth >= 768 && browserWidth < 1024) {
            calcFrameWidth = (browserWidth - browserWidth * 0.1) / 5 - 20;
            calcFrameHeight = browserWidth * 0.1;
        } else if (browserWidth >= 1024 && browserWidth < 1440) {
            calcFrameWidth = (browserWidth - browserWidth * 0.1) / 5 - 20;
            calcFrameHeight = browserWidth * 0.1;
        } else if (browserWidth >= 1440) {
            calcFrameWidth = (browserWidth - browserWidth * 0.1) / 5 - 20;
            calcFrameHeight = browserWidth * 0.1;
        }

        frames.forEach((frame) => {
            const img = frame.querySelector("img");
            frame.style.width = `${calcFrameWidth}px`;
            frame.parentNode.style.height = `${calcFrameHeight}px`;
            frame.parentNode.style.minHeight = `${calcFrameHeight}px`;
            if (img) {
                img.style.height = `${calcFrameHeight}px`;
                img.style.width = `${calcFrameWidth}px`;
            }
        });
    }

    function handleHover() {
        const frames = document.querySelectorAll(".topfive .frame");
        frames.forEach((frame) => {
            frame.addEventListener("mouseenter", () => {
                const img = frame.querySelector("img");
                const overlay = frame.querySelector(".overlay");
                if (img) img.style.display = "none";
                if (overlay) overlay.style.display = "block";
            });
            frame.addEventListener("mouseleave", () => {
                const img = frame.querySelector("img");
                const overlay = frame.querySelector(".overlay");
                if (img) img.style.display = "block";
                if (overlay) overlay.style.display = "none";
            });
        });
    }

    setTopFiveFramesSize();
    handleHover();

    window.addEventListener("resize", setTopFiveFramesSize);
});

document.addEventListener("DOMContentLoaded", function () {
    const scrollLeftButton = document.querySelector(".unique-scroll-left");
    const scrollRightButton = document.querySelector(".unique-scroll-right");
    const sliderContainer = document.querySelector(".unique-slider-container");

    scrollLeftButton.addEventListener("click", () => {
        sliderContainer.scrollBy({ left: -300, behavior: "smooth" });
    });

    scrollRightButton.addEventListener("click", () => {
        sliderContainer.scrollBy({ left: 300, behavior: "smooth" });
    });
});
