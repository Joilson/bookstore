import {ref} from "vue";
import axios from "axios";
import {useRouter} from "vue-router";

const apiHost = import.meta.env.VITE_API_HOST;

const identifyList = function (resource) {
    return 'list' + resource.charAt(0).toUpperCase() + resource.slice(1, -1);
};

export default function useRequest() {
    const errors = ref({});
    const router = useRouter();

    async function waitForToken(timeout = 1000) {
        const interval = 100;
        const start = Date.now();

        return new Promise((resolve) => {
            const checkToken = setInterval(() => {
                if (localStorage.getItem("token")) {
                    clearInterval(checkToken);
                    resolve(localStorage.getItem("token"));
                } else if (Date.now() - start > timeout) {
                    clearInterval(checkToken);
                    router.push({name: 'home'})
                }
            }, interval);
        });
    }

    const headers = async () => {
        await waitForToken(2000);

        return {
            "Content-Type": "application/json",
            "Authorization": `Bearer ${localStorage.getItem("token")}`
        };
    };

    const getAll = async (resource) => {
        try {
            const response = await axios.get(`${apiHost}/api/${resource}`, {
                headers: await headers(),
            });
            return response.data.data;
        } catch (error) {
            handleRequestError(error)
        }
    };

    const remove = async (resource, id) => {
        try {
            await axios.delete(`${apiHost}/api/${resource}/${id}`, {
                headers: await headers(),
            });
            location.reload();
        } catch (error) {
            handleRequestError(error)
        }
    };

    const get = async (resource, id) => {
        try {
            const response = await axios.get(`${apiHost}/api/${resource}/${id}`, {
                headers: await headers(),
            });
            const key = resource.slice(0, -1);
            return response.data[key];
        } catch (error) {
            handleRequestError(error)
        }
    };

    const create = async (resource, formData) => {
        try {
            await axios.post(`${apiHost}/api/${resource}`, formData, {
                headers: await headers(),
            });
            router.push({name: identifyList(resource)});
            errors.value = {};
        } catch (error) {
            handleRequestError(error)
        }
    };

    const update = async (resource, id, formData) => {
        try {
            await axios.put(`${apiHost}/api/${resource}/${id}`, formData, {
                headers: await headers(),
            });
            errors.value = {};
            router.push({name: identifyList(resource)});
        } catch (error) {
            handleRequestError(error)
        }
    };

    const handleRequestError = function (error) {
        console.error(error)
        if ('errors' in error.response.data) {
            errors.value = error.response.data.errors;
        } else {
            errors.value = {generic: error.response.data.error};
        }

        console.log(error)
    };

    return {
        errors,
        getAll,
        remove,
        get,
        create,
        update,
    };
}
