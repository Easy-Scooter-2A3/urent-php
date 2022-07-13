const searchField = (input: KeyboardEvent, querySelector: string, childrenNb?: number) => {
  const target = input.target as HTMLInputElement;
  if (!target) {
    return;
  }

  const regex = new RegExp(target.value, 'i');

  const list = document.querySelectorAll<HTMLElement>(querySelector);
  if (target.value.length === 0) {
    list.forEach((element) => {
      element.removeAttribute('hidden');
    });
    return;
  }

  if (!childrenNb) {
    list.forEach((element) => {
      const name = element.textContent;
      element.hidden = !(name && name.match(regex));
    });
    return;
  }

  list.forEach((element) => {
    const name = element.children[childrenNb]?.textContent;
    element.hidden = !(name && name.match(regex));
  });
};

export default searchField;
