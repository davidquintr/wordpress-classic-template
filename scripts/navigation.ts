const headerElements : HTMLUListElement | null = document.querySelector("ul.menu-items");
const navigationContainer : HTMLElement | null = document.querySelector(".navigation-elements");
const menuBar : HTMLElement | null = document.querySelector(".menu-bar");

document.addEventListener("DOMContentLoaded", () => {
    const navigationElements : NodeList | undefined = headerElements?.childNodes
    navigationElements?.forEach((el) => {
        if (el.nodeType !== Node.ELEMENT_NODE) return;
        const link = (el as HTMLLIElement).childNodes[0] as HTMLAnchorElement
        if((window.location.origin + window.location.pathname) == link.href || (window.location.origin + window.location.pathname) == link.href){
            (el as HTMLLIElement).classList.toggle("current-page")
        }
    })

    if(!menuBar) return;
    menuBar?.addEventListener("click", ()=> {
        navigationContainer?.classList.toggle("active")
        document.body.style.overflow = navigationContainer?.classList.contains("active") ? "hidden" : ""
    })
})

