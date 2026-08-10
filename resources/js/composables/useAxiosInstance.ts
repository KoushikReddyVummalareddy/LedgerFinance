import axios from 'axios';
import { useAuthStore } from '../store/authStore';

export const useAxiosInstance = () => {
    const axiosInstance = axios.create({
        baseURL:
            import.meta.env.VITE_API_BASE_URL ?? '',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            Accept: 'application/json',
            'Content-Type': 'application/json',
        },
        withCredentials: true,
    });

    axiosInstance.interceptors.response.use(
        (response) => {
            return response;
        },
        (error) => {
            if (
                error.response?.status === 401 &&
                window.location.pathname !== '/login'
            ) {
                const authStore = useAuthStore();

                authStore.clearSession();

                window.location.href = '/login';
            }

            return Promise.reject(error);
        },
    );

    return axiosInstance;
};