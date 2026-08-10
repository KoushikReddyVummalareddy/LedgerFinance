import { ref } from 'vue';
import { useAuthStore } from '../../../store/authStore';

export const useAuth = () => {
    const authStore = useAuthStore();

    const loading = ref(false);
    const error = ref('');

    const login = async (
        email: string,
        password: string,
    ) => {
        loading.value = true;
        error.value = '';

        try {
            return await authStore.login(
                email,
                password,
            );
        } catch (err: any) {
            error.value =
                err?.response?.data?.message ??
                'Invalid email or password.';

            throw err;
        } finally {
            loading.value = false;
        }
    };

    const register = async (
        name: string,
        email: string,
        password: string,
        passwordConfirmation: string,
    ) => {
        loading.value = true;
        error.value = '';

        try {
            return await authStore.register(
                name,
                email,
                password,
                passwordConfirmation,
            );
        } catch (err: any) {
            error.value =
                err?.response?.data?.message ??
                'Unable to create account.';

            throw err;
        } finally {
            loading.value = false;
        }
    };

    const logout = async () => {
        loading.value = true;
        error.value = '';

        try {
            await authStore.logout();
        } catch (err: any) {
            error.value =
                err?.response?.data?.message ??
                'Unable to logout.';

            throw err;
        } finally {
            loading.value = false;
        }
    };

    return {
        loading,
        error,
        user: authStore.user,
        isAuthenticated: authStore.isAuthenticated,
        login,
        register,
        logout,
    };
};