import { MDCSwitch } from '@material/switch';

const mfa_switch = document.getElementById('mfa_switch') as HTMLButtonElement;
const elem = new MDCSwitch(mfa_switch);

if (mfa_switch) {

    const enableMFA = () => {
        
    }

    const disableMFA = () => {
        
    }

    mfa_switch.addEventListener('click', function (e: MouseEvent) {
        elem.selected ? enableMFA() : disableMFA();
    });
}