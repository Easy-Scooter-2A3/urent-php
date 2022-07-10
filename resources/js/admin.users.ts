/* eslint-disable import/no-unresolved */
/* eslint-disable import/extensions */
import IUser from './interfaces/user';
import searchField from './searchField';
import selectedRows from './selectedRows';
import notification from './notif';
import { doPatch, doPost } from './utils';
import checkAll from './checkAll';

const getDetails = async (user: (string | null)) => {
  const res = await doPost('/dashboard/admin/users/details', { user });
  if (res) {
    return res.data.data as IUser;
  }
  return null;
};

(async () => {
  const searchInput = document.getElementById('searchField') as HTMLInputElement;
  const checkboxAll = document.getElementById('checkbox-all') as HTMLInputElement;
  const viewDetailsBtn = document.getElementById('viewDetailsBtn') as HTMLButtonElement;
  const toggleAdminBtn = document.getElementById('toggleAdminBtn') as HTMLButtonElement;
  const toggleActivationUserBtn = document.getElementById('toggleActivationUserBtn') as HTMLButtonElement;

  const detailsBody = document.getElementById('modal-details-body') as HTMLElement;
  const detailsBodyTemplate = document.getElementById('modal-details-body-template') as HTMLTemplateElement;

  if (!detailsBody || !detailsBodyTemplate) {
    console.error('Could not find modal-details-body or modal-details-body-template');
    return;
  }

  // eslint-disable-next-line max-len
  if ([searchInput, checkboxAll, viewDetailsBtn, toggleAdminBtn, toggleActivationUserBtn].some((el) => !el)) {
    console.error('Could not find one or more elements');
    return;
  }

  // eslint-disable-next-line no-unused-vars
  checkboxAll.addEventListener('click', (_e: MouseEvent) => {
    console.log('checkbox-all clicked');
    checkAll(checkboxAll.checked, document);
  });

  // eslint-disable-next-line no-unused-vars
  viewDetailsBtn.addEventListener('click', (_e: MouseEvent) => {
    detailsBody.innerHTML = '';
    console.log('viewDetailsBtn clicked');
    const usersRow = selectedRows('[userid]').map((element) => element.getAttribute('userid'));
    if (usersRow.length === 0) {
      return;
    }

    let n = 0;
    usersRow.forEach(async (id) => {
      n += 1;
      const user = await getDetails(id);
      if (user) {
        const clone = document.importNode(detailsBodyTemplate.content, true);
        const fields = clone.querySelectorAll('h2');
        fields[0].textContent += `${user.id}`;
        fields[1].textContent += user.name;
        fields[2].textContent += user.email;
        fields[3].textContent += user.email_verified_at ?? 'N/A';
        fields[4].textContent += user.two_factor_confirmed_at ?? 'N/A';
        fields[5].textContent += `${new Date(user.created_at)}` ?? 'N/A';
        fields[6].textContent += `${new Date(user.updated_at)}` ?? 'N/A';
        fields[7].textContent += user.location;
        fields[8].textContent += user.phone;
        fields[9].textContent += user.partner_code ?? 'N/A';
        fields[10].textContent += `${user.fidelity_points}`;
        fields[11].textContent += `${user.credit_points}`;

        if (user.isAdmin) {
          fields[12].innerHTML += '<i class="material-icons mdc-text-field__icon mdc-text-field__icon--leading text-green-500">done</i>';
        } else {
          fields[12].innerHTML += '<i class="material-icons mdc-text-fieldfield__icon mdc-text-field__icon--leading text-red-600">clear</i>';
        }

        if (user.isActive) {
          fields[13].innerHTML += '<i class="material-icons mdc-text-field__icon mdc-text-field__icon--leading text-green-500">done</i>';
        } else {
          fields[13].innerHTML += '<i class="material-icons mdc-text-fieldfield__icon mdc-text-field__icon--leading text-red-600">clear</i>';
        }

        detailsBody.appendChild(clone);
        if (n !== usersRow.length) {
          detailsBody.appendChild(document.createElement('hr'));
        }
      }
    });
  });

  // eslint-disable-next-line no-unused-vars
  toggleAdminBtn.addEventListener('click', async (_e: MouseEvent) => {
    console.log('toggleAdminBtn clicked');
    const usersRows = selectedRows('[userid]');

    usersRows.forEach(async (userRow) => {
      const userId = userRow.getAttribute('userid');
      const isAdmin = userRow.getAttribute('isAdmin');

      if (userId === null || isAdmin === null) {
        console.log('userId or isAdmin is null');
        return;
      }

      const data = {
        role: !parseInt(isAdmin, 10),
      };
      const res = await doPatch(`/user/${userId}/role`, data);
      if (res) {
        window.location.reload();
        //notification('success');
      }
    });
  });

  // eslint-disable-next-line no-unused-vars
  toggleActivationUserBtn.addEventListener('click', async (_e: MouseEvent) => {
    console.log('toggleActivationUserBtn clicked');
    const usersRows = selectedRows('[userid]');

    usersRows.forEach(async (userRow) => {
      const userId = userRow.getAttribute('userid');
      const isActive = userRow.getAttribute('isActive');

      if (userId === null || isActive === null) {
        console.log('userId or isActive is null');
        return;
      }

      const data = {
        active: !parseInt(isActive, 10),
      };
      const res = await doPatch(`/user/${userId}/activation`, data);
      if (res) {
        window.location.reload();
        //notification('success');
      }
    });
  });

  searchInput.addEventListener('keyup', (e) => {
    searchField(e, 2, '[useridParent]');
  });
})();
