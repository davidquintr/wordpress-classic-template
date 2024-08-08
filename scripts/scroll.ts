const header = document.querySelector(".page-header") as HTMLElement;

window.addEventListener("scroll", () => {
    if (window.scrollY > 0) {
        header.classList.add("on-scroll");
    } else {
        header.classList.remove("on-scroll");
    }
});
    