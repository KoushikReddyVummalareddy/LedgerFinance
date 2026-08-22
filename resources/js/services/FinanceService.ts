import axios from '../configs/axiosConfig';
import type { User } from '../interfaces/AuthInterface';
import type { DashboardInterface } from '../interfaces/DashboardInterface';
import type {
    CategoryInterface,
    TransactionInterface,
} from '../interfaces/TransactionInterface';

export const AuthService = {
    register: async (
        name: string,
        email: string,
        password: string,
        passwordConfirmation: string,
    ) =>
        axios.post<{ user: User }>(
            '/api/register',
            {
                name,
                email,
                password,
                password_confirmation:
                    passwordConfirmation,
            },
        ),

    login: async (
        email: string,
        password: string,
    ) =>
        axios.post<{ user: User }>(
            '/api/login',
            {
                email,
                password,
            },
        ),

    logout: () =>
        axios.post('/api/logout'),
};

export const DashboardService = {
    getDashboard: () =>
        axios.get<{
            data: DashboardInterface;
        }>('/api/dashboard'),
};

export const CategoryService = {
    getCategories: () =>
        axios.get<{
            data: CategoryInterface[];
        }>('/api/categories', {
            params: {
                page: 1,
                size: 100,
            },
        }),

    createCategory: (payload: {
        name: string;
        type: 'income' | 'expense';
    }) =>
        axios.post<{
            data: CategoryInterface;
        }>(
            '/api/categories',
            payload,
        ),

    updateCategory: (
        id: number,
        payload: {
            name: string;
            type: 'income' | 'expense';
        },
    ) =>
        axios.put<{
            data: CategoryInterface;
        }>(
            `/api/categories/${id}`,
            payload,
        ),

    deleteCategory: (id: number) =>
        axios.delete(
            `/api/categories/${id}`,
        ),
};

export const TransactionService = {
    getTransactions: (params?: {
        page?: number;
        size?: number;
        type?: 'income' | 'expense';
        categoryId?: number;
        search?: string;
        fromDate?: string;
        toDate?: string;
    }) =>
        axios.get<{
            data: TransactionInterface[];
        }>(
            '/api/transactions',
            {
                params,
            },
        ),

    createTransaction: (payload: {
        categoryId: number;
        title: string;
        amount: number;
        type: 'income' | 'expense';
        transactionDate: string;
        notes?: string | null;
    }) =>
        axios.post<{
            data: TransactionInterface;
        }>(
            '/api/transactions',
            {
                category_id: payload.categoryId,
                title: payload.title,
                amount: payload.amount,
                type: payload.type,
                transaction_date:
                    payload.transactionDate,
                notes: payload.notes ?? null,
            },
        ),

    updateTransaction: (
        id: number,
        payload: {
            categoryId: number;
            title: string;
            amount: number;
            type: 'income' | 'expense';
            transactionDate: string;
            notes?: string | null;
        },
    ) =>
        axios.put<{
            data: TransactionInterface;
        }>(
            `/api/transactions/${id}`,
            {
                category_id: payload.categoryId,
                title: payload.title,
                amount: payload.amount,
                type: payload.type,
                transaction_date:
                    payload.transactionDate,
                notes: payload.notes ?? null,
            },
        ),

    deleteTransaction: (id: number) =>
        axios.delete(
            `/api/transactions/${id}`,
        ),
};