import { defineStore } from 'pinia';
import { ref, computed } from 'vue';
import type { User } from '../interfaces/AuthInterface';
import { AuthService } from '../services/FinanceService';

export const useAuthStore = defineStore(
    'auth',
    () => {
        const user = ref<User | null>(null);

        const isAuthenticated = computed(
            () => !!user.value,
        );

        async function login(
            email: string,
            password: string,
        ) {
            const { data } = await AuthService.login(
                email,
                password,
            );

            user.value = data.user;

            return data.user;
        }

        async function register(
            name: string,
            email: string,
            password: string,
            passwordConfirmation: string,
        ) {
            const { data } = await AuthService.register(
                name,
                email,
                password,
                passwordConfirmation,
            );

            user.value = data.user;

            return data.user;
        }

        async function logout() {
            await AuthService.logout();

            clearSession();
        }

        function setSession(authUser: User) {
            user.value = authUser;
        }

        function clearSession() {
            user.value = null;
        }

        return {
            user,
            isAuthenticated,
            login,
            register,
            logout,
            setSession,
            clearSession,
        };
    },
    {
        persist: true,
    },
);