/* eslint-disable import/no-unresolved */
/* eslint-disable import/extensions */
import { MDCTextField } from '@material/textfield';
import { filters } from './filters';
import notification from './notif';
import { doPost } from './utils';

const addToCart = async (productId: number, quantity: number) => {
  try {
    if (await doPost('/cart/add', { productId, quantity })) {
      notification('Added to cart');
    } else {
      notification('Failed to add to cart');
    }
  } catch (error) {
    notification('You must be authenticated');
  }
};

const addEVH = () => {
  const catalogue = document.getElementById('catalogue');
  if (!catalogue) {
    console.log('No catalogue found');
    return;
  }

  catalogue.addEventListener('click', (event) => {
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

    const quantityMCD = new MDCTextField(quantityElem.parentElement);
    const quantity = quantityMCD.value.length === 0 ? 1 : parseInt(quantityMCD.value, 10);

    if (quantity === 0) {
      notification('Quantity must be greater than 0');
      return;
    }

    addToCart(parseInt(productId, 10), quantity);
  });
};

(async () => {
  addEVH();
  filters();
})();
