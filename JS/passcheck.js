const password1 = document.querySelector(".pass1");
const password2 = document.querySelector(".pass2");
const paragraphText = document.querySelector(".result-text");

let hasStartedConfirmation = false;

function updatePasswordMatchState() {
    const pass1Value = password1.value;
    const pass2Value = password2.value;

    if (!hasStartedConfirmation || pass2Value === "") {
        paragraphText.textContent = "";
        paragraphText.classList.remove("valid", "invalid");
        return;
    }

    if (pass1Value === pass2Value) {
        paragraphText.textContent = "Heslá sú zhodné";
        paragraphText.classList.add("valid");
        paragraphText.classList.remove("invalid");
        return;
    }

    paragraphText.textContent = "Heslá nie sú zhodné";
    paragraphText.classList.add("invalid");
    paragraphText.classList.remove("valid");
}

password1.addEventListener("input", () => {
    if (!hasStartedConfirmation) {
        return;
    }

    updatePasswordMatchState();
});

password2.addEventListener("input", () => {
    hasStartedConfirmation = true;
    updatePasswordMatchState();
});
