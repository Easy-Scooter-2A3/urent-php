const checkAll = (checked: boolean) => {
    console.log("'checkAll' function called");

    const inputs = document.querySelectorAll<HTMLInputElement>('input[type="checkbox"]');
    for (const element of inputs) {
        element.checked = checked;
    }
}

const searchList = (input: KeyboardEvent) => {

    let target = input.target as HTMLInputElement;
    if (!target) {
        return;
    }

    const regex = new RegExp(target.value, "i");

    const list = document.querySelectorAll<HTMLElement>("[userid]");
    if (target.value == '') {
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

const detailUser = (checked: boolean) => {
    const user = document.querySelector("[users]");
    if (!user) {
        return;
    }
    //Récupérer l'input de user
    const input = user.querySelector("input[type='checkbox']") as HTMLInputElement;
    if (!input) {
        return;
    }
    console.log(input);
    //Si l'input est coché
    if (input.checked == checked) {
        console.log("input.checked == checked");
    }

}

(async () => {
    const searchInput = document.getElementById("searchList") as HTMLInputElement | null;
    const elem = document.getElementById('checkbox-all') as HTMLInputElement | null;
    const userDetail = document.querySelectorAll<HTMLInputElement>("[userid]");

    const viewDetailsBtn = document.getElementById('viewDetailsBtn') as HTMLButtonElement | null;

    if (!searchInput || !elem || !userDetail || !viewDetailsBtn) {
        console.error('Could not find one or more elements');
        return;
    }

    elem.addEventListener('click', function (e: MouseEvent) {
        console.log('checkbox-all clicked');
        checkAll(elem.checked);
    });

    userDetail.forEach((element) => {
        element.addEventListener('click', function (e: MouseEvent) {
            console.log('checkbox clicked');
            // detailUser(element.getAttribute("userid"));
        });
    });

    viewDetailsBtn.addEventListener('click', function (e: MouseEvent) {
        console.log('viewDetailsBtn clicked');
        const selectedUsers = []
        userDetail.forEach((element) => {
            if (element.checked) {
                selectedUsers.push(element.getAttribute("userid"));
            }
        });
        // axios post ect avec le tableau
    });
    
    searchInput.addEventListener('keyup', searchList);
})();
