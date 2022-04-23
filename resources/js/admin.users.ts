import axios from "axios";
import IUser from "./interfaces/user";
import searchField from "./searchField";
import selectedRows from "./selectedRows";
import doAction from './doAction';

const checkAll = (checked: boolean) => {
    const inputs = document.querySelectorAll<HTMLInputElement>('input[type="checkbox"]');
    inputs.forEach((element) => {
        element.checked = checked;
    });
}

const getDetails = async (users: (string | null)[]) => {
    try {
        const res = await axios.post(`/admin/users/details`, {users});
        if (res.status === 200) {
            return res.data.data as IUser[];
        }
    } catch (error) {
        if (axios.isAxiosError(error)) {
            console.log(error)
        }
        return null;
    }
}

(async () => {
    const searchInput = document.getElementById("searchField") as HTMLInputElement | null;
    const checkboxAll = document.getElementById('checkbox-all') as HTMLInputElement | null;
    const users = document.querySelectorAll<HTMLInputElement>("[userid]");
    const viewDetailsBtn = document.getElementById('viewDetailsBtn') as HTMLButtonElement | null;
    const toggleAdminBtn = document.getElementById('toggleAdminBtn') as HTMLButtonElement | null;
    const toggleActivationUserBtn = document.getElementById('toggleActivationUserBtn') as HTMLButtonElement | null;

    const detailsBody = document.getElementById('modal-details-body') as HTMLElement | null;
    const detailsBodyTemplate = document.getElementById('modal-details-body-template') as HTMLTemplateElement | null;

    if (!detailsBody || !detailsBodyTemplate) {
        console.error("Could not find modal-details-body or modal-details-body-template");
        return;
    }
    
    if (!searchInput || !checkboxAll || !users || !viewDetailsBtn || !toggleAdminBtn || !toggleActivationUserBtn) {
        console.error('Could not find one or more elements');
        return;
    }

    checkboxAll.addEventListener('click', function (e: MouseEvent) {
        console.log('checkbox-all clicked');
        checkAll(checkboxAll.checked);
    });

    viewDetailsBtn.addEventListener('click', async function (e: MouseEvent) {
        detailsBody.innerHTML = "";
        console.log('viewDetailsBtn clicked');
        const _users = selectedRows('[userid]').map((element) => element.getAttribute('userid'));
        if (_users.length === 0) {
            return;
        }

        const users = await getDetails(_users);
        if (!users) {
            console.error("Could not get details");
            return;
        }
        console.log(users);

        let n = 0;
        for (const user of users) {
            n++;

            const clone = document.importNode(detailsBodyTemplate.content, true);
            const fields = clone.querySelectorAll("h2");
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
                fields[12].innerHTML += `<i class="material-icons mdc-text-field__icon mdc-text-field__icon--leading text-green-500">done</i>`;
            } else {
                fields[12].innerHTML += `<i class="material-icons mdc-text-fieldfield__icon mdc-text-field__icon--leading text-red-600">clear</i>`;
            }

            if (user.isActive) {
                fields[13].innerHTML += `<i class="material-icons mdc-text-field__icon mdc-text-field__icon--leading text-green-500">done</i>`;
            } else {
                fields[13].innerHTML += `<i class="material-icons mdc-text-fieldfield__icon mdc-text-field__icon--leading text-red-600">clear</i>`;
            }
            detailsBody.appendChild(clone);
            if (n != users.length) {
                detailsBody.appendChild(document.createElement("hr"));
            }
        }
    });

    toggleAdminBtn.addEventListener('click', async function (e: MouseEvent) {
        console.log('toggleAdminBtn clicked');
        const _users = selectedRows('[userid]').map((element) => element.getAttribute("userid"));
        await doAction(_users, 'toggleAdmin', 'users');
    });

    toggleActivationUserBtn.addEventListener('click', async function (e: MouseEvent) {
        console.log('toggleActivationUserBtn clicked');
        const _users = selectedRows('[userid]').map((element) => element.getAttribute("userid"));
        await doAction(_users, 'toggleActivationUser', 'users');
    });

    searchInput.addEventListener('keyup', (e) => {
        searchField(e, 2, '[useridParent]');
    });
})();
