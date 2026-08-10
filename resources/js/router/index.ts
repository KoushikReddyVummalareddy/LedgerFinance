import { createRouter, createWebHistory } from 'vue-router';
import { VueRouteEnum } from '../enums/VueRouteEnum';
import { useAuthStore } from '../store/authStore';

import LoginView from '../views/Auth/LoginView.vue';
import RegisterView from '../views/Auth/RegisterView.vue';
import DashboardView from '../views/Dashboard/DashboardView.vue';
import TransactionsView from '../views/Transaction/TransactionsView.vue';

const routes = [
    {
        path: '/',
        redirect: {
            name: VueRouteEnum.COMMONS.LOGIN,
        },
    },

    {
        path: '/login',
        name: VueRouteEnum.COMMONS.LOGIN,
        component: LoginView,
        meta: {
            guest: true,
        },
    },

    {
        path: '/register',
        name: VueRouteEnum.COMMONS.REGISTER,
        component: RegisterView,
        meta: {
            guest: true,
        },
    },

    {
        path: '/dashboard',
        name: VueRouteEnum.COMMONS.DASHBOARD,
        component: DashboardView,
        meta: {
            requiresAuth: true,
        },
    },

    {
        path: '/transactions',
        name: VueRouteEnum.COMMONS.TRANSACTIONS,
        component: TransactionsView,
        meta: {
            requiresAuth: true,
        },
    },
];

export const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to) => {
    const authStore = useAuthStore();

    if (
        to.meta.requiresAuth &&
        !authStore.isAuthenticated
    ) {
        return {
            name: VueRouteEnum.COMMONS.LOGIN,
        };
    }

    if (
        to.meta.guest &&
        authStore.isAuthenticated
    ) {
        return {
            name: VueRouteEnum.COMMONS.DASHBOARD,
        };
    }

    return true;
});