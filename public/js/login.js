document.addEventListener("DOMContentLoaded", function () {
    const loginForm = document.getElementById("loginForm");
    loginForm.addEventListener("submit", function (event) {
        let valid = true;
        const email = document.getElementById("email");
        const password = document.getElementById("password");

        if (!email.value.includes("@") || !email.value.includes(".")) {
            valid = false;
            email.classList.add("is-invalid");
        } else {
            email.classList.remove("is-invalid");
        }

        if (password.value.length < 8) {
            valid = false;
            password.classList.add("is-invalid");
        } else {
            password.classList.remove("is-invalid");
        }

        if (!valid) {
            event.preventDefault();
        }
    });
});
