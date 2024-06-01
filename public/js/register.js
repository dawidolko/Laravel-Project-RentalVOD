document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form.needs-validation");
    form.addEventListener("submit", function (event) {
        const password = document.getElementById("password");
        const passwordConfirm = document.getElementById(
            "password_confirmation"
        );
        let valid = true;

        if (password.value !== passwordConfirm.value) {
            passwordConfirm.setCustomValidity("Hasła nie są identyczne.");
            valid = false;
        } else {
            passwordConfirm.setCustomValidity("");
        }

        if (!valid) {
            event.preventDefault();
            event.stopPropagation();
        }
        form.classList.add("was-validated");
    });
});
