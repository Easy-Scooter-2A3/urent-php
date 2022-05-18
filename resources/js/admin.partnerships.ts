import axios from 'axios';
import Iproduct from './interfaces/product';
import searchField from './searchField';
import selectedRows from './selectedRows';
import { doPost, doDelete, doPut } from './utils';
import { MDCSwitch } from '@material/switch';
import { MDCTextField } from '@material/textfield';

const checkAll = (checked: boolean) => {
    const inputs = document.querySelectorAll<HTMLInputElement>('input[type="checkbox"]');
    inputs.forEach((element) => {
        element.checked = checked;
    });
}

const getDetails = async (partnership: (string | null)[]) => {
    try {
        const res = await axios.post(`/dashboard/admin/partnership/details`, {partnership});
        if (res.status === 200) {
            return [res.data.data, res.data.attributes];
        }
    } catch (error) {
        if (axios.isAxiosError(error)) {
            console.log(error)
        }
        return null;
    }
}

const toMDCTextField = (element: HTMLElement | null) => {
    if (!element || !element.parentElement) {
        return null;
    }

    return new MDCTextField(element.parentElement);
}

// const fillFields = async (productId: string) => {
//     // define them as MDCTextField
//     const modalFields = {
//         name: toMDCTextField(document.getElementById('modal-edit-name')) as MDCTextField,
//         price: toMDCTextField(document.getElementById('modal-edit-price')) as MDCTextField,
//         description: toMDCTextField(document.getElementById('modal-edit-description')) as MDCTextField,
//         stock: toMDCTextField(document.getElementById('modal-edit-stock')) as MDCTextField,
//         available: document.getElementById('modal-edit-available') as HTMLInputElement,
//     }

//     const someValueNull = Object.values(modalFields).some((element) => !element);
//     if (someValueNull) {
//         console.error('Some values are null');
//         return;
//     }

//     const data = await getDetails([productId]) as [Iproduct[], {[k: number]: number[]}[]];
//     const products = data[0];
//     const attributesGlobal = data[1];
//     if (!products || !attributesGlobal) {
//         console.error('Could not get details');
//         return;
//     };
//     const product = products[0];
//     if (!product) {
//         console.error('Could not get product');
//         return;
//     };

//     modalFields.name.value = product.name;
//     modalFields.price.value = product.price.toString();	
//     modalFields.description.value = product.description;
//     modalFields.stock.value = product.stock.toString();
//     modalFields.available.value = product.available ? 'Yes' : 'No';

//     attributesGlobal.forEach(attributes => {
//         for (const key in attributes) {
//             for (const attribute of attributes[key]) {
//                 const query = `input[productattribute-edit="${attribute}"]`;
//                 const elems = document.querySelectorAll<HTMLInputElement>(query);
//                 if (!elems) {
//                     console.error('Could not find element');
//                     continue;
//                 }
//                 elems.forEach((element) => {
//                     if (element.getAttribute('edit') != null) {
//                         element.checked = true;
//                     }
//                 });
//             }
//         }
//     });
// }

(async () => {
    // const confirmEditBtn = document.getElementById('confirmEditBtn') as HTMLButtonElement | null;
    const confirmCreationBtn = document.getElementById('confirmCreationBtn') as HTMLButtonElement | null;

    // const editBtn = document.getElementById('editBtn') as HTMLButtonElement | null;

    const searchInput = document.getElementById("searchField") as HTMLInputElement | null;

    const checkboxAll = document.getElementById('checkbox-all') as HTMLInputElement | null;

    // const modalFieldsEdit = {
    //     name: toMDCTextField(document.getElementById('modal-edit-name')) as MDCTextField,
    //     from_date: toMDCTextField(document.getElementById('modal-edit-from_date')) as MDCTextField,
    //     to_date: toMDCTextField(document.getElementById('modal-edit-to_date')) as MDCTextField,
    //     voucher: toMDCTextField(document.getElementById('modal-edit-voucher')) as MDCTextField,
    //     max_people: toMDCTextField(document.getElementById('modal-edit-max_people')) as MDCTextField,
    //     active: new MDCSwitch(document.getElementById('modal-edit-active') as HTMLButtonElement) as MDCSwitch,
    // }

    const modalFieldsCreation = {
        name: toMDCTextField(document.getElementById('modal-creation-name')) as MDCTextField,
        from_date: toMDCTextField(document.getElementById('modal-creation-from_date')) as MDCTextField,
        to_date: toMDCTextField(document.getElementById('modal-creation-to_date')) as MDCTextField,
        voucher: toMDCTextField(document.getElementById('modal-creation-voucher')) as MDCTextField,
        max_people: toMDCTextField(document.getElementById('modal-creation-max_people')) as MDCTextField,
        active: new MDCSwitch(document.getElementById('modal-creation-active') as HTMLButtonElement),
    }

    if (!searchInput) {
        console.error("Could not find search input");
        return;
    }

    if (!checkboxAll) {
        console.error("Could not find checkbox-all");
        return;
    }

    // if (!editBtn) {
    //     console.error("Could not find editBtn");
    //     return;
    // }

    if (!confirmCreationBtn) {
        console.error("Could not find confirmCreation");
        return;
    }

    // if (!confirmEditBtn) {
    //     console.error("Could not find confirmEdit");
    //     return;
    // }

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

    // editBtn.addEventListener('click', async function (e: MouseEvent) {
    //     const products = selectedRows("[productid]").map((element) => element.getAttribute("productid"));
    //     if (products.length === 0) {
    //         console.log("No products selected");
    //         e.preventDefault(); // TODO: make it work
    //         return;
    //     }
    //     const id = products.shift();
    //     if (!id) {
    //         console.log("No products selected");
    //         e.preventDefault(); // TODO: make it wo
    //         return;
    //     }

    //     editBtn.setAttribute('productid', id);
    //     fillFields(id);
    // });

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

        //TODO: send data to server
        
        if (await doPost('/dashboard/admin/partnerships', data)) {
            window.location.reload();
        }
    });

    // confirmEditBtn.addEventListener('click', async function (e: MouseEvent) {
    //     const id = editBtn.getAttribute('productid');
    //     if (!id) {
    //         console.error("Could not find product id");
    //         return;
    //     }

    //     const attributes = selectedRows('[productattribute-edit]').map((element) => element.getAttribute("productattribute-edit"));

    //     const data = {
    //         name: modalFieldsEdit.name!.value,
    //         price: modalFieldsEdit.price!.value,
    //         description: modalFieldsEdit.description!.value,
    //         stock: modalFieldsEdit.stock!.value,
    //         available: modalFieldsEdit.available!.selected,
    //         attributes: [...attributes],
    //     }

    //     if (await doPut(`/dashboard/admin/products/${id}`, data)) {
    //         window.location.reload();
    //     }
    // });

    checkboxAll.addEventListener('click', function (e: MouseEvent) {
        console.log('checkbox-all clicked');
        checkAll(checkboxAll.checked);
    });

    searchInput.addEventListener('keyup', (e) => {
        searchField(e, 1, '[productidParent]');
    });
})();
