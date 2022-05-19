import { MDCSwitch } from '@material/switch';
import { MDCDialog } from '@material/dialog';
import axios, { AxiosError } from 'axios';
import { doPost } from './utils';
import { MDCTextField } from '@material/textfield';
import { MDCCheckbox } from '@material/checkbox';

const enableMFA = async () => {
    console.log('enableMFA');
    const form = document.getElementById('mfa_form') as HTMLFormElement;
    if (form) {
        form.submit();
    }
}

const disableMFA = async (mfa_switch: HTMLButtonElement) => {
    console.log('disableMFA');

    try {
        await axios.delete('/user/two-factor-authentication')
        location.reload();
    } catch (error) {
       if (axios.isAxiosError(error)) {
        if (error.response!.status === 423) { //to check
            window.location.href = '/user/confirm-password';
            localStorage.setItem('redirect_to', '/dashboard');
            return;
        }
       }
    }
}

const confirmMFA = async (CSRF: HTMLInputElement, MFADialogCode: HTMLInputElement) => {
    const data = new FormData();
    data.set('code', MFADialogCode.value);
    data.set('_token', CSRF.value);

    try {
        const res = await axios.post('/user/confirmed-two-factor-authentication', data);
        if (res.status === 200) {
            location.reload();
        }
    } catch (error) {
        if (axios.isAxiosError(error)) {
            switch (error.response!.status) {
                case 423:
                    localStorage.setItem('redirect_to', '/dashboard');
                    window.location.href = '/user/confirm-password';
                    break;
                case 422:
                    const error_message = error.response!.data.message as string;
                    const custom_mfa_error = document.getElementById('custom_mfa_error') as HTMLElement | null;
                    if (custom_mfa_error) {
                        custom_mfa_error.innerText = error_message;
                    }
                    break;
            
                default:
                    break;
            }
        }
    }
}

(async () => {
    const mfa_switch = document.getElementById('mfa_switch') as HTMLButtonElement | null;
    const MFADialogOpen = document.getElementById('mfa_dialog_open') as HTMLElement | null;
    const MFADialogMenu = document.getElementById('mfa_dialog2') as HTMLElement | null;
    const CSRF = document.querySelector('input[name="_token"]') as HTMLInputElement | null;
    if (!mfa_switch ||
        !CSRF) {
            console.error('Could not find one or more elements');
            return;
        }
    const MFASwitch = new MDCSwitch(mfa_switch);

    mfa_switch.addEventListener('click', async function (e: MouseEvent) {
        e.preventDefault();
        MFASwitch.selected ? await enableMFA() : await disableMFA(mfa_switch);
    });
    
    if (MFADialogOpen && MFADialogMenu) {
        const MFADialog = new MDCDialog(MFADialogMenu);
        const MFADialogCode = document.querySelector('input[name="code"]') as HTMLInputElement | null;
        if (!MFADialogCode) {
            console.error('Could not find MFA code input');
            return;
        };
        MFADialogOpen.addEventListener('click', function (e: MouseEvent) {
            console.log('mfa_dialog_open clicked');
            MFADialog.open();
        });

        MFADialog.listen('MDCDialog:closed', async function (event: CustomEvent) {
            const action = event.detail['action'];
            if (action === 'accept') {

                if (!MFADialogCode) {
                    console.error('Could not find MFA code input');
                    return;
                };
                if (MFADialogCode.value.length === 0) {
                    console.error('MFA code is empty');
                    return;
                };
                await confirmMFA(CSRF, MFADialogCode);
            }
        });
    }
    
})();
