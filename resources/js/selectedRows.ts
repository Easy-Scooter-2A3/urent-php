const selectedRows = (querySelector: string) => {
    const list = document.querySelectorAll<HTMLInputElement>(querySelector);
    return Array.from(list).filter((element) => {
        return element.checked;
    });
}

export default selectedRows;