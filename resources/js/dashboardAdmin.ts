function checkAll(checked: boolean) {
    console.log("'checkAll' function called");
    
    var inputs = document.getElementsByTagName('input');
    for(const element of inputs){
        if(element.type == 'checkbox'){
            element.checked = checked;
        }
    }
}


(async () => {
    console.log("Coucou");
    
    const elem = document.getElementById('checkbox-all') as HTMLInputElement | null;
    if (elem) {
        elem.addEventListener('click', function (e: MouseEvent) {
            console.log('checkbox-all clicked');
            checkAll(elem.checked);
        });
    }
})();


