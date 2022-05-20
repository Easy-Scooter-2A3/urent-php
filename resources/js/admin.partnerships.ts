import axios from 'axios';
import IPartnership from './interfaces/partnership';
import IUser from './interfaces/user';
import searchField from './searchField';
import selectedRows from './selectedRows';
import { doPost, doDelete, doPut, doGet } from './utils';
import { MDCSwitch } from '@material/switch';
import { MDCTextField } from '@material/textfield';
import IProduct from './interfaces/product';

const toMDCTextField = (element: HTMLElement | null) => {
    if (!element || !element.parentElement) {
        return null;
    }

    return new MDCTextField(element.parentElement);
}

const modalFieldsEdit = {
    name: toMDCTextField(document.getElementById('modal-edit-name')) as MDCTextField,
    from_date: toMDCTextField(document.getElementById('modal-edit-from_date')) as MDCTextField,
    to_date: toMDCTextField(document.getElementById('modal-edit-to_date')) as MDCTextField,
    voucher: toMDCTextField(document.getElementById('modal-edit-voucher')) as MDCTextField,
    max_people: toMDCTextField(document.getElementById('modal-edit-max_people')) as MDCTextField,
    active: new MDCSwitch(document.getElementById('modal-edit-active') as HTMLButtonElement),
}

const modalFieldsCreation = {
    name: toMDCTextField(document.getElementById('modal-creation-name')) as MDCTextField,
    from_date: toMDCTextField(document.getElementById('modal-creation-from_date')) as MDCTextField,
    to_date: toMDCTextField(document.getElementById('modal-creation-to_date')) as MDCTextField,
    voucher: toMDCTextField(document.getElementById('modal-creation-voucher')) as MDCTextField,
    max_people: toMDCTextField(document.getElementById('modal-creation-max_people')) as MDCTextField,
    active: new MDCSwitch(document.getElementById('modal-creation-active') as HTMLButtonElement),
}

const checkAll = (checked: boolean, parentNode: ParentNode) => {
    const inputs = parentNode.querySelectorAll<HTMLInputElement>('input[type="checkbox"]');
    inputs.forEach((element) => {
        element.checked = checked;
    });
}

const getDetails = async (partnershipsIds: (string | null)[]) => {
    const res = await doPost('/dashboard/admin/partnership/details', { partnershipsIds });
    if (res) {
        return res.data.data;
    }
}

const fillFields = async (partnershipId: string) => {

    const usersList = document.getElementById('usersList');
    if (!usersList) {
        console.log("usersList not found");
        return;
    }

    const data = await getDetails([partnershipId]);
    if (!data) {
        console.error('Error getting data');
        return;
    }

    // const productsRows = selectedRows('[productattribute]').map((element) => element.getAttribute("productattribute"));

    const productsRes = await doGet(`/dashboard/admin/partnerships/${partnershipId}/list`);
    if (!productsRes) {
        console.error('Error getting products');
        return;
    }

    //no interface
    const products = new Set<string>(productsRes.data.data.map((x: any) => String(x.product_id)));
    console.log(products);
    const productsFields = document.querySelectorAll<HTMLInputElement>('[productattribute-edit]');
    console.log(productsFields);
    productsFields.forEach((element) => {
        const attr = element.getAttribute('productattribute-edit');
        element.checked = products.has(attr ?? '');
    });

    for (const partnershipId2 in data) {
        if (Object.prototype.hasOwnProperty.call(data, partnershipId2)) {
            const fullData = data[partnershipId2] as {partnership: IPartnership[], users: IUser[]};
            if (!fullData) {
                console.error('Error getting data');
                return;
            }

            const { partnership, users } = fullData;
            if (!partnership || !users) {
                console.error('Error getting data');
                return;
            }

            const { name, from_date, to_date, voucher, max_people, active } = partnership.shift() as IPartnership;
            modalFieldsEdit.name.value = name;
            modalFieldsEdit.from_date.value = from_date.split(" ")[0]
            modalFieldsEdit.to_date.value = to_date.split(" ")[0];
            modalFieldsEdit.voucher.value = String(voucher);
            modalFieldsEdit.max_people.value = String(max_people);
            modalFieldsEdit.active.selected = active;

            for (const user of users) {
                const e = document.createElement('h2');
                e.textContent = `${user.id} - ${user.name}`;
                usersList.appendChild(e);
            }
            
        }
    }
}

(async () => {
    const confirmEditBtn = document.getElementById('confirmEditBtn') as HTMLButtonElement | null;
    const editBtn = document.getElementById('editBtn') as HTMLButtonElement | null;
    const confirmCreationBtn = document.getElementById('confirmCreationBtn') as HTMLButtonElement | null;


    const searchInput = document.getElementById("searchField") as HTMLInputElement | null;


    if (!searchInput) {
        console.error("Could not find search input");
        return;
    }

    if (!editBtn) {
        console.error("Could not find editBtn");
        return;
    }

    if (!confirmCreationBtn) {
        console.error("Could not find confirmCreation");
        return;
    }

    if (!confirmEditBtn) {
        console.error("Could not find confirmEdit");
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

    editBtn.addEventListener('click', async function (e: MouseEvent) {
        const partnerships = selectedRows("[partnershipid]").map((element) => element.getAttribute("partnershipid"));
        if (partnerships.length === 0) {
            console.log("No partnerships selected");
            e.preventDefault(); // TODO: make it work
            return;
        }
        const id = partnerships.shift();
        if (!id) {
            console.log("No partnerships selected");
            e.preventDefault(); // TODO: make it wo
            return;
        }

        editBtn.setAttribute('productid', id);
        fillFields(id);
    });

    confirmCreationBtn.addEventListener('click', async function (e: MouseEvent) {
        const products = selectedRows('[productattribute]').map((element) => element.getAttribute("productattribute"));

        const data = {
            name: modalFieldsCreation.name.value,
            from_date: (new Date(modalFieldsCreation.from_date.value)).toUTCString(),
            to_date: (new Date(modalFieldsCreation.to_date.value)).toUTCString(),
            voucher: parseFloat(modalFieldsCreation.voucher.value),
            max_people: parseInt(modalFieldsCreation.max_people.value),
            active: modalFieldsCreation.active.selected,
            products: [...products],
        }

        console.log(data)
        
        if (await doPost('/dashboard/admin/partnerships', data)) {
            window.location.reload();
        }
    });

    confirmEditBtn.addEventListener('click', async function (e: MouseEvent) {
        const id = editBtn.getAttribute('productid');
        if (!id) {
            console.error("Could not find product id");
            return;
        }

        const products = selectedRows('[productattribute-edit]').map((element) => element.getAttribute("productattribute-edit"));

        const data = {
            id,
            name: modalFieldsEdit.name.value,
            from_date: (new Date(modalFieldsEdit.from_date.value)).toUTCString(),
            to_date: (new Date(modalFieldsEdit.to_date.value)).toUTCString(),
            voucher: parseFloat(modalFieldsEdit.voucher.value),
            max_people: parseInt(modalFieldsEdit.max_people.value),
            active: modalFieldsEdit.active.selected,
            products: [...products],
        }

        if (await doPut(`/dashboard/admin/partnerships/${id}`, data)) {
            window.location.reload();
        }
    });

    const checkboxes = {
        main: document.getElementById('checkbox-all-main') as HTMLInputElement,
        edit: document.getElementById('checkbox-all-edit') as HTMLInputElement,
        creation: document.getElementById('checkbox-all-creation') as HTMLInputElement,
        
        mainParent: document.getElementById('modal-main') as HTMLInputElement,
        creationParent: document.getElementById('modal-creation') as HTMLInputElement,
        editParent: document.getElementById('modal-edit') as HTMLInputElement,
    }

    if (Object.values(checkboxes).some((element) => !element)) {
        console.error("Could not find a checkbox-all");
        return;
    }

    checkboxes.main.addEventListener('click', function (e: MouseEvent) {
        console.log('checkbox-all clicked');
        checkAll(checkboxes.main.checked, checkboxes.mainParent);
    });

    checkboxes.edit.addEventListener('click', function (e: MouseEvent) {
        console.log('checkbox-all edit clicked');
        checkAll(checkboxes.edit.checked, checkboxes.editParent);
    });

    checkboxes.creation.addEventListener('click', function (e: MouseEvent) {
        console.log('checkbox-all creation clicked');
        checkAll(checkboxes.creation.checked, checkboxes.creationParent);
    });

    searchInput.addEventListener('keyup', (e) => {
        searchField(e, 1, '[partnershipidParent]');
    });
})();
