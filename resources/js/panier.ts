import { doGet, doPost } from './utils';
import { filters, updateProducts } from './filters';
import { MDCTextField } from '@material/textfield';
import { MDCCheckbox } from '@material/checkbox';
// import { loadStripe } from '@stripe/stripe-js';

const setQuantity = async (productId: number, quantity: number) => {
    if (await doPost('/cart/set', { productId, quantity })) {
        console.log('Added to cart'); //TODO: create notification
    } else {
        console.log('Failed to add to cart'); //TODO: create notification
    }
}

const getCartTotal = async () => {
    const data = await doGet('/cart/total');
    if (!data) {
        return 0;
    }
    return data.data.data;
}

const addEVH2 = () => {
    const panier = document.getElementById('panier');
    if (!panier) {
        console.log("No panier found");
        return;
    }

    panier.addEventListener("click", async (event) => {
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

        const elem = document.getElementById('cart-total');
        if (!elem) {
            console.log("No cart-total found");
            return 0;
        }

        const total = await getCartTotal() as number;
        if (total === 0) {
            elem.innerText = '0';
            return;
        }
        elem.innerText = total.toFixed(2);
    });
}

const getSelectedCard = () => {
    const cards = document.getElementsByName('payment-card');

    for (const card of Array.from(cards)) {
        const cardElem = new MDCCheckbox(card.parentElement!);
        console.log(cardElem)
        if (cardElem.checked) {
            return card.getAttribute('paymentMethod')
        }
    }
}

const payment = async () => {

    const payBtn = document.getElementById('payBtn') as HTMLButtonElement | null;
    const confirmPayBtn = document.getElementById('confirmPayBtn') as HTMLButtonElement | null;

    if (!payBtn || !confirmPayBtn) {
        console.error("Could not find payBtn or confirmPayBtn");
        return;
    }

    const cards = document.getElementsByName('payment-card');
    if (!cards) {
        console.error("Could not find cards");
        return;
    }

    // const stripe = await loadStripe('pk_test_51H9QZqZqZqZqZqZqZqZqZqZqZqZqZqZqZ00QZqZqZqZqZqZqZqZqZqZqZqZqZqZqZqZqZqZqZqZqZqZ');
    // if (!stripe) {
    //     console.error("Could not load stripe");
    //     return;
    // }

    cards.forEach(card => {
        card.addEventListener('click', (event) => {
            const target = event.target as HTMLElement;
            if (!target) {
                return;
            }

            cards.forEach(element => {
                if (element === target) {
                    return;
                }
                const e = new MDCCheckbox(element.parentElement!);
                e.checked = false;
            });

            
        });
    });


    confirmPayBtn.addEventListener('click', async () => {
        const paymentMethod = getSelectedCard();
        console.log('paymentMethod');
        console.log(paymentMethod);
        if (await doPost('/cart/payment', {paymentMethod, total: await getCartTotal(), mode: 'cart'})) {
            console.log('Payment done'); //TODO: create notification
            window.location.href = '/';
        } else {
            console.log('Payment failed'); //TODO: create notification
        }

    });

    // payBtn.addEventListener('click', async function (e: MouseEvent) {
        // window.location.href = '/cart/payment';
        // const elem = document.getElementById('modal-payment-body') as HTMLButtonElement;
        // if (!elem) {
        //     console.error("Could not find modal-payment-body");
        //     return;
        // }

        // elem.innerText = 'Loading...';



        // elem.innerText = '';
        // const elements = stripe.elements();
        // const cardElement = elements.create('card');
        // cardElement.mount('#modal-payment-body-container');
    // });
}

(async () => {
    addEVH2();
    filters();
    payment();

})();