const shopImages = document.querySelectorAll(".image-shop-item") as NodeListOf<HTMLLIElement>;
const showcaseImage = document.querySelector(".showcase-shop-image") as HTMLImageElement

let imageIndex = 0;
const imageLimit = shopImages.length

if(shopImages && showcaseImage){
    shopImages.forEach((el, i) => {
        const image = (((el as HTMLLIElement).children[0]) as HTMLImageElement).src;
        el.addEventListener("click", () => {
            imageIndex = i;
            showcaseImage.src = image;
        })
    })
}

const leftButton = document.querySelector(".button-direction.left") as HTMLButtonElement;
const rightButton = document.querySelector(".button-direction.right") as HTMLButtonElement;

if(leftButton && rightButton){
    leftButton?.addEventListener("click", () => {
        if(imageIndex <= 0) return;
        imageIndex--;
        showcaseImage.src = (shopImages[imageIndex].children[0] as HTMLImageElement).src;
    })

    rightButton?.addEventListener("click", () => {
        if(imageIndex >= (imageLimit - 1)) return;
        imageIndex++;
        showcaseImage.src = (shopImages[imageIndex].children[0] as HTMLImageElement).src;
    })
}
