const shopImages = document.querySelectorAll(
  ".image-shop-item"
) as NodeListOf<HTMLLIElement>;
const showcaseImage = document.querySelector(
  ".showcase-shop-image"
) as HTMLImageElement;

let imageIndex = 0;
const imageLimit = shopImages.length;

if (shopImages && showcaseImage) {
  shopImages.forEach((el, i) => {
    const image = ((el as HTMLLIElement).children[0] as HTMLImageElement).src;
    el.addEventListener("click", () => {
      imageIndex = i;
      showcaseImage.src = image;
    });
  });
}

const leftButton = document.querySelector(
  ".button-direction.left"
) as HTMLButtonElement;
const rightButton = document.querySelector(
  ".button-direction.right"
) as HTMLButtonElement;

if (leftButton && rightButton) {
  leftButton?.addEventListener("click", () => {
    if (imageIndex <= 0) return;
    imageIndex--;
    showcaseImage.src = (
      shopImages[imageIndex].children[0] as HTMLImageElement
    ).src;
  });

  rightButton?.addEventListener("click", () => {
    if (imageIndex >= imageLimit - 1) return;
    imageIndex++;
    showcaseImage.src = (
      shopImages[imageIndex].children[0] as HTMLImageElement
    ).src;
  });
}

const colors = document.querySelectorAll(".cfvsw-swatches-option") as NodeListOf<HTMLDivElement>;
const swatchContainers = document.querySelectorAll(".cfvsw-swatches-container") as NodeListOf<HTMLDivElement>;
const dataVariants = document.querySelectorAll(".images-variants") as NodeListOf<HTMLInputElement>;

const VARIANT_DISABLED = "cfvsw-swatches-blur-disable";
const selectedSwatchs: (string | null)[] = [];
const DATA_SLUG = "data-slug";

const observeSwatchButtons = (container: HTMLElement, index: number) => {
    const childNodes = container.childNodes as NodeListOf<HTMLDivElement>;
    childNodes.forEach((button) => {
      const observer = new MutationObserver((mutationsList) => {
        mutationsList.forEach((mutation) => {
          if (mutation.type === "attributes" && mutation.attributeName === "class") {
            if (button.classList.contains("cfvsw-selected-swatch")) {
              selectedSwatchs[index] = button.getAttribute(DATA_SLUG);
              const currentSelection = [...selectedSwatchs].reverse().join("-");
              dataVariants.forEach(el => {
                if(el.id.includes(currentSelection)) {
                    showcaseImage.src = el.value;
                }
              })

            }
          }
        });
      });
  
      observer.observe(button, {
        attributes: true,
        attributeFilter: ["class"],
      });
    });
  };
  
  if (swatchContainers[0]) {
    observeSwatchButtons(swatchContainers[0], 0);
  }
  
  if (swatchContainers.length > 1 && swatchContainers[1]) {
    observeSwatchButtons(swatchContainers[1], 1);
  }
  