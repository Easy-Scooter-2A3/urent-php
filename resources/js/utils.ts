import axios from 'axios';

const doGet = async (url: string) => {
    try {
        return axios.get(url);
    } catch (error) {
        if (axios.isAxiosError(error)) {
            console.log(error)
        }
        return false
    }
}

const doPost = async (url: string, data: {[k: string]: any}) => {
    try {
        return axios.post(url, data);
    } catch (error) {
        if (axios.isAxiosError(error)) {
            console.log(error)
        }
        return false
    }
}

const doDelete = async (url: string, data: {[k: string]: any}) => {
    try {
        return axios.delete(url, data);
    } catch (error) {
        if (axios.isAxiosError(error)) {
            console.log(error)
        }
        return false
    }
}

const doPut = async (url: string, data: {[k: string]: any}) => {
    try {
        return axios.put(url, data);
    } catch (error) {
        if (axios.isAxiosError(error)) {
            console.log(error)
        }
        return false
    }
}


export { doGet, doPost, doDelete, doPut };