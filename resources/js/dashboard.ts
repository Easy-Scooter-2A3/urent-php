/* eslint-disable import/no-unresolved */
/* eslint-disable import/extensions */
import { MDCSwitch } from '@material/switch';
import { MDCDialog } from '@material/dialog';
import axios from 'axios';
import { doDelete, doPost } from './utils';

const enableMFA = async () => {
  const form = document.getElementById('mfa_form') as HTMLFormElement;
  if (form) {
    form.submit();
  }
}

const disableMFA = async () => {
  console.log('disableMFA');
  const res = await doDelete('/user/two-factor-authentication');
  if (res) {
    if (axios.isAxiosError(res)) {
      if (res.response!.status === 423) { // TODO: check error
        window.location.href = '/user/confirm-password';
        localStorage.setItem('redirect_to', '/dashboard');
      }
      return;
    }

    location.reload();
  }
};

const confirmMFA = async (CSRF: HTMLInputElement, MFADialogCode: HTMLInputElement) => {
  const data = new FormData();
  data.set('code', MFADialogCode.value);
  data.set('_token', CSRF.value);

  const res = await doPost('/user/confirmed-two-factor-authentication', data);
  if (res) {
    if (axios.isAxiosError(res)) {
      switch (res.response!.status) {
        case 423:
          localStorage.setItem('redirect_to', '/dashboard');
          window.location.href = '/user/confirm-password';
          break;
        case 422:
          // eslint-disable-next-line no-case-declarations
          const customMFAError = document.getElementById('custom_mfa_error');
          if (customMFAError) {
            customMFAError.innerText = res.response!.data.message;
          }
          break;

        default:
          break;
      }
      if (res.response!.status === 423) { // TODO: check error
        window.location.href = '/user/confirm-password';
        localStorage.setItem('redirect_to', '/dashboard');
      }
      return;
    }

    location.reload();
  }
};

(async () => {
  const MFASwitchE = document.getElementById('MFASwitch') as HTMLButtonElement | null;
  const MFADialogOpen = document.getElementById('mfa_dialog_open') as HTMLElement | null;
  const MFADialogMenu = document.getElementById('mfa_dialog2') as HTMLElement | null;
  const CSRF = document.querySelector('input[name="_token"]') as HTMLInputElement | null;

  if (!MFASwitchE
    || !CSRF) {
    console.error('Could not find one or more elements');
    return;
  }
  const MFASwitch = new MDCSwitch(MFASwitchE);

  MFASwitchE.addEventListener('click', async (_e: MouseEvent) => {
    _e.preventDefault();
    if (MFASwitch.selected) {
      await enableMFA();
    } else {
      await disableMFA();
    }
  });

  if (MFADialogOpen && MFADialogMenu) {
    const MFADialog = new MDCDialog(MFADialogMenu);
    const MFADialogCode = document.querySelector('input[name="code"]') as HTMLInputElement | null;
    if (!MFADialogCode) {
      console.error('Could not find MFA code input');
      return;
    }
    MFADialogOpen.addEventListener('click', (_e: MouseEvent) => {
      console.log('mfa_dialog_open clicked');
      MFADialog.open();
    });

    MFADialog.listen('MDCDialog:closed', async (e: CustomEvent) => {
      const { action } = e.detail;
      if (action === 'accept') {
        if (!MFADialogCode) {
          console.error('Could not find MFA code input');
          return;
        }
        if (MFADialogCode.value.length === 0) {
          console.error('MFA code is empty');
          return;
        }
        await confirmMFA(CSRF, MFADialogCode);
      }
    });
  }
})();
