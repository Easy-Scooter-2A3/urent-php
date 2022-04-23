import axios from "axios";

const checkAll = (checked: boolean) => {
    const inputs = document.querySelectorAll<HTMLInputElement>('input[type="checkbox"]');
    inputs.forEach((element) => {
        element.checked = checked;
    });
}

const getDetails = async (users: (string | null)[]) => {
    const res = await axios.post(`/admin/users/details`, {users});
    return res.data;
}

const doAction = async (users: (string | null)[], action: string) => {
    if (users.length === 0) {
        console.log("No users selected");
        return;
    }
    const _token = document.querySelector<HTMLInputElement>("[name='_token']")?.value;
    if (!_token) {
        console.error("Could not find CSRF token");
        return;
    }

    const data = {
        users,
        action,
        _token
    };

    try {
        const res = await axios.post('/admin/users/action', data);
        if (res.status === 200) {
            location.reload();
        }
    } catch (error) {
        if (axios.isAxiosError(error)) {
            console.log(error)
        }
    }
}

const selectedUsers = () => {
    const list = document.querySelectorAll<HTMLInputElement>("[userid]");
    return Array.from(list).filter((element) => {
        return element.checked;
    });
}

const searchField = (input: KeyboardEvent) => {
    let target = input.target as HTMLInputElement;
    if (!target) {
        return;
    }

    const regex = new RegExp(target.value, "i");

    const list = document.querySelectorAll<HTMLElement>("[useridParent]");
    if (target.value.length === 0) {
        list.forEach((element) => {
            element.removeAttribute("hidden");
        });
        return;
    }

    list.forEach((element) => {
        const name = element.children[2]?.textContent;
        element.hidden = (name && name.match(regex)) ? false : true;
    });
}

(async () => {
    const searchInput = document.getElementById("searchField") as HTMLInputElement | null;
    const checkboxAll = document.getElementById('checkbox-all') as HTMLInputElement | null;
    const users = document.querySelectorAll<HTMLInputElement>("[userid]");
    const viewDetailsBtn = document.getElementById('viewDetailsBtn') as HTMLButtonElement | null;
    const toggleAdminBtn = document.getElementById('toggleAdminBtn') as HTMLButtonElement | null;
    const toggleActivationUserBtn = document.getElementById('toggleActivationUserBtn') as HTMLButtonElement | null;
    
    if (!searchInput || !checkboxAll || !users || !viewDetailsBtn || !toggleAdminBtn || !toggleActivationUserBtn) {
        console.error('Could not find one or more elements');
        return;
    }

    checkboxAll.addEventListener('click', function (e: MouseEvent) {
        console.log('checkbox-all clicked');
        checkAll(checkboxAll.checked);
    });

    viewDetailsBtn.addEventListener('click', async function (e: MouseEvent) {
        console.log('viewDetailsBtn clicked');
        const _users = selectedUsers().map((element) => element.getAttribute("userid"));
        if (_users.length === 0) {
            return;
        }

        const details = await getDetails(_users);
        console.log(details);
    });

    toggleAdminBtn.addEventListener('click', async function (e: MouseEvent) {
        console.log('toggleAdminBtn clicked');
        const _users = selectedUsers().map((element) => element.getAttribute("userid"));
        await doAction(_users, 'toggleAdmin');
    });

    toggleActivationUserBtn.addEventListener('click', async function (e: MouseEvent) {
        console.log('toggleActivationUserBtn clicked');
        const _users = selectedUsers().map((element) => element.getAttribute("userid"));
        await doAction(_users, 'toggleActivationUser');
    });

    searchInput.addEventListener('keyup', searchField);
})();
