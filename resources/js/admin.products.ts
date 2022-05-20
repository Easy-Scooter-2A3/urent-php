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

const getDetails = async (products: (string | null)[]) => {
    const res = await doPost('/dashboard/admin/product/details', { products });
    if (res) {
        return [res.data.data, res.data.attributes];
    }
}

const toMDCTextField = (element: HTMLElement | null) => {
    if (!element || !element.parentElement) {
        return null;
    }

    return new MDCTextField(element.parentElement);
}

const fillFields = async (productId: string) => {
    // define them as MDCTextField
    const modalFields = {
        name: toMDCTextField(document.getElementById('modal-edit-name')) as MDCTextField,
        price: toMDCTextField(document.getElementById('modal-edit-price')) as MDCTextField,
        description: toMDCTextField(document.getElementById('modal-edit-description')) as MDCTextField,
        stock: toMDCTextField(document.getElementById('modal-edit-stock')) as MDCTextField,
        available: document.getElementById('modal-edit-available') as HTMLInputElement,
    }

    const someValueNull = Object.values(modalFields).some((element) => !element);
    if (someValueNull) {
        console.error('Some values are null');
        return;
    }

    const data = await getDetails([productId]) as [Iproduct[], {[k: number]: number[]}[]];
    const products = data[0];
    const attributesGlobal = data[1];
    if (!products || !attributesGlobal) {
        console.error('Could not get details');
        return;
    };
    const product = products[0];
    if (!product) {
        console.error('Could not get product');
        return;
    };

    modalFields.name.value = product.name;
    modalFields.price.value = product.price.toString();	
    modalFields.description.value = product.description;
    modalFields.stock.value = product.stock.toString();
    modalFields.available.value = product.available ? 'Yes' : 'No';

    attributesGlobal.forEach(attributes => {
        for (const key in attributes) {
            for (const attribute of attributes[key]) {
                const query = `input[productattribute-edit="${attribute}"]`;
                const elems = document.querySelectorAll<HTMLInputElement>(query);
                if (!elems) {
                    console.error('Could not find element');
                    continue;
                }
                elems.forEach((element) => {
                    if (element.getAttribute('edit') != null) {
                        element.checked = true;
                    }
                });
            }
        }
    });
}

(async () => {
    const confirmEditBtn = document.getElementById('confirmEditBtn') as HTMLButtonElement | null;
    const confirmCreationBtn = document.getElementById('confirmCreationBtn') as HTMLButtonElement | null;
    const modalCreationName = document.getElementById('modal-creation-name') as HTMLInputElement | null;
    const modalCreationPrice = document.getElementById('modal-creation-price') as HTMLInputElement | null;
    const modalCreationDesc = document.getElementById('modal-creation-description') as HTMLInputElement | null;
    const modalCreationStock = document.getElementById('modal-creation-stock') as HTMLInputElement | null;
    const _modalCreationAvailable = document.getElementById('modal-creation-available') as HTMLButtonElement | null;

    const deleteBtn = document.getElementById('deleteBtn') as HTMLButtonElement | null;
    const editBtn = document.getElementById('editBtn') as HTMLButtonElement | null;

    const searchInput = document.getElementById("searchField") as HTMLInputElement | null;
    const viewDetailsBtn = document.getElementById('viewDetailsBtn') as HTMLButtonElement | null;

    const detailsBody = document.getElementById('modal-details-body') as HTMLElement | null;
    const detailsBodyTemplate = document.getElementById('modal-details-body-template') as HTMLTemplateElement | null;

    const checkboxAll = document.getElementById('checkbox-all') as HTMLInputElement | null;

    const modalFieldsEdit = {
        name: toMDCTextField(document.getElementById('modal-edit-name')) as MDCTextField,
        price: toMDCTextField(document.getElementById('modal-edit-price')) as MDCTextField,
        description: toMDCTextField(document.getElementById('modal-edit-description')) as MDCTextField,
        stock: toMDCTextField(document.getElementById('modal-edit-stock')) as MDCTextField,
        available: new MDCSwitch(document.getElementById('modal-edit-available') as HTMLButtonElement) as MDCSwitch,
    }

    if (!detailsBody || !detailsBodyTemplate) {
        console.error("Could not find modal-details-body or modal-details-body-template");
        return;
    }

    if (!searchInput || !viewDetailsBtn) {
        console.error("Could not find search input");
        return;
    }

    if (!checkboxAll) {
        console.error("Could not find checkbox-all");
        return;
    }

    if (!deleteBtn) {
        console.error("Could not find deleteBtn");
        return;
    }

    if (!editBtn) {
        console.error("Could not find deleteBtn");
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

    const someValueNull = Object.values(modalFieldsEdit).some((element) => !element);
    if (someValueNull) {
        console.error('Some values are null');
        return;
    }

    if ([modalCreationName, modalCreationPrice, modalCreationDesc, modalCreationStock, _modalCreationAvailable].some((element) => !element)) {
        console.error("Could not find modal-creation-name, modal-creation-price, modal-creation-description, modal-creation-stock, modal-creation-available");
        return;
    }
    const modalCreationAvailable = new MDCSwitch(_modalCreationAvailable!);

    deleteBtn.addEventListener('click', async function (e: MouseEvent) {
        if (!confirm("Are you sure you want to delete these products?")) return;
        const products = selectedRows('[productid]').map((element) => element.getAttribute("productid"));

        if (products.length === 0) {
            e.preventDefault();
            return;
        }

        const data = {
            products,
        }

        if (await doPost('/dashboard/admin/products/delete', data)) {
            window.location.reload();
        }
    });

    editBtn.addEventListener('click', async function (e: MouseEvent) {
        const products = selectedRows("[productid]").map((element) => element.getAttribute("productid"));
        if (products.length === 0) {
            console.log("No products selected");
            e.preventDefault(); // TODO: make it work
            return;
        }
        const id = products.shift();
        if (!id) {
            console.log("No products selected");
            e.preventDefault(); // TODO: make it wo
            return;
        }

        editBtn.setAttribute('productid', id);
        fillFields(id);
    });

    confirmCreationBtn.addEventListener('click', async function (e: MouseEvent) {
        const attributes = selectedRows('[productattribute]').map((element) => element.getAttribute("productattribute"));

        const data = {
            name: modalCreationName!.value,
            price: modalCreationPrice!.value,
            description: modalCreationDesc!.value,
            stock: modalCreationStock!.value,
            available: modalCreationAvailable.selected,
            attributes: [...attributes],
        }
        
        if (await doPost('/dashboard/admin/products', data)) {
            window.location.reload();
        }
    });

    confirmEditBtn.addEventListener('click', async function (e: MouseEvent) {
        const id = editBtn.getAttribute('productid');
        if (!id) {
            console.error("Could not find product id");
            return;
        }

        const attributes = selectedRows('[productattribute-edit]').map((element) => element.getAttribute("productattribute-edit"));

        const data = {
            name: modalFieldsEdit.name!.value,
            price: modalFieldsEdit.price!.value,
            description: modalFieldsEdit.description!.value,
            stock: modalFieldsEdit.stock!.value,
            available: modalFieldsEdit.available!.selected,
            attributes: [...attributes],
        }

        if (await doPut(`/dashboard/admin/products/${id}`, data)) {
            window.location.reload();
        }
    });

    checkboxAll.addEventListener('click', function (e: MouseEvent) {
        console.log('checkbox-all clicked');
        checkAll(checkboxAll.checked);
    });

    viewDetailsBtn.addEventListener('click', async function (e: MouseEvent) {
        detailsBody.innerHTML = "";
        console.log('viewDetailsBtn clicked');
        const _products = selectedRows("[productid]").map((element) => element.getAttribute("productid"));
        if (_products.length === 0) {
            return;
        }

        const products = await getDetails(_products) as [Iproduct[], {[k: number]: number[]}[]];
        if (!products[0] || !products[1]) {
            console.error("Could not get details");
            return;
        }
        let n = 0;
        for (const product of products[0]) {
            n++;

            const clone = document.importNode(detailsBodyTemplate.content, true);
            const fields = clone.querySelectorAll("h2");
            fields[0].textContent += `${product.id}`;
            fields[1].textContent += product.name;
            fields[2].textContent += `${product.price}`;
            fields[3].textContent += product.description;
            fields[4].textContent += `${product.stock}`;
            fields[5].textContent += `${product.nbAchat}`;
            fields[6].textContent += `${product.available ? 'Yes' : 'No'}`;

            detailsBody.appendChild(clone);
            if (n != products.length) {
                detailsBody.appendChild(document.createElement("hr"));
            }
        }
    });

    searchInput.addEventListener('keyup', (e) => {
        searchField(e, 1, '[productidParent]');
    });
})();
