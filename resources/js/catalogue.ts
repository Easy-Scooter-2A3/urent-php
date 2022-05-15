import { MDCTextField } from '@material/textfield';
import { doPost } from './utils';

const addToCart = async (productId: number, quantity: number) => {
    if (await doPost('/cart/add', { productId, quantity })) {
        console.log('Added to cart'); //TODO: create notification
    } else {
        console.log('Failed to add to cart'); //TODO: create notification
    }
}

const addEVH = () => {
    const catalogue = document.getElementById("catalogue");
    if (!catalogue) {
        console.log("No catalogue found");
        return;
    }

    catalogue.addEventListener("click", (event) => {
        const target = event.target as HTMLElement;
        if (!target) {
            return;
        }

        const productId = target.getAttribute('customId');
        if (!productId) {
            return;
        }
        
        const quantityElem = document.getElementById(`productId-${productId}-quantity`);
        if (!quantityElem) {
            console.log("No quantityElem found");
            return;
        }

        if (!quantityElem.parentElement) {
            console.log("No quantityElem.parentElement found");
            return;
        }

        const quantityMCD = new MDCTextField(quantityElem.parentElement);
        const quantity = quantityMCD.value.length === 0 ? 0 : parseInt(quantityMCD.value);

        if (quantity === 0) {
            console.log("Quantity is 0"); //TODO: create notification
            return;
        }

        addToCart(parseInt(productId), quantity);
    });
}

(async () => {
    addEVH();
})();