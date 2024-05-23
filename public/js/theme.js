document.addEventListener("DOMContentLoaded", function () {
    const themeToggleButton = document.getElementById("theme-toggle");
    const themeIcon = document.getElementById("theme-icon");
    const body = document.body;

    // Domyślnie ustawiony tryb ciemny
    body.setAttribute("data-bs-theme", "dark");
    themeIcon.classList.add("fas", "fa-moon");

    themeToggleButton.addEventListener("click", function () {
        const theme = body.getAttribute("data-bs-theme");

        if (theme === "dark") {
            body.setAttribute("data-bs-theme", "light");
            themeIcon.classList.replace("fa-moon", "fa-sun");
        } else {
            body.setAttribute("data-bs-theme", "dark");
            themeIcon.classList.replace("fa-sun", "fa-moon");
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const searchToggle = document.getElementById("searchToggle");
    const searchInput = document.getElementById("searchInput");
    const searchSubmit = document.getElementById("searchSubmit");

    searchToggle.addEventListener("click", function () {
        if (searchInput.style.display === "none") {
            searchInput.style.display = "block";
            searchSubmit.style.display = "block";
        } else {
            if (searchInput.value.trim() !== "") {
                searchSubmit.click();
            }
            searchInput.style.display = "none";
            searchSubmit.style.display = "none";
        }
    });
});
