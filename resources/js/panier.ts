import { doPost } from './utils';
import { filters, updateProducts } from './filters';
import { MDCTextField } from '@material/textfield';

const setQuantity = async (productId: number, quantity: number) => {
    if (await doPost('/cart/set', { productId, quantity })) {
        console.log('Added to cart'); //TODO: create notification
    } else {
        console.log('Failed to add to cart'); //TODO: create notification
    }
}

const addEVH2 = () => {
    const panier = document.getElementById('panier');
    if (!panier) {
        console.log("No panier found");
        return;
    }

    panier.addEventListener("click", (event) => {
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

        const mode = target.parentElement!.id;
        
        switch (mode.split('-').shift()) {
            case 'setQuantityBtn':
                const quantityMCD = new MDCTextField(quantityElem.parentElement);
                const quantity = quantityMCD.value.length === 0 ? 0 : parseInt(quantityMCD.value);
                setQuantity(parseInt(productId), quantity);
                if (quantity === 0) {
                    target.parentElement!.parentElement!.parentElement!.parentElement!.parentElement!.parentElement?.remove();
                }
                break;
            case 'removeBtn':
                setQuantity(parseInt(productId), 0);
                target.parentElement!.parentElement!.parentElement!.parentElement!.parentElement!.parentElement?.remove();
                break;
        
            default:
                break;
        }
    });
}
(async () => {
    addEVH2();
    filters();

})();