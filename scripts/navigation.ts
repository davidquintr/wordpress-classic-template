const headerElements : HTMLUListElement | null = document.querySelector("ul.menu-items.header");
const navigationButton : HTMLButtonElement | null = document.querySelector(".header-button.navigation");

document.addEventListener("DOMContentLoaded", () => {
    const navigationElements : NodeList | undefined = headerElements?.childNodes
    navigationElements?.forEach((el) => {
        if (el.nodeType !== Node.ELEMENT_NODE) return;
        const link = (el as HTMLLIElement).childNodes[0] as HTMLAnchorElement
        if((window.location.origin + window.location.pathname) == link.href || (window.location.origin + window.location.pathname) == link.href){
            (el as HTMLLIElement).classList.toggle("current-page")
        }
    })

    navigationButton?.addEventListener("click", () => {
        headerElements?.classList.toggle("active")
    })

})

