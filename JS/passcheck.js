const password1 = document.querySelector(".pass1")
const password2 = document.querySelector(".pass2")
const paragraphText = document.querySelector(".result-text")

password1.addEventListener("input", () => {
    const pass1Value = password1.value
    const pass2Value = password2.value

    if ( pass1Value === pass2Value){
        paragraphText.textContent = "Hesla sú zhodné"
        paragraphText.classList.add("valid")
        paragraphText.classList.remove("invalid")
    } else {
        paragraphText.textContent = "Hesla nie sú zhodné"
        paragraphText.classList.add("invalid")
        paragraphText.classList.remove("valid")
    }
    if (pass1Value === "" && pass2Value === ""){
        paragraphText.textContent = ""
    }
})

password2.addEventListener("input", () => {
    const pass1Value = password1.value
    const pass2Value = password2.value

    if ( pass1Value === pass2Value){
        paragraphText.textContent = "Hesla sú zhodné"
        paragraphText.classList.add("valid")
        paragraphText.classList.remove("invalid")
    } else {
        paragraphText.textContent = "Hesla nie sú zhodné"
        paragraphText.classList.add("invalid")
        paragraphText.classList.remove("valid")
    }
    if (pass2Value === "" && pass1Value === ""){
        paragraphText.textContent = ""
    }
})