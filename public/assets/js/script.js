const eye = document.querySelector(".bi-eye")
const eyeOff = document.querySelector(".bi-eye-slash")
const passwordInput = document.querySelector("input[type=password]")

eye.addEventListener("click", () => {
    eye.style.display = "none"
    eyeOff.style.display = "block"
    passwordInput.type = "text"
})

eyeOff.addEventListener("click", () => {
    eyeOff.style.display = "none"
    eye.style.display = "block"
    passwordInput.type = "password"
})
