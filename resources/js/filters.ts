const updateProducts = (activeAttributes: Set<number>) => {
  const elems = document.querySelectorAll('tr[rowid]');

  elems.forEach((elem) => {
    const list = elem.querySelectorAll('td > div > ul')[0];

    if (activeAttributes.size > 0) {
      Array.from(list.children).forEach((child) => {
        const attr = child.getAttribute('attr');
        if (attr && activeAttributes.has(parseInt(attr, 10))) {
          elem.classList.remove('hidden');
        } else {
          elem.classList.add('hidden');
        }
      });
    }
  });
};

const filters = () => {
  const attributes = document.querySelectorAll('input[type=checkbox]');

  const attributesToShow = new Set<number>();
  attributes.forEach((filter) => {
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
        attributesToShow.add(parseInt(attributeId, 10));
      } else {
        attributesToShow.delete(parseInt(attributeId, 10));
      }
      updateProducts(attributesToShow);
    });
  });
};

export { filters, updateProducts };
