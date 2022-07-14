/* eslint-disable import/no-unresolved */
/* eslint-disable import/extensions */
import { MDCTextField } from '@material/textfield';
import { MDCCheckbox } from '@material/checkbox';
import { doGet, doPost } from './utils';
import { filters } from './filters';
import notification from './notif';
import getSelectedCard from './getSelectedCard';

const setQuantity = async (productId: number, quantity: number) => {
  const res = await doPost('/cart/set', { productId, quantity });
  if (res) {
    if (res.data.success) {
      notification('Added to cart');
      return;
    }

    notification(res.data.message);
  } else {
    notification('Failed to add to cart');
  }
};

const getCartTotal = async () => {
  const data = await doGet('/cart/total');
  if (!data) {
    return 0;
  }
  return data.data.total;
};

const addEVH2 = () => {
  const panier = document.getElementById('panier');
  if (!panier) {
    console.log('No panier found');
    return;
  }

  panier.addEventListener('click', async (event) => {
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
      console.log('No quantityElem found');
      return;
    }

    if (!quantityElem.parentElement) {
      console.log('No quantityElem.parentElement found');
      return;
    }

    const mode = target.parentElement!.id.split('-').shift();

    if (mode === 'setQuantityBtn') {
      const quantityMCD = new MDCTextField(quantityElem.parentElement);
      const quantity = quantityMCD.value.length === 0 ? 0 : parseInt(quantityMCD.value, 10);
      setQuantity(parseInt(productId, 10), quantity);
      if (quantity === 0) {
        // eslint-disable-next-line max-len
        target.parentElement!.parentElement!.parentElement!.parentElement!.parentElement!.parentElement?.remove();
      }
    } else if (mode === 'removeBtn') {
      setQuantity(parseInt(productId, 10), 0);
        // eslint-disable-next-line max-len
        target.parentElement!.parentElement!.parentElement!.parentElement!.parentElement!.parentElement?.remove();
    }

    const elem = document.getElementById('cart-total');
    if (!elem) {
      console.log('No cart-total found');
      return;
    }

    const total = await getCartTotal() as number;
    if (total === 0) {
      elem.innerText = '0';
      return;
    }
    elem.innerText = total.toFixed(2);
  });
};

const payment = async () => {
  const payBtn = document.getElementById('payBtn') as HTMLButtonElement | null;
  const confirmPayBtn = document.getElementById('confirmPayBtn') as HTMLButtonElement | null;

  if (!payBtn || !confirmPayBtn) {
    console.error('Could not find payBtn or confirmPayBtn');
    return;
  }

  const cards = document.getElementsByName('payment-card');
  if (!cards) {
    console.error('Could not find cards');
    return;
  }

  cards.forEach((card) => {
    card.addEventListener('click', (event) => {
      const target = event.target as HTMLElement;
      if (!target) {
        return;
      }

      cards.forEach((element) => {
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
    if (!paymentMethod) {
      notification('Please select a payment method');
      return;
    }

    const res = await doPost('/cart/payment', { paymentMethod, total: await getCartTotal(), mode: 'cart' }); 
    if (res) {
      if (res.data.success) {
        notification('Payment successful');
        window.location.href = '/cart';
        return;
      }
      notification(res.data.message);
    }
  });
};

(async () => {
  addEVH2();
  filters();
  payment();
})();
