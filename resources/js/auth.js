import {ref} from "vue";
import axios from "axios";
import {useRouter} from "vue-router";

const apiHost = import.meta.env.VITE_API_HOST;

export const useAuth = () => {
    const errors = ref({});
    const router = useRouter();

    const createUser = async (formData) => {
        try {
            await axios.post(`${apiHost}/api/users`, formData, {
                headers: {
                    "Content-Type": "application/json",
                },
            });

            window.location = '/';
        } catch (error) {
            console.log(error.response.data.errors)
            errors.value = error.response.data.errors;
        }
    };

    const authenticate = async (formData) => {
        try {
            errors.value = {};
            const response = await axios.post(`${apiHost}/api/auth`, formData, {
                headers: {
                    "Content-Type": "application/json",
                },
            });

            const data = response.data;
            localStorage.setItem("token", data.token);

            window.location = '/authors/list';
        } catch (error) {
            console.log(error)
            if (error.response && error.response.data.errors) {
                errors.value = error.response.data.errors;
            } else {
                errors.value = {unauthorized: error.response.data.error};
            }
            console.error(error.response);
        }
    };

    const logout = () => {
        errors.value = {};
        localStorage.removeItem("token");

        window.location = '/'
    };

    return {
        errors,
        createUser,
        authenticate,
        logout,
    };
};
