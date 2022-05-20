import axios from 'axios';
import IOrder from './interfaces/order';
import searchField from './searchField';
import selectedRows from './selectedRows';
import { doPost, doDelete, doPut, doGet } from './utils';
import { MDCSwitch } from '@material/switch';
import { MDCTextField } from '@material/textfield';

const checkAll = (checked: boolean) => {
    const inputs = document.querySelectorAll<HTMLInputElement>('input[type="checkbox"]');
    inputs.forEach((element) => {
        element.checked = checked;
    });
}

const getDetails = async (orders: (string | null)[]) => {
    const res = await doPost('/dashboard/admin/orders/details', { orders });
    if (res) {
        return res.data.data;
    }
}

const toMDCTextField = (element: HTMLElement | null) => {
    if (!element || !element.parentElement) {
        return null;
    }

    return new MDCTextField(element.parentElement);
}

const getOrderContent = async (orderId: number) => {
    return doGet(`/dashboard/admin/orders/${orderId}/content`);
}

(async () => {
    // const confirmEditBtn = document.getElementById('confirmEditBtn') as HTMLButtonElement | null;
    // const confirmCreationBtn = document.getElementById('confirmCreationBtn') as HTMLButtonElement | null;
    const modalCreationName = document.getElementById('modal-creation-name') as HTMLInputElement | null;
    const modalCreationPrice = document.getElementById('modal-creation-price') as HTMLInputElement | null;
    const modalCreationDesc = document.getElementById('modal-creation-description') as HTMLInputElement | null;
    const modalCreationStock = document.getElementById('modal-creation-stock') as HTMLInputElement | null;
    const _modalCreationAvailable = document.getElementById('modal-creation-available') as HTMLButtonElement | null;

    // const deleteBtn = document.getElementById('deleteBtn') as HTMLButtonElement | null;
    // const editBtn = document.getElementById('editBtn') as HTMLButtonElement | null;

    const searchInput = document.getElementById("searchField") as HTMLInputElement | null;
    const viewDetailsBtn = document.getElementById('viewDetailsBtn') as HTMLButtonElement | null;

    const detailsBody = document.getElementById('modal-details-body') as HTMLElement | null;
    const detailsBodyTemplate = document.getElementById('modal-details-body-template') as HTMLTemplateElement | null;

    const checkboxAll = document.getElementById('checkbox-all') as HTMLInputElement | null;

    // const modalFieldsEdit = {
    //     name: toMDCTextField(document.getElementById('modal-edit-name')) as MDCTextField,
    //     price: toMDCTextField(document.getElementById('modal-edit-price')) as MDCTextField,
    //     description: toMDCTextField(document.getElementById('modal-edit-description')) as MDCTextField,
    //     stock: toMDCTextField(document.getElementById('modal-edit-stock')) as MDCTextField,
    //     available: new MDCSwitch(document.getElementById('modal-edit-available') as HTMLButtonElement),
    // }

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

    // if (!deleteBtn) {
    //     console.error("Could not find deleteBtn");
    //     return;
    // }

    // if (!editBtn) {
    //     console.error("Could not find deleteBtn");
    //     return;
    // }

    // if (!confirmCreationBtn) {
    //     console.error("Could not find confirmCreation");
    //     return;
    // }

    // if (!confirmEditBtn) {
    //     console.error("Could not find confirmEdit");
    //     return;
    // }

    // const someValueNull = Object.values(modalFieldsEdit).some((element) => !element);
    // if (someValueNull) {
    //     console.error('Some values are null');
    //     return;
    // }

    // if ([modalCreationName, modalCreationPrice, modalCreationDesc, modalCreationStock, _modalCreationAvailable].some((element) => !element)) {
    //     console.error("Could not find modal-creation-name, modal-creation-price, modal-creation-description, modal-creation-stock, modal-creation-available");
    //     return;
    // }

    // deleteBtn.addEventListener('click', async function (e: MouseEvent) {
    //     if (!confirm("Are you sure you want to delete these orders?")) return;
    //     const orders = selectedRows('[orderid]').map((element) => element.getAttribute("orderid"));

    //     if (orders.length === 0) {
    //         e.preventDefault();
    //         return;
    //     }

    //     const data = {
    //         orders,
    //     }

    //     if (await doPost('/dashboard/admin/orders/delete', data)) {
    //         window.location.reload();
    //     }
    // });

    // editBtn.addEventListener('click', async function (e: MouseEvent) {
    //     const orders = selectedRows("[orderid]").map((element) => element.getAttribute("orderid"));
    //     if (orders.length === 0) {
    //         console.log("No orders selected");
    //         e.preventDefault(); // TODO: make it work
    //         return;
    //     }
    //     const id = orders.shift();
    //     if (!id) {
    //         console.log("No orders selected");
    //         e.preventDefault(); // TODO: make it wo
    //         return;
    //     }

    //     editBtn.setAttribute('orderid', id);
    //     fillFields(id);
    // });


    // confirmEditBtn.addEventListener('click', async function (e: MouseEvent) {
    //     const id = editBtn.getAttribute('orderid');
    //     if (!id) {
    //         console.error("Could not find order id");
    //         return;
    //     }

    //     const attributes = selectedRows('[orderattribute-edit]').map((element) => element.getAttribute("orderattribute-edit"));

    //     const data = {
    //         name: modalFieldsEdit.name!.value,
    //         price: modalFieldsEdit.price!.value,
    //         description: modalFieldsEdit.description!.value,
    //         stock: modalFieldsEdit.stock!.value,
    //         available: modalFieldsEdit.available!.selected,
    //         attributes: [...attributes],
    //     }

    //     if (await doPut(`/dashboard/admin/orders/${id}`, data)) {
    //         window.location.reload();
    //     }
    // });

    checkboxAll.addEventListener('click', function (e: MouseEvent) {
        console.log('checkbox-all clicked');
        checkAll(checkboxAll.checked);
    });

    viewDetailsBtn.addEventListener('click', async function (e: MouseEvent) {
        detailsBody.innerHTML = "";
        console.log('viewDetailsBtn clicked');
        const _orders = selectedRows("[orderid]").map((element) => element.getAttribute("orderid"));
        if (_orders.length === 0) {
            return;
        }

        const orders = await getDetails(_orders) as IOrder[];
        if (!orders) {
            console.error("Could not get details");
            return;
        }
        let n = 0;
        for (const order of orders) {
            n++;

            const clone = document.importNode(detailsBodyTemplate.content, true);
            const fields = clone.querySelectorAll("h2");
            console.log(order)

            const creationDate = new Date(order.created_at);
            const updatedDate = new Date(order.updated_at);

            fields[0].textContent += `${order.id}`;
            fields[1].textContent += order.status;
            fields[2].textContent += order.delivery_place;
            fields[3].textContent += order.delivery_date;
            fields[4].textContent += order.transporter;
            fields[5].textContent += order.transporter_tracking_number;
            fields[6].textContent += `${creationDate.toLocaleTimeString()} ${creationDate.toLocaleDateString()}`;
            fields[7].textContent += `${updatedDate.toLocaleTimeString()} ${updatedDate.toLocaleDateString()}`;
            fields[8].textContent += `${order.total_price} €`;
            fields[9].textContent += 'Carte';
            fields[10].textContent += order.fidelityPoints; //TODO: add fidelity points
            fields[11].innerHTML += `<a href="${order.recu}">Voir le recu</a>`; //TODO: color

            const orderContent = await getOrderContent(order.id);
            if (!orderContent) {
                console.error("Could not get order content");
                return;
            }
            fields[12].innerHTML = "Objets : <br>";

            Object.values<any>(orderContent.data.data).forEach((product: any) => {
                fields[12].innerHTML += `${product.nb} x ${product.name} <br>`;
            });

            detailsBody.appendChild(clone);
            if (n != orders.length) {
                detailsBody.appendChild(document.createElement("hr"));
            }
        }
    });

    searchInput.addEventListener('keyup', (e) => {
        searchField(e, 1, '[orderidParent]');
    });
})();
