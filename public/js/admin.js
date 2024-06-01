function openEditPanel(movieId) {
    document.getElementById("edit-panel-" + movieId).style.display =
        "table-row";
}

function closeEditPanel(movieId) {
    document.getElementById("edit-panel-" + movieId).style.display = "none";
}

function toggleAddPanel(event, type) {
    event.preventDefault();
    let panel = type === "movie" ? "add-panel-movie" : "add-panel-category";
    let display = document.getElementById(panel).style.display;
    document.getElementById(panel).style.display =
        display === "none" ? "block" : "none";
}

function togglePromoSlider(movieId) {
    const slider = document.getElementById("promo-slider-" + movieId);
    slider.style.display = slider.style.display === "none" ? "flex" : "none";
}

function updateSliderLabel(movieId, value) {
    const label = document.getElementById("slider-label-" + movieId);
    label.textContent = value + " zł";
}
