document.addEventListener("DOMContentLoaded", function () {
    const overlay = document.getElementById("imageOverlay");
    const overlayImage = document.querySelector(".overlay-image");
    const closeButton = document.querySelector(".close-btn");

    function openOverlay(imageSource) {
        overlayImage.src = imageSource;
        overlay.style.display = "flex";
    }

    const images = document.querySelectorAll(".product-img.hover");
    images.forEach((image) => {
        image.addEventListener("click", function () {
            openOverlay(this.src);
        });
    });

    const magnificationButtons = document.querySelectorAll(
        ".btn-action.magnification"
    );
    magnificationButtons.forEach((button) => {
        button.addEventListener("click", function () {
            const imgElement =
                this.closest(".showcase-banner").querySelector(
                    ".product-img.hover"
                );
            openOverlay(imgElement.src);
        });
    });

    closeButton.addEventListener("click", function () {
        overlay.style.display = "none";
    });

    overlay.addEventListener("click", function (e) {
        if (e.target === overlay || e.target === closeButton) {
            overlay.style.display = "none";
        }
    });
});
