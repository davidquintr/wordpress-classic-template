const userButton = document.querySelector(".header-button-img.user") as HTMLButtonElement;
const userInfo = document.querySelector(".profile-options") as HTMLDivElement

userButton.addEventListener("click", ()=> {
    userInfo.classList.toggle("active")
})