document.addEventListener("DOMContentLoaded", function () {
    // Pobierz elementy overlay
    const overlay = document.getElementById("imageOverlay");
    const overlayImage = document.querySelector(".overlay-image");
    const closeButton = document.querySelector(".close-btn");

    // Funkcja do otwierania overlay z obrazem
    function openOverlay(imageSource) {
        overlayImage.src = imageSource; // Ustaw źródło dla obrazu w overlay
        overlay.style.display = "flex"; // Pokaż overlay
    }

    // Dodaj zdarzenie kliknięcia dla obrazów
    const images = document.querySelectorAll(".product-img.hover");
    images.forEach((image) => {
        image.addEventListener("click", function () {
            openOverlay(this.src); // Otwórz overlay z obrazem
        });
    });

    // Dodaj zdarzenie kliknięcia dla przycisków powiększenia
    const magnificationButtons = document.querySelectorAll(
        ".btn-action.magnification"
    );
    magnificationButtons.forEach((button) => {
        button.addEventListener("click", function () {
            const imgElement =
                this.closest(".showcase-banner").querySelector(
                    ".product-img.hover"
                );
            openOverlay(imgElement.src); // Otwórz overlay z obrazem powiązanym z przyciskiem
        });
    });

    // Zdarzenie kliknięcia dla przycisku zamknięcia
    closeButton.addEventListener("click", function () {
        overlay.style.display = "none"; // Ukryj overlay
    });

    // Zamykanie overlay po kliknięciu poza obrazem
    overlay.addEventListener("click", function (e) {
        if (e.target === overlay || e.target === closeButton) {
            overlay.style.display = "none";
        }
    });
});
