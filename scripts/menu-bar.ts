const menuButton = document.querySelector(".menu-button-toggle") as HTMLButtonElement;
const productSortPanel = document.querySelector(".product-sorting") as HTMLDivElement;

if(menuButton && productSortPanel) {
    menuButton.addEventListener("click", () => {
        productSortPanel.classList.toggle("active");
    })
}

const buttonsMenu = document.querySelectorAll(".subcategory.button-redirect") as NodeListOf<HTMLAnchorElement>;

if(buttonsMenu){ 
    buttonsMenu.forEach(el => {
        el.addEventListener("click", () => {
            productSortPanel.classList.toggle("active");
        })
    })
}