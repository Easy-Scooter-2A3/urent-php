const checkAll = (checked: boolean) => {
    console.log("'checkAll' function called");
    
    var inputs = document.querySelectorAll<HTMLInputElement>('input[type="checkbox"]');
    for(const element of inputs){
        element.checked = checked;
    }
}

const searchList = (input: KeyboardEvent) => {
    
    let target = input.target as HTMLInputElement;
    if (!target) {
        return;
    }

    const list = document.querySelectorAll("[users]");
    const regex = new RegExp(target.value, "i");
    if (target.value == '') {
        list.forEach((element) => {
            element.removeAttribute("hidden");
        });
        return;
    }

    list.forEach((element) => {
        const name = element.children[2]?.textContent;
        console.log(name);
        
        if (name) {
            if (!name.match(regex)) {
                element.setAttribute("hidden", "true");
            } else {
              element.removeAttribute("hidden");
            }
        }
    });


}
    

(async () => {
    console.log("Coucou");
    const searchInput = document.getElementById("searchList") as HTMLInputElement | null;
    const elem = document.getElementById('checkbox-all') as HTMLInputElement | null;
    if (elem) {
        elem.addEventListener('click', function (e: MouseEvent) {
            console.log('checkbox-all clicked');
            checkAll(elem.checked);
        });
    }
    if (!searchInput) {
        console.error('Could not find search input');
        return;
    }
    searchInput.addEventListener('keyup', searchList); 
})();
