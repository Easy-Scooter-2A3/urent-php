import axios from 'axios';

const doGet = async (url: string) => {
    try {
        return await axios.get(url);
    } catch (error) {
        if (axios.isAxiosError(error)) {
            console.log(error)
        }
        return false
    }
}

const doPost = async (url: string, data: {[k: string]: any}) => {
    try {
        const res = await axios.post(url, data);
        return true;
    } catch (error) {
        if (axios.isAxiosError(error)) {
            console.log(error)
        }
        return false
    }
}

const doDelete = async (url: string, data: {[k: string]: any}) => {
    try {
        const res = await axios.delete(url, data);
        return true;
    } catch (error) {
        if (axios.isAxiosError(error)) {
            console.log(error)
        }
        return false
    }
}

const doPut = async (url: string, data: {[k: string]: any}) => {
    try {
        const res = await axios.put(url, data);
        return true;
    } catch (error) {
        if (axios.isAxiosError(error)) {
            console.log(error)
        }
        return false
    }
}


export { doGet, doPost, doDelete, doPut };