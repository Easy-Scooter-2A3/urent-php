import { MDCSwitch } from '@material/switch';
import { MDCTextField } from '@material/textfield';
import IOrder from './interfaces/order';
import searchField from './searchField';
import selectedRows from './selectedRows';
import {
  doPost, doDelete, doPut, doGet,
} from './utils';
import checkAll from './checkAll';

const getDetails = async (orders: (string | null)) => {
  const res = await doPost('/dashboard/admin/orders/details', { orders });
  if (res) {
    return res.data.data;
  }
};

const toMDCTextField = (element: HTMLElement | null) => {
  if (!element || !element.parentElement) {
    return null;
  }

  return new MDCTextField(element.parentElement);
};

const getOrderContent = async (orderId: number) => doGet(`/dashboard/admin/orders/${orderId}/content`);

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

  const searchInput = document.getElementById('searchField') as HTMLInputElement | null;
  const viewDetailsBtn = document.getElementById('viewDetailsBtn') as HTMLButtonElement | null;

  const detailsBody = document.getElementById('modal-details-body') as HTMLElement | null;
  const detailsBodyTemplate = document.getElementById('modal-details-body-template') as HTMLTemplateElement | null;

  const checkboxAll = document.getElementById('checkbox-all') as HTMLInputElement | null;

  if (!detailsBody || !detailsBodyTemplate) {
    console.error('Could not find modal-details-body or modal-details-body-template');
    return;
  }

  if (!searchInput || !viewDetailsBtn) {
    console.error('Could not find search input');
    return;
  }

  if (!checkboxAll) {
    console.error('Could not find checkbox-all');
    return;
  }

  checkboxAll.addEventListener('click', (_e: MouseEvent) => {
    console.log('checkbox-all clicked');
    checkAll(checkboxAll.checked, document);
  });

  viewDetailsBtn.addEventListener('click', async (_e: MouseEvent) => {
    detailsBody.innerHTML = '';
    console.log('viewDetailsBtn clicked');
    const ordersRows = selectedRows('[orderid]').map((element) => element.getAttribute('orderid'));
    if (ordersRows.length === 0) {
      return;
    }

    let n = 0;
    ordersRows.forEach(async (id) => {
      n += 1;
      const order = await getDetails(id) as IOrder;
      if (order) {
        const clone = document.importNode(detailsBodyTemplate.content, true);
        const fields = clone.querySelectorAll('h2');
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
        fields[10].textContent += order.fidelityPoints; // TODO: add fidelity points
        fields[11].innerHTML += `<a href="${order.recu}">Voir le recu</a>`; // TODO: color

        const orderContent = await getOrderContent(order.id);
        if (!orderContent) {
          console.error('Could not get order content');
          return;
        }
        fields[12].innerHTML = 'Objets : <br>';

        Object.values<any>(orderContent.data.data).forEach((product: any) => {
          fields[12].innerHTML += `${product.nb} x ${product.name} <br>`;
        });

        detailsBody.appendChild(clone);
        if (n !== ordersRows.length) {
          detailsBody.appendChild(document.createElement('hr'));
        }
      }
    });
  });

  searchInput.addEventListener('keyup', (e) => {
    searchField(e, 1, '[orderidParent]');
  });
})();
