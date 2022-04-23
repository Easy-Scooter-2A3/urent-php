import axios from 'axios';

const doAction = async (data: (string | null)[], action: string, mode: string) => {
    if (data.length === 0) {
        console.log("Nothing selected");
        return;
    }
    const _token = document.querySelector<HTMLInputElement>("[name='_token']")?.value;
    if (!_token) {
        console.error("Could not find CSRF token");
        return;
    }

    const payload = {
        data,
        action,
        _token
    };

    try {
        const res = await axios.post(`/admin/${mode}/action`, payload);
        if (res.status === 200) {
            location.reload();
        }
    } catch (error) {
        if (axios.isAxiosError(error)) {
            console.log(error)
        }
    }
}

export default doAction;