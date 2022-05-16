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

const updateProducts = (activeAttributes: Set<number>) => {
    const elems = document.querySelectorAll('tr[rowid]');

    elems.forEach(elem => {
        let matchAttributes = false;
        const list = elem.querySelectorAll('td > div > ul')[0];

        if (activeAttributes.size > 0) {
            for (const child of Array.from(list.children)) {
                const attr = child.getAttribute('attr');
                if (attr && activeAttributes.has(parseInt(attr))) {
                    matchAttributes = true;
                }
            }
        } else {
            matchAttributes = true;
        }

        matchAttributes ? elem.classList.remove('hidden') : elem.classList.add('hidden');
    });
}

const filters = () => {
    const attributes = document.querySelectorAll('input[type=checkbox]');

    const attributesToShow = new Set<number>();
    attributes.forEach(filter => {
        filter.addEventListener('change', (event) => {
            const target = event.target as HTMLInputElement;
            if (!target) {
                return;
            }

            const attributeId = target.getAttribute('attributeId');
            if (!attributeId) {
                return;
            }

            if (target.checked) {
                attributesToShow.add(parseInt(attributeId));
            } else {
                attributesToShow.delete(parseInt(attributeId));
            }

            updateProducts(attributesToShow);
        });
    });
}

(async () => {
    addEVH();
    filters();

})();