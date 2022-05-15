import axios from 'axios';

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


export { doPost, doDelete, doPut };