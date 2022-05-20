// eslint-disable-next-line no-undef
const checkAll = (checked: boolean, parentNode: ParentNode) => {
  const inputs = parentNode.querySelectorAll<HTMLInputElement>('input[type="checkbox"]');
  inputs.forEach((element) => {
    // element is in the DOM, so it can be reassigned
    // eslint-disable-next-line no-param-reassign
    element.checked = checked;
  });
};

export default checkAll;
