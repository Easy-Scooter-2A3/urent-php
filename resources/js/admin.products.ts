/* eslint-disable import/no-unresolved */
/* eslint-disable import/extensions */
import { MDCSwitch } from '@material/switch';
import { MDCDataTable } from '@material/data-table';
import { MDCTextField } from '@material/textfield';
import Iproduct from './interfaces/product';
import searchField from './searchField';
import selectedRows from './selectedRows';
import { doPost, doPut } from './utils';
import notification from './notif';

const getDetails = async (product: (string | null)) => {
  const res = await doPost('/dashboard/admin/products/details', { product });
  if (res) {
    return [
      res.data.data,
      res.data.attributes.map((attribute: any) => attribute.attribute_id),
      res.data.nbAchats,
    ];
  }
  return null;
};

const toMDCTextField = (element: HTMLElement | null) => {
  if (!element || !element.parentElement) {
    return null;
  }

  return new MDCTextField(element.parentElement);
};

const fillFields = async (productId: string) => {
  // define them as MDCTextField
  const modalFields = {
    name: toMDCTextField(document.getElementById('modal-edit-name')) as MDCTextField,
    price: toMDCTextField(document.getElementById('modal-edit-price')) as MDCTextField,
    description: toMDCTextField(document.getElementById('modal-edit-description')) as MDCTextField,
    stock: toMDCTextField(document.getElementById('modal-edit-stock')) as MDCTextField,
    available: new MDCSwitch(document.getElementById('modal-edit-available') as HTMLButtonElement) as MDCSwitch,
  };

  const someValueNull = Object.values(modalFields).some((element) => !element);
  if (someValueNull) {
    console.error('Some values are null');
    return;
  }

  const data = await getDetails(productId) as [Iproduct, number[], number];
  const product = data[0];
  const attributes = data[1];
  if (!product || !attributes) {
    console.error('Could not get details');
    return;
  }
  if (!product) {
    console.error('Could not get product');
    return;
  }

  modalFields.name.value = product.name;
  modalFields.price.value = product.price.toString();
  modalFields.description.value = product.description;
  modalFields.stock.value = product.stock.toString();

  modalFields.available.selected = Boolean(product.available);

  attributes.forEach((attribute) => {
    const query = `input[productattribute-edit="${attribute}"]`;
    const elems = document.querySelectorAll<HTMLInputElement>(query);
    if (elems) {
      elems.forEach((element) => {
        if (element.getAttribute('edit') != null) {
          element.checked = true;
        }
      });
    }
  });
};

(async () => {
  const confirmEditBtn = document.getElementById('confirmEditBtn') as HTMLButtonElement | null;
  const confirmCreationBtn = document.getElementById('confirmCreationBtn') as HTMLButtonElement | null;
  const uploadEditBtn = document.getElementById('uploadEditBtn') as HTMLButtonElement | null;
  const uploadCreateBtn = document.getElementById('uploadCreateBtn') as HTMLButtonElement | null;

  const deleteBtn = document.getElementById('deleteBtn') as HTMLButtonElement | null;
  const editBtn = document.getElementById('editBtn') as HTMLButtonElement | null;

  const searchInput = document.getElementById('searchField') as HTMLInputElement | null;
  const viewDetailsBtn = document.getElementById('viewDetailsBtn') as HTMLButtonElement | null;

  const detailsBody = document.getElementById('modal-details-body') as HTMLElement | null;
  const detailsBodyTemplate = document.getElementById('modal-details-body-template') as HTMLTemplateElement | null;

  const dataTable = new MDCDataTable(document.querySelector('.mdc-data-table') as HTMLElement);

  const fileLoadedEdit = document.getElementById('fileLoadedEdit');
  if (!fileLoadedEdit) {
    console.error('Could not find fileLoadedEdit');
    return;
  }

  const fileLoadedCreate = document.getElementById('fileLoadedCreate');
  if (!fileLoadedCreate) {
    console.error('Could not find fileLoadedCreate');
    return;
  }

  const modalFieldsCreation = {
    name: toMDCTextField(document.getElementById('modal-creation-name')) as MDCTextField,
    price: toMDCTextField(document.getElementById('modal-creation-price')) as MDCTextField,
    description: toMDCTextField(document.getElementById('modal-creation-description')) as MDCTextField,
    stock: toMDCTextField(document.getElementById('modal-creation-stock')) as MDCTextField,
    available: new MDCSwitch(document.getElementById('modal-creation-available') as HTMLButtonElement) as MDCSwitch,
    image: document.getElementById('imageCreate') as HTMLInputElement,
  };

  const modalFieldsEdit = {
    name: toMDCTextField(document.getElementById('modal-edit-name')) as MDCTextField,
    price: toMDCTextField(document.getElementById('modal-edit-price')) as MDCTextField,
    description: toMDCTextField(document.getElementById('modal-edit-description')) as MDCTextField,
    stock: toMDCTextField(document.getElementById('modal-edit-stock')) as MDCTextField,
    available: new MDCSwitch(document.getElementById('modal-edit-available') as HTMLButtonElement) as MDCSwitch,
    image: document.getElementById('imageEdit') as HTMLInputElement,
  };

  if (!detailsBody || !detailsBodyTemplate) {
    console.error('Could not find modal-details-body or modal-details-body-template');
    return;
  }

  if (!searchInput || !viewDetailsBtn) {
    console.error('Could not find search input');
    return;
  }

  if (!deleteBtn) {
    console.error('Could not find deleteBtn');
    return;
  }

  if (!editBtn) {
    console.error('Could not find deleteBtn');
    return;
  }

  if (!uploadEditBtn) {
    console.error('Could not find uploadEditBtn');
    return;
  }

  if (!uploadCreateBtn) {
    console.error('Could not find uploadCreateBtn');
    return;
  }

  if (!confirmCreationBtn) {
    console.error('Could not find confirmCreation');
    return;
  }

  if (!confirmEditBtn) {
    console.error('Could not find confirmEdit');
    return;
  }

  if (Object.values(modalFieldsEdit).some((element) => !element)) {
    console.error('Some values are null');
    return;
  }

  if (Object.values(modalFieldsCreation).some((element) => !element)) {
    console.error('Some values are null');
    return;
  }

  uploadEditBtn.addEventListener('click', () => {
    fileLoadedEdit.hidden = true;
    modalFieldsEdit.image.click();
  });

  modalFieldsEdit.image.onchange = async () => {
    if (!modalFieldsEdit.image.files) {
      return;
    }

    const file = modalFieldsEdit.image.files[0];
    if (!file) {
      return;
    }

    fileLoadedEdit.hidden = false;
  };

  uploadCreateBtn.addEventListener('click', () => {
    fileLoadedCreate.hidden = true;
    modalFieldsCreation.image.click();
  });

  modalFieldsCreation.image.onchange = async () => {
    if (!modalFieldsCreation.image.files) {
      return;
    }

    const file = modalFieldsCreation.image.files[0];
    if (!file) {
      return;
    }

    fileLoadedCreate.hidden = false;
  };

  deleteBtn.addEventListener('click', async (e: MouseEvent) => {
    // TODO: dialog
    if (!confirm('Are you sure you want to delete these products?')) return;
    const products = dataTable.getSelectedRowIds();

    if (products.length === 0) {
      e.preventDefault();
      return;
    }

    const data = {
      products,
    };

    if (await doPost('/dashboard/admin/products/delete', data)) {
      window.location.reload();
    }
  });

  editBtn.addEventListener('click', async (e: MouseEvent) => {
    // check
    const products = dataTable.getSelectedRowIds();
    if (products.length === 0) {
      console.log('No products selected');
      e.preventDefault(); // TODO: make it work
      return;
    }
    const id = products.shift();
    if (!id) {
      console.log('No products selected');
      e.preventDefault(); // TODO: make it wo
      return;
    }

    editBtn.setAttribute('productid', id);
    fillFields(id);
  });

  confirmCreationBtn.addEventListener('click', async (_e: MouseEvent) => {
    const attributes = selectedRows('[productattribute]').map((element) => element.getAttribute('productattribute'));

    const data = {
      name: modalFieldsCreation.name.value,
      price: modalFieldsCreation.price.value,
      description: modalFieldsCreation.description.value,
      stock: modalFieldsCreation.stock.value,
      available: modalFieldsCreation.available.selected,
      attributes: [...attributes],
    };

    const formData = new FormData();

    if (!modalFieldsCreation.image.files || modalFieldsCreation.image.files.length === 0) {
      notification('No image selected');
      return;
    }

    const file = modalFieldsCreation.image.files[0];
    formData.append('name', data.name);
    formData.append('price', data.price);
    formData.append('description', data.description);
    formData.append('stock', data.stock);
    formData.append('available', JSON.stringify(data.available));
    formData.append('attributes', JSON.stringify(data.attributes));
    formData.append('image', file);

    if (await doPost('/dashboard/admin/products', formData)) {
      window.location.reload();
    }
  });

  confirmEditBtn.addEventListener('click', async (_e: MouseEvent) => {
    const id = editBtn.getAttribute('productid');
    if (!id) {
      console.error('Could not find product id');
      return;
    }

    const attributes = selectedRows('[productattribute-edit]').map((element) => element.getAttribute('productattribute-edit'));

    const data = {
      name: modalFieldsEdit.name!.value,
      price: modalFieldsEdit.price!.value,
      description: modalFieldsEdit.description!.value,
      stock: modalFieldsEdit.stock!.value,
      available: modalFieldsEdit.available!.selected,
      attributes: [...attributes],
    };

    const formData = new FormData();

    if (modalFieldsEdit.image.files && modalFieldsEdit.image.files[0]) {
      const file = modalFieldsEdit.image.files[0];
      formData.append('image', file);
    }

    formData.append('name', data.name);
    formData.append('price', data.price);
    formData.append('description', data.description);
    formData.append('stock', data.stock);
    formData.append('available', JSON.stringify(data.available));
    formData.append('attributes', JSON.stringify(data.attributes));

    if (await doPost(`/dashboard/admin/products/${id}`, formData)) {
      window.location.reload();
    }
  });

  viewDetailsBtn.addEventListener('click', async (_e: MouseEvent) => {
    detailsBody.innerHTML = '';
    console.log('viewDetailsBtn clicked');
    const productsRows = dataTable.getSelectedRowIds();
    if (productsRows.length === 0) {
      return;
    }

    let n = 0;
    productsRows.forEach(async (id) => {
      n += 1;
      const [product, attributes, nbAchats] = await getDetails(id) as [Iproduct, number[], number];
      if (product) {
        const clone = document.importNode(detailsBodyTemplate.content, true);
        const fields = clone.querySelectorAll('h2');
        fields[0].textContent += `${product.id}`;
        fields[1].textContent += product.name;
        fields[2].textContent += `${product.price}`;
        fields[3].textContent += product.description;
        fields[4].textContent += `${product.stock}`;
        fields[5].textContent += nbAchats.toString();
        fields[6].textContent += `${product.available ? 'Yes' : 'No'}`;

        detailsBody.appendChild(clone);
        if (n !== productsRows.length) {
          detailsBody.appendChild(document.createElement('hr'));
        }
      }
    });
  });

  searchInput.addEventListener('keyup', (e) => {
    searchField(e, '[productidParent]');
  });
})();
