// eslint-disable-next-line no-undef
const checkAll = (checked: boolean, parentNode: ParentNode) => {
  const inputs = parentNode.querySelectorAll<HTMLInputElement>('input[type="checkbox"]');
  inputs.forEach((element) => {
    element.checked = checked;
  });
};

export default checkAll;
