import { MDCCheckbox } from '@material/checkbox';

const getSelectedCard = () => {
  const cards = document.getElementsByName('payment-card');

  const card = Array.from(cards).find((card) => {
    const cardElem = new MDCCheckbox(card.parentElement!);
    if (cardElem.checked) {
      return card.getAttribute('paymentMethod');
    }
    return null;
  });

  return card?.getAttribute('paymentMethod');
};

export default getSelectedCard;
