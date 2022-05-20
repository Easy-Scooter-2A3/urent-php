(async () => {
  const tmpElem = document.getElementById('tmp');
  if (tmpElem) {
    tmpElem.remove();
  }
  const sizes = {
    selected: [
      'w-12',
      'h-12',
      'border-2',
      'border-zinc-800',
    ],
    unselected: [
      'w-10',
      'h-10',
      'border-0',
      'border-transparent',
    ],
  };
  const elems = document.querySelectorAll('[day-circle]');
  elems.forEach((button) => {
    button.addEventListener('click', () => {
      console.log('clicked');
      elems.forEach((elem) => {
        if (elem === button) {
          elem.classList.add(...sizes.selected);
          elem.classList.remove(...sizes.unselected);
        } else {
          elem.classList.remove(...sizes.selected);
          elem.classList.add(...sizes.unselected);
        }
      });
    });
  });
})();
