/* eslint-disable import/no-unresolved */
/* eslint-disable import/extensions */
import { MDCSwitch } from '@material/switch';
import { MDCTextField } from '@material/textfield';
import { MDCDataTable } from '@material/data-table';
import IPartnership from './interfaces/partnership';
import IPartnershipProduct from './interfaces/partnership_product';
import IUser from './interfaces/user';
import searchField from './searchField';
import { doPost, doPut, doGet } from './utils';
import IProduct from './interfaces/product';

const toMDCTextField = (element: HTMLElement | null) => {
  if (!element || !element.parentElement) {
    return null;
  }

  return new MDCTextField(element.parentElement);
};

const modalFieldsEdit = {
  name: toMDCTextField(document.getElementById('modal-edit-name')) as MDCTextField,
  from_date: toMDCTextField(document.getElementById('modal-edit-from_date')) as MDCTextField,
  to_date: toMDCTextField(document.getElementById('modal-edit-to_date')) as MDCTextField,
  voucher: toMDCTextField(document.getElementById('modal-edit-voucher')) as MDCTextField,
  max_people: toMDCTextField(document.getElementById('modal-edit-max_people')) as MDCTextField,
  active: new MDCSwitch(document.getElementById('modal-edit-active') as HTMLButtonElement),
};

const modalFieldsCreation = {
  name: toMDCTextField(document.getElementById('modal-creation-name')) as MDCTextField,
  from_date: toMDCTextField(document.getElementById('modal-creation-from_date')) as MDCTextField,
  to_date: toMDCTextField(document.getElementById('modal-creation-to_date')) as MDCTextField,
  voucher: toMDCTextField(document.getElementById('modal-creation-voucher')) as MDCTextField,
  max_people: toMDCTextField(document.getElementById('modal-creation-max_people')) as MDCTextField,
  active: new MDCSwitch(document.getElementById('modal-creation-active') as HTMLButtonElement),
};

const getDetails = async (partnershipsId: (string | null)) => {
  const res = await doPost('/dashboard/admin/partnerships/details', { partnershipsId });
  return res ? [res.data.partnership, res.data.users, res.data.products] : null;
};

const fillFields = async (partnershipId: string, table: MDCDataTable) => {
  const usersList = document.getElementById('usersList');
  if (!usersList) {
    console.log('usersList not found');
    return;
  }

  const data = await getDetails(partnershipId) as [IPartnership, IUser[], IPartnershipProduct[]];
  if (!data) {
    console.error('Error getting data');
    return;
  }

  const productsRes = await doGet(`/dashboard/admin/partnerships/${partnershipId}/list`);
  if (!productsRes) {
    console.error('Error getting products');
    return;
  }

  const [partnership, users, products] = data;

  const list = products.map((product) => product.product_id.toString());
  table.setSelectedRowIds(list);

  const {
    name, from_date, to_date, voucher, max_people, active,
  } = partnership as IPartnership;
  modalFieldsEdit.name.value = name;
  modalFieldsEdit.from_date.value = from_date.split(' ')[0];
  modalFieldsEdit.to_date.value = to_date.split(' ')[0];
  modalFieldsEdit.voucher.value = String(voucher);
  modalFieldsEdit.max_people.value = String(max_people);
  modalFieldsEdit.active.selected = active;

  usersList.innerHTML = '';
  users.forEach((user) => {
    // TODO: check shadowing
    const { id, name } = user as IUser;
    const e = document.createElement('h2');
    e.textContent = `${id} - ${name}`;
    usersList.appendChild(e);
  });
};

(async () => {
  const confirmEditBtn = document.getElementById('confirmEditBtn') as HTMLButtonElement | null;
  const editBtn = document.getElementById('editBtn') as HTMLButtonElement | null;
  const confirmCreationBtn = document.getElementById('confirmCreationBtn') as HTMLButtonElement | null;

  const searchInput = document.getElementById('searchField') as HTMLInputElement | null;

  const dataTable = new MDCDataTable(document.getElementById('dataTable') as HTMLElement);
  const dataTableCreation = new MDCDataTable(document.getElementById('dataTableCreation') as HTMLElement);
  const dataTableEdit = new MDCDataTable(document.getElementById('dataTableEdit') as HTMLElement);

  if (!searchInput) {
    console.error('Could not find search input');
    return;
  }

  if (!editBtn) {
    console.error('Could not find editBtn');
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

  // const someValueNull = Object.values(modalFieldsEdit).some((element) => !element);
  // if (someValueNull) {
  //     console.error('Some values are null');
  //     return;
  // }

  const someValueNull = Object.values(modalFieldsCreation).some((element) => !element);
  if (someValueNull) {
    console.error('Some values are null');
    return;
  }

  editBtn.addEventListener('click', async (_e: MouseEvent) => {
    const partnerships = dataTable.getSelectedRowIds();
    if (partnerships.length === 0) {
      console.log('No partnerships selected');
      _e.preventDefault(); // TODO: make it work
      return;
    }
    const id = partnerships.shift();
    if (!id) {
      console.log('No partnerships selected');
      _e.preventDefault(); // TODO: make it wo
      return;
    }

    editBtn.setAttribute('productid', id);
    fillFields(id, dataTableEdit);
  });

  confirmCreationBtn.addEventListener('click', async (_e: MouseEvent) => {
    const products = dataTableCreation.getSelectedRowIds();

    const data = {
      name: modalFieldsCreation.name.value,
      from_date: (new Date(modalFieldsCreation.from_date.value)).toUTCString(),
      to_date: (new Date(modalFieldsCreation.to_date.value)).toUTCString(),
      voucher: parseFloat(modalFieldsCreation.voucher.value),
      max_people: parseInt(modalFieldsCreation.max_people.value, 10),
      active: modalFieldsCreation.active.selected,
      products: [...products],
    };

    console.log(data);

    if (await doPost('/dashboard/admin/partnerships', data)) {
      window.location.reload();
    }
  });

  confirmEditBtn.addEventListener('click', async (e: MouseEvent) => {
    const id = editBtn.getAttribute('productid');
    if (!id) {
      console.error('Could not find product id');
      return;
    }

    const products = dataTableEdit.getSelectedRowIds();

    const data = {
      id,
      name: modalFieldsEdit.name.value,
      from_date: (new Date(modalFieldsEdit.from_date.value)).toUTCString(),
      to_date: (new Date(modalFieldsEdit.to_date.value)).toUTCString(),
      voucher: parseFloat(modalFieldsEdit.voucher.value),
      max_people: parseInt(modalFieldsEdit.max_people.value, 10),
      active: modalFieldsEdit.active.selected,
      products: [...products],
    };

    if (await doPut(`/dashboard/admin/partnerships/${id}`, data)) {
      window.location.reload();
    }
  });

  const checkboxes = {
    creationParent: document.getElementById('modal-creation') as HTMLInputElement,
    editParent: document.getElementById('modal-edit') as HTMLInputElement,
  };

  if (Object.values(checkboxes).some((element) => !element)) {
    console.error('Could not find a checkbox');
    return;
  }

  searchInput.addEventListener('keyup', (_e) => {
    searchField(_e, '[partnershipidParent]');
  });
})();
