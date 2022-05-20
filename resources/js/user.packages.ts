import axios from 'axios';
import { doPost } from './utils'
import { MDCCheckbox } from '@material/checkbox';
import notification from './notif';
// import { MDCDialog } from '@material/dialog';

const selectPackage = async (packageId: number, option: number = 0, paymentMethod: string) => {
    const data = {
        paymentMethod,
        package: packageId,
        option,
    };
    const res = await doPost(`/dashboard/packages/edit`, data);
    if (res) {
        return res
    }
}

const checkOption = () => {
    const options = document.querySelectorAll<HTMLInputElement>('[option]');
    let valid = '';
    options.forEach((element) => {
        if (element.checked) {
            valid = element.getAttribute('option') ?? '';
        }
    });

    return valid;
}


const getSelectedCard = () => {
    const cards = document.getElementsByName('payment-card');

    for (const card of Array.from(cards)) {
        const cardElem = new MDCCheckbox(card.parentElement!);
        console.log(cardElem)
        if (cardElem.checked) {
            return card.getAttribute('paymentMethod')
        }
    }
}

const payment = async () => {

    const confirmPayBtn = document.getElementById('confirmPayBtn') as HTMLButtonElement | null;
    if (!confirmPayBtn) {
        console.error("Could not find confirmPayBtn");
        return;
    }

    const cards = document.getElementsByName('payment-card');
    if (!cards) {
        console.error("Could not find cards");
        return;
    }

    cards.forEach(card => {
        card.addEventListener('click', (event) => {
            const target = event.target as HTMLElement;
            if (!target) {
                return;
            }

            cards.forEach(element => {
                if (element === target) {
                    return;
                }
                const e = new MDCCheckbox(element.parentElement!);
                e.checked = false;
            });

            
        });
    });

    confirmPayBtn.addEventListener('click', async () => {
        const paymentMethod = getSelectedCard();
        if (!paymentMethod) {
            console.error("Could not find paymentMethod");
            return;
        }
        const pkg = confirmPayBtn.getAttribute('pkg');
        if (!pkg) {
            console.error("Could not find pkg");
            return;
        }

        const option = checkOption();
        if (!option && parseInt(pkg) == 2) {
            console.error("Could not find option");
            return;
        }

        if (await selectPackage(parseInt(pkg), parseInt(option ?? ''), paymentMethod)) {
            window.location.href = '/dashboard/packages';
        } else {
            notification('Payment failed');

        }

    });
}

(() => {
    payment();
    const confirmPayBtn = document.getElementById('confirmPayBtn') as HTMLButtonElement | null;
    if (!confirmPayBtn) {
        console.error("Could not find confirmPayBtn");
        return;
    }

    for (let i = 1; i < 4; i++) {
        const x = document.getElementById(`pickPackageBtn${i}`);
        if (x) {
            x.addEventListener('click', (e) => {
                let option = checkOption();
                if (i == 2) {
                    if (option == '') {
                        notification('Please select an option');
                        return;
                    }
                }

                confirmPayBtn.setAttribute('pkg', String(i));
            });
        }
    }
})()
