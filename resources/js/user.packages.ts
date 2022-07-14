import { MDCCheckbox } from '@material/checkbox';
import { doPost } from './utils';
import notification from './notif';
import getSelectedCard from './getSelectedCard';

// import { MDCDialog } from '@material/dialog';

const selectPackage = async (packageId: number, paymentMethod: string, option: number = 0) => {
  const data = {
    paymentMethod,
    package: packageId,
    option,
  };
  const res = await doPost('/dashboard/packages/edit', data);
  if (res) {
    return res;
  }
};

const checkOption = () => {
  const options = document.querySelectorAll<HTMLInputElement>('[option]');
  let valid = '';
  options.forEach((element) => {
    if (element.checked) {
      valid = element.getAttribute('option') ?? '';
    }
  });

  return valid;
};

const payment = async () => {
  const confirmPayBtn = document.getElementById('confirmPayBtn') as HTMLButtonElement | null;
  if (!confirmPayBtn) {
    console.error('Could not find confirmPayBtn');
    return;
  }

  const cards = document.getElementsByName('payment-card');
  if (!cards) {
    console.error('Could not find cards');
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
      notification('Please select a payment method');
      return;
    }
    const pkg = confirmPayBtn.getAttribute('pkg');
    if (!pkg) {
      notification('Please select a package');
      return;
    }

    const option = checkOption();
    if (!option && parseInt(pkg, 10) === 2) {
      notification('Please select an option');
      return;
    }

    if (await selectPackage(parseInt(pkg, 10), paymentMethod, parseInt(option ?? '', 10))) {
      window.location.href = '/dashboard/packages';
    } else {
      notification('Payment failed');
    }
  });
};

(() => {
  payment();
  const confirmPayBtn = document.getElementById('confirmPayBtn') as HTMLButtonElement | null;
  if (!confirmPayBtn) {
    console.error('Could not find confirmPayBtn');
    return;
  }

  for (let i = 1; i < 4; i += 1) {
    const x = document.getElementById(`pickPackageBtn${i}`);
    if (x) {
      x.addEventListener('click', (_e) => {
        const option = checkOption();
        if (i === 2) {
          if (option === '') {
            notification('Please select an option');
            return;
          }
        }

        confirmPayBtn.setAttribute('pkg', String(i));
      });
    }
  }
})();
