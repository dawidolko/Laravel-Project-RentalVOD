document.addEventListener("DOMContentLoaded", function () {
    updateTotal();

    const today = new Date();
    today.setHours(0, 0, 0, 0);
    const todayString = today.toISOString().split("T")[0];
    const dateInputs = document.querySelectorAll(".date-input");

    dateInputs.forEach((input) => {
        if (input.name === "start") {
            input.min = todayString;
        }
        input.addEventListener("change", function () {
            const row = input.closest("tr");
            const startDateInput = row.querySelector('input[name="start"]');
            const endDateInput = row.querySelector('input[name="end"]');
            if (startDateInput && startDateInput.value) {
                endDateInput.min = startDateInput.value;
                let maxDate = new Date(startDateInput.value);
                maxDate.setDate(maxDate.getDate() + 13);
                endDateInput.max = maxDate.toISOString().split("T")[0];
            }
            updateCost(row);
        });
    });

    document
        .getElementById("checkout-button")
        .addEventListener("click", function (event) {
            if (!areDatesComplete()) {
                event.preventDefault();
                alert("Proszę wypełnić wszystkie daty startowe i końcowe!");
            } else {
                document.getElementById("payment-section").style.display =
                    "block";
            }
        });

    function updateCost(row) {
        const startDateInput = row.querySelector('input[name="start"]');
        const endDateInput = row.querySelector('input[name="end"]');
        const pricePerDay = parseFloat(
            row.querySelector(".price-per-day").textContent.replace(" zł", "")
        );
        if (startDateInput.value && endDateInput.value) {
            const startDate = new Date(startDateInput.value);
            const endDate = new Date(endDateInput.value);
            const diffTime = endDate - startDate;
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
            const totalCost = pricePerDay * diffDays;
            row.querySelector(".total-cost").textContent = `${totalCost.toFixed(
                2
            )} zł`;
        } else {
            row.querySelector(".total-cost").textContent = "0 zł";
        }
        updateTotal();
    }

    function updateTotal() {
        let total = 0;
        document.querySelectorAll(".total-cost").forEach((item) => {
            const itemCost = parseFloat(item.textContent.replace(" zł", ""));
            total += itemCost;
        });
        document.getElementById(
            "total-display"
        ).textContent = `Razem: ${total.toFixed(2)} zł`;
    }

    function areDatesComplete() {
        return Array.from(document.querySelectorAll(".date-input")).every(
            (input) => input.value !== ""
        );
    }

    const expiryDateInput = document.getElementById("expiryDate");
    expiryDateInput.min = new Date().toISOString().slice(0, 7);
});
