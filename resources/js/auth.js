import {ref} from "vue";
import axios from "axios";
import {useRouter} from "vue-router";

const apiHost = import.meta.env.VITE_API_HOST;

const isLogged = ref(false);

export const useAuth = () => {
    const errors = ref({});
    const unauthorized = ref({value: false});
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
            isLogged.value = true;

            window.location = '/authors/list';
        } catch (error) {
            console.log(error)
            if (error.response && error.response.data.errors) {
                errors.value = error.response.data.errors;
            } else {
                errors.value = {unauthorized: true};
            }
            console.error(error.response);
        }
    };

    const logout = () => {
        isLogged.value = false;
        errors.value = {};
        localStorage.removeItem("token");

        window.location = '/'
    };

    return {
        isLogged,
        errors,
        unauthorized,
        createUser,
        authenticate,
        logout,
    };
};
