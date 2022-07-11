/* eslint-disable import/no-unresolved */
/* eslint-disable import/extensions */
import IScooter from './interfaces/scooter';
import searchField from './searchField';
import selectedRows from './selectedRows';
import { doPost } from './utils';
import checkAll from './checkAll';
import { MDCSelect } from '@material/select';
import notification from './notif';

const getDetails = async (scooter: (string | null)) => {
  const res = await doPost('/dashboard/admin/scooters/details', { scooter });
  if (res) {
    return res.data.data as IScooter;
  }
  return null;
};

(async () => {
  const confirmCreationBtn = document.getElementById('confirmCreationBtn') as HTMLButtonElement | null;
  const modalCreationModel = document.getElementById('modal-creation-model') as HTMLElement | null;
  const modalCreationQuantity = document.getElementById('modal-creation-quantity') as HTMLInputElement | null;

  const deleteBtn = document.getElementById('deleteBtn') as HTMLButtonElement | null;

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

  if (!deleteBtn) {
    console.error('Could not find deleteBtn');
    return;
  }

  if (!confirmCreationBtn) {
    console.error('Could not find confirmCreation');
    return;
  }

  if (!modalCreationModel || !modalCreationQuantity) {
    console.error('Could not find modal-creation-model or modal-creation-status');
    return;
  }

  const modalCreationModelSelect = new MDCSelect(modalCreationModel);

  deleteBtn.addEventListener('click', async (_e: MouseEvent) => {
    // TODO: dialog
    if (!confirm('Are you sure you want to delete these scooters?')) return;
    const scooterRows = selectedRows('[scooterid]').map((element) => element.getAttribute('scooterid'));
    const data = {
      scooters: scooterRows,
    };
    if (await doPost('/dashboard/admin/scooters/delete', data)) {
      window.location.reload();
    }
  });

  confirmCreationBtn.addEventListener('click', async (_e: MouseEvent) => {
    const model = modalCreationModelSelect.value;
    if (!model) {
      notification('Please select a model');
      return;
    }

    // get max
    const inputElemQuantityI = modalCreationQuantity.querySelector('input') as HTMLInputElement | null;
    if (!inputElemQuantityI) {
      notification('Could not find input element');
      return;
    }

    const quantityMax = inputElemQuantityI.max;
    if (!quantityMax) {
      notification('Could not find quantity');
      return;
    }

    const quantity = modalCreationQuantity.value;
    if (quantity > quantityMax) {
      notification(`Quantity cannot be greater than ${quantityMax}`);
      return;
    }

    const data = {
      model,
      quantity,
    };
    if (await doPost('/dashboard/admin/scooters/create', data)) {
      window.location.reload();
    } else {
      notification('Could not create scooters');
    }
  });

  checkboxAll.addEventListener('click', (_e: MouseEvent) => {
    console.log('checkbox-all clicked');
    checkAll(checkboxAll.checked, document);
  });

  viewDetailsBtn.addEventListener('click', (_e: MouseEvent) => {
    detailsBody.innerHTML = '';
    console.log('viewDetailsBtn clicked');
    const scooterRows = selectedRows('[scooterid]').map((element) => element.getAttribute('scooterid'));
    if (scooterRows.length === 0) {
      return;
    }

    let n = 0;
    scooterRows.forEach(async (id) => {
      n += 1;
      const scooter = await getDetails(id);
      if (scooter) {
        const clone = document.importNode(detailsBodyTemplate.content, true);
        const fields = clone.querySelectorAll('h2');
        fields[0].textContent += `${scooter.id}`;
        fields[1].textContent += scooter.status;
        fields[2].textContent += scooter.model;
        fields[3].textContent += `${new Date(scooter.created_at)}` ?? 'N/A';
        fields[4].textContent += `${new Date(scooter.updated_at)}` ?? 'N/A';
        fields[5].textContent += `${scooter.longitude}`;
        fields[6].textContent += `${scooter.latitude}`;
        fields[7].textContent += scooter.uuid;

        detailsBody.appendChild(clone);
        if (n !== scooterRows.length) {
          detailsBody.appendChild(document.createElement('hr'));
        }
      }
    });
  });

  searchInput.addEventListener('keyup', (e) => {
    searchField(e, 5, '[scooteridParent]');
  });
})();
