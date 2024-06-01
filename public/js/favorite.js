document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".heart.favoriting").forEach((button) => {
        const movieId = button.getAttribute("data-movie-id");
        const icon = document.getElementById(`favorite-icon-${movieId}`);
        if (localStorage.getItem(`favorite-${movieId}`) === "true") {
            icon.name = "heart";
            icon.style.color = "red";
        } else {
            icon.name = "heart-outline";
            icon.style.color = "";
        }
    });
});

function toggleFavorite(movieId) {
    const icon = document.getElementById(`favorite-icon-${movieId}`);
    let isFavorite = localStorage.getItem(`favorite-${movieId}`) === "true";

    localStorage.setItem(`favorite-${movieId}`, !isFavorite);
    isFavorite = !isFavorite;

    if (isFavorite) {
        icon.name = "heart";
        icon.style.color = "red";
    } else {
        icon.name = "heart-outline";
        icon.style.color = "";
    }
}
