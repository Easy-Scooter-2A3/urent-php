import { MDCDialog } from '@material/dialog';
import { doPost } from './utils';

(() => {
  const dialogElem = document.getElementById('mfa_dialog');
  const mfaDialogBtn = document.getElementById('fidelityBtn');
  const dialogContent = document.getElementById('dialog-content');
  if (!dialogElem || !mfaDialogBtn || !dialogContent) {
    console.error('Could not find mfa_dialog');
    return;
  }

  const dialog = new MDCDialog(dialogElem.parentElement!);

  mfaDialogBtn.addEventListener('click', () => {
    dialogContent.innerHTML = '<h2>Confirmer la conversion ? 1 point = 0.2 €</h2>';
    dialog.open();
  });

  dialog.listen('MDCDialog:closing', async (e: CustomEvent) => {
    const { action } = e.detail;
    if (action === 'accept') {
      if (await doPost('/user/convertfidelity', {})) {
        location.reload();
      }
    }
  });
})();
