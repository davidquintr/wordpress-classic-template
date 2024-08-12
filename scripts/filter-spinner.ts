const minusButtons = document.querySelectorAll("button.minus") as NodeListOf<HTMLButtonElement>
const plusButtons = document.querySelectorAll("button.plus") as NodeListOf<HTMLButtonElement>

const spinnerTargets = document.querySelectorAll("input.spinner-target") as NodeListOf<HTMLInputElement>


if(minusButtons && plusButtons && spinnerTargets){
    spinnerTargets.forEach((el, index) =>{
        minusButtons.item(index).addEventListener("click", ()=> {
            if(parseInt(el.value) < 1) return;
            el.value = (parseInt(el.value) - 1).toString();
        })

        plusButtons.item(index).addEventListener("click", ()=> {
            el.value = (parseInt(el.value) + 1).toString();
        })
    })
}