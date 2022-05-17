const updateProducts = (activeAttributes: Set<number>) => {
    const elems = document.querySelectorAll('tr[rowid]');

    elems.forEach(elem => {
        let matchAttributes = false;
        const list = elem.querySelectorAll('td > div > ul')[0];

        if (activeAttributes.size > 0) {
            for (const child of Array.from(list.children)) {
                const attr = child.getAttribute('attr');
                if (attr && activeAttributes.has(parseInt(attr))) {
                    matchAttributes = true;
                }
            }
        } else {
            matchAttributes = true;
        }

        matchAttributes ? elem.classList.remove('hidden') : elem.classList.add('hidden');
    });
}

const filters = () => {
    const attributes = document.querySelectorAll('input[type=checkbox]');

    const attributesToShow = new Set<number>();
    attributes.forEach(filter => {
        filter.addEventListener('change', (event) => {
            const target = event.target as HTMLInputElement;
            if (!target) {
                return;
            }

            const attributeId = target.getAttribute('attributeId');
            if (!attributeId) {
                return;
            }

            target.checked ? attributesToShow.add(parseInt(attributeId)) : attributesToShow.delete(parseInt(attributeId));
            updateProducts(attributesToShow);
        });
    });
}

export { filters, updateProducts };