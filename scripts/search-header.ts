const searchButton = document.querySelector(".header-button.search") as HTMLButtonElement
const searchControls = document.querySelector(".search-controls") as HTMLDivElement
const searchForm = document.querySelector("#search-header") as HTMLFormElement

document.addEventListener("DOMContentLoaded", () => {
    searchButton.addEventListener("click", () => {
        searchControls.classList.toggle("active")
    })
})

searchForm?.addEventListener("submit", (e: Event) =>{
    e.preventDefault();
    const searchInput = searchForm.elements[0] as HTMLInputElement;
    if(searchInput.value.length < 1) return;
    window.location.href = `${window.location.origin}/?s=${searchInput.value}`
})