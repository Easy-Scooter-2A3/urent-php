import { MDCCheckbox } from '@material/checkbox';

const getSelectedCard = () => {
  const cards = document.getElementsByName('payment-card');

  const card = Array.from(cards).find((_card) => {
    const cardElem = new MDCCheckbox(_card.parentElement!);
    if (cardElem.checked) {
      return _card.getAttribute('paymentMethod');
    }
    return null;
  });

  return card?.getAttribute('paymentMethod');
};

export default getSelectedCard;
