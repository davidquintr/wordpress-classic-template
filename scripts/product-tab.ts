const tabButtons = document.querySelectorAll("button.product-tab-button") as NodeListOf<HTMLButtonElement>;
const tabItems = document.querySelectorAll("li.product-tab-item") as NodeListOf<HTMLLIElement>;

const ACTIVE_CLASS = "active";

tabButtons.forEach((button, index) => {
    button.addEventListener("click", () => {
        if (tabItems[index].classList.contains(ACTIVE_CLASS)) return;

        tabItems.forEach(item => item.classList.remove(ACTIVE_CLASS));
        tabButtons.forEach(btn => btn.classList.remove(ACTIVE_CLASS));

        tabItems[index].classList.add(ACTIVE_CLASS);
        button.classList.add(ACTIVE_CLASS);
    });
});
