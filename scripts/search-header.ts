const searchButton = document.querySelector(".header-button.search") as HTMLButtonElement
const searchControls = document.querySelector(".search-controls") as HTMLDivElement

document.addEventListener("DOMContentLoaded", () => {
    searchButton.addEventListener("click", () => {
        searchControls.classList.toggle("active")
    })
})