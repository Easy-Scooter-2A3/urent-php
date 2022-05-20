import { MDCSnackbar } from '@material/snackbar';

const notification = (msg: string, timeout: number = 5000) => {
  const notif = document.getElementById('notif-snackbar');
  if (!notif) {
    console.error('Could not find notification');
    return;
  }

  const elem = new MDCSnackbar(notif);
  elem.actionButtonText = 'OK';
  elem.timeoutMs = timeout;
  elem.labelText = msg;
  elem.open();
};

export default notification;
