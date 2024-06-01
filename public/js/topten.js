document.addEventListener("DOMContentLoaded", function () {
    const slides = document.querySelectorAll(".top-movies-slide");
    let currentSlide = 0;

    function showSlide(index) {
        slides[currentSlide].classList.remove("active");
        currentSlide = (index + slides.length) % slides.length;
        slides[currentSlide].classList.add("active");
    }

    document.getElementById("prevSlide").addEventListener("click", function () {
        showSlide(currentSlide - 1);
    });

    document.getElementById("nextSlide").addEventListener("click", function () {
        showSlide(currentSlide + 1);
    });
});
