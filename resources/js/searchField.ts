
const searchField = (input: KeyboardEvent, childrenNb: number, querySelector: string) => {
    let target = input.target as HTMLInputElement;
    if (!target) {
        return;
    }

    const regex = new RegExp(target.value, "i");

    const list = document.querySelectorAll<HTMLElement>(querySelector);
    if (target.value.length === 0) {
        list.forEach((element) => {
            element.removeAttribute("hidden");
        });
        return;
    }

    list.forEach((element) => {
        const name = element.children[childrenNb]?.textContent;
        element.hidden = (name && name.match(regex)) ? false : true;
    });
}

export default searchField;