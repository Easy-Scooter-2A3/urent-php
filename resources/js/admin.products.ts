import axios from 'axios';
import Iproduct from './interfaces/product';
import searchField from './searchField';
import selectedRows from './selectedRows';
import { doPost, doDelete } from './utils';

const checkAll = (checked: boolean) => {
    const inputs = document.querySelectorAll<HTMLInputElement>('input[type="checkbox"]');
    inputs.forEach((element) => {
        element.checked = checked;
    });
}

const getDetails = async (products: (string | null)[]) => {
    try {
        const res = await axios.post(`/dashboard/admin/products/details`, {products});
        if (res.status === 200) {
            return res.data.data as Iproduct[];
        }
    } catch (error) {
        if (axios.isAxiosError(error)) {
            console.log(error)
        }
        return null;
    }
}

(async () => {
    const confirmCreationBtn = document.getElementById('confirmCreationBtn') as HTMLButtonElement | null;
    const modalCreationName = document.getElementById('modal-creation-name') as HTMLInputElement | null;
    const modalCreationPrice = document.getElementById('modal-creation-price') as HTMLInputElement | null;
    const modalCreationDesc = document.getElementById('modal-creation-description') as HTMLInputElement | null;
    const modalCreationStock = document.getElementById('modal-creation-stock') as HTMLInputElement | null;

    const deleteBtn = document.getElementById('deleteBtn') as HTMLButtonElement | null;

    const searchInput = document.getElementById("searchField") as HTMLInputElement | null;
    const viewDetailsBtn = document.getElementById('viewDetailsBtn') as HTMLButtonElement | null;

    const detailsBody = document.getElementById('modal-details-body') as HTMLElement | null;
    const detailsBodyTemplate = document.getElementById('modal-details-body-template') as HTMLTemplateElement | null;

    const checkboxAll = document.getElementById('checkbox-all') as HTMLInputElement | null;

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

    if (!confirmCreationBtn) {
        console.error("Could not find confirmCreation");
        return;
    }

    if ([modalCreationName, modalCreationPrice, modalCreationDesc, modalCreationStock].some((element) => !element)) {
        console.error("Could not find modal-creation-name, modal-creation-price, modal-creation-description, modal-creation-stock");
        return;
    }

    deleteBtn.addEventListener('click', async function (e: MouseEvent) {
        if (!confirm("Are you sure you want to delete these products?")) return;
        const products = selectedRows('[productid]').map((element) => element.getAttribute("productid"));
        const data = {
            products,
        }

        if (await doPost('/dashboard/admin/products/delete', data)) {
            window.location.reload();
        }
    });

    confirmCreationBtn.addEventListener('click', async function (e: MouseEvent) {
        const data = {
            name: modalCreationName!.value,
            price: modalCreationPrice!.value,
            description: modalCreationDesc!.value,
            stock: modalCreationStock!.value,
        }
        
        if (await doPost('/dashboard/admin/products', data)) {
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

        const products = await getDetails(_products);
        if (!products) {
            console.error("Could not get details");
            return;
        }
        console.log(products);

        let n = 0;
        for (const product of products) {
            n++;

            const clone = document.importNode(detailsBodyTemplate.content, true);
            const fields = clone.querySelectorAll("h2");
            fields[0].textContent += `${product.id}`;
            fields[1].textContent += product.name;
            fields[2].textContent += `${product.price}`;
            fields[2].textContent += product.description;
            fields[4].textContent += `${product.stock}`;
            fields[5].textContent += `${product.nbAchat}`;

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
