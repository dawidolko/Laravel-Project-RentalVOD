document.addEventListener("DOMContentLoaded", function () {
    const themeToggleButton = document.getElementById("theme-toggle");
    const themeIcon = document.getElementById("theme-icon");
    const body = document.body;

    body.setAttribute("data-bs-theme", "dark");
    themeIcon.classList.add("bi-moon-stars");

    themeToggleButton.addEventListener("click", function () {
        const theme = body.getAttribute("data-bs-theme");

        if (theme === "dark") {
            body.setAttribute("data-bs-theme", "light");
            themeIcon.classList.replace("bi-moon-stars", "bi-sun");
        } else {
            body.setAttribute("data-bs-theme", "dark");
            themeIcon.classList.replace("bi-sun", "bi-moon-stars");
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
