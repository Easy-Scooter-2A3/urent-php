import { doPost } from './utils';

const doAction = async (data: { [k: string]: any; }, action: string, mode: string) => {
  if (data.length === 0) {
    console.log('Nothing selected');
    return;
  }
  const _token = document.querySelector<HTMLInputElement>("[name='_token']")?.value;
  if (!_token) {
    console.error('Could not find CSRF token');
    return;
  }

  const payload = {
    data,
    action,
    _token,
  };

  const res = await doPost(`/dashboard/admin/${mode}/action`, payload);
  if (res) {
    location.reload();
  }
};

export default doAction;
