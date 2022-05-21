import axios from 'axios';

const doGet = async (url: string) => {
  try {
    return axios.get(url);
  } catch (error) {
    if (axios.isAxiosError(error)) {
      console.log(error);
    }
    return false;
  }
};

const doPost = async (url: string, data: {[k: string]: any}) => {
  try {
    return axios.post(url, data);
  } catch (error) {
    if (axios.isAxiosError(error)) {
      console.log(error);
    }
    return false;
  }
};

const doDelete = async (url: string) => {
  try {
    return axios.delete(url, {});
  } catch (error) {
    if (axios.isAxiosError(error)) {
      console.log(error);
    }
    return error;
  }
};

const doPut = async (url: string, data: {[k: string]: any}) => {
  try {
    return axios.put(url, data);
  } catch (error) {
    if (axios.isAxiosError(error)) {
      console.log(error);
    }
    return false;
  }
};

const doPatch = async (url: string, data: {[k: string]: any}) => {
  try {
    return axios.patch(url, data);
  } catch (error) {
    if (axios.isAxiosError(error)) {
      console.log(error);
    }
    return false;
  }
};

function* range(start: number, end: number): Generator<number> {
  yield start;
  if (start < end) {
    yield* range(start + 1, end);
  }
}

export {
  doGet, doPost, doDelete, doPut, doPatch, range,
};
