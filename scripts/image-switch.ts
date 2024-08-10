const shopImages = document.querySelectorAll(".image-shop-item") as NodeListOf<HTMLLIElement>;
const showcaseImage = document.querySelector(".showcase-shop-image") as HTMLImageElement

if(shopImages && showcaseImage){
    console.log(shopImages)
    shopImages.forEach((el) => {
        const image = (((el as HTMLLIElement).children[0]) as HTMLImageElement).src;
        el.addEventListener("click", () => {
            showcaseImage.src = image;            
        })
    })
}

