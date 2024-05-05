document.addEventListener("DOMContentLoaded", function () {
    const carouselItems = document.querySelectorAll(".carousel-item");
    carouselItems.forEach((item) => {
        item.addEventListener("mouseenter", () => {
            const titleOverlay = item.querySelector(".title-overlay");
            if (titleOverlay) {
                setTimeout(() => {
                    titleOverlay.style.opacity = 1;
                }, 3000);
            }
        });

        item.addEventListener("mouseleave", () => {
            const titleOverlay = item.querySelector(".title-overlay");
            if (titleOverlay) {
                titleOverlay.style.opacity = 0;
            }
        });
    });
});
