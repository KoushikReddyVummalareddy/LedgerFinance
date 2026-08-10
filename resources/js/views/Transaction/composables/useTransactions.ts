import { ref } from 'vue';
import { TransactionService,CategoryService } from '../../../services/FinanceService';

import type { CategoryInterface, TransactionInterface } from '../../../interfaces/TransactionInterface';

export const useTransaction = () => {
    const transactions = ref<TransactionInterface[]>([]);
    const categories = ref<CategoryInterface[]>([]);

    const loading = ref(false);
    const error = ref('');

    const getTransactions = async () => {
        loading.value = true;
        error.value = '';

        try {
            const { data } =
                await TransactionService.getTransactions();

            transactions.value = data.data;
        } catch (err: any) {
            error.value =
                err?.response?.data?.message ??
                'Unable to load transactions.';
        } finally {
            loading.value = false;
        }
    };

    const getCategories = async () => {
        try {
            const { data } =
                await CategoryService.getCategories();

            categories.value = data.data;
        } catch (err: any) {
            error.value =
                err?.response?.data?.message ??
                'Unable to load categories.';
        }
    };

    const createTransaction = async (payload: {
        categoryId: number;
        title: string;
        amount: number;
        type: 'income' | 'expense';
        transactionDate: string;
        notes?: string | null;
    }) => {
        error.value = '';

        try {
            const { data } =
                await TransactionService.createTransaction(
                    payload,
                );

            await getTransactions();

            return data.data;
        } catch (err: any) {
            error.value =
                err?.response?.data?.message ??
                'Unable to create transaction.';

            throw err;
        }
    };

    return {
        transactions,
        categories,
        loading,
        error,
        getTransactions,
        getCategories,
        createTransaction,
    };
};