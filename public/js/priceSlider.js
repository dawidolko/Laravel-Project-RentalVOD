document.addEventListener("DOMContentLoaded", function () {
    const priceSlider = document.getElementById("price-slider");
    const priceRangeDisplay = document.getElementById("price-range-display");
    const priceMinInput = document.getElementById("price_min");
    const priceMaxInput = document.getElementById("price_max");

    noUiSlider.create(priceSlider, {
        start: [parseInt(priceMinInput.value), parseInt(priceMaxInput.value)],
        connect: true,
        range: {
            min: 0,
            max: 100,
        },
    });

    priceSlider.noUiSlider.on("update", function (values, handle) {
        priceMinInput.value = Math.round(values[0]);
        priceMaxInput.value = Math.round(values[1]);
        priceRangeDisplay.innerHTML = `${Math.round(values[0])} - ${Math.round(
            values[1]
        )}`;
    });
});
