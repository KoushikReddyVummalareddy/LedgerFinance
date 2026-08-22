<script setup lang="ts">
import { computed, onMounted, ref } from 'vue';

import Sidebar from '../../components/Sidebar.vue';
import TransactionCard from '../../components/TransactionCard.vue';

import { TransactionService } from '../../services/FinanceService';
import { useTransaction } from './composables/useTransactions';

import type { TransactionInterface } from '../../interfaces/TransactionInterface';

const {
    transactions,
    loading,
    error,
    getTransactions,
    createTransaction,
} = useTransaction();

const search = ref('');
const showTransactionModal = ref(false);
const editingTransaction =
    ref<TransactionInterface | null>(null);

const filteredTransactions = computed(() => {
    const value = search.value.trim().toLowerCase();

    if (!value) {
        return transactions.value;
    }

    return transactions.value.filter((transaction) =>
        transaction.title.toLowerCase().includes(value),
    );
});

const openAddTransaction = () => {
    editingTransaction.value = null;
    showTransactionModal.value = true;
};

const openEditTransaction = (
    transaction: TransactionInterface,
) => {
    editingTransaction.value = { ...transaction };
    showTransactionModal.value = true;
};

const closeTransactionModal = () => {
    showTransactionModal.value = false;
    editingTransaction.value = null;
};

const saveTransaction = async (transaction: {
    categoryId: number;
    title: string;
    amount: number;
    type: 'income' | 'expense';
    transactionDate: string;
    notes?: string | null;
}) => {
    try {
        await createTransaction(transaction);
        closeTransactionModal();
    } catch {
        // Error handled by useTransaction.
    }
};

const updateTransaction = async (transaction: {
    categoryId: number;
    title: string;
    amount: number;
    type: 'income' | 'expense';
    transactionDate: string;
    notes?: string | null;
}) => {
    if (!editingTransaction.value) {
        return;
    }

    try {
        await TransactionService.updateTransaction(
            editingTransaction.value.id,
            transaction,
        );

        closeTransactionModal();
        await getTransactions();
    } catch {
        // Error handled locally.
    }
};

const deleteTransaction = async (id: number) => {
    const confirmed = window.confirm(
        'Are you sure you want to delete this transaction?',
    );

    if (!confirmed) {
        return;
    }

    try {
        await TransactionService.deleteTransaction(id);
        await getTransactions();
    } catch {
        // Error handled locally.
    }
};

const formatAmount = (amount: number) =>
    Number(amount).toFixed(2);

const formatDate = (date: string) =>
    date.substring(0, 10);

onMounted(() => {
    getTransactions();
});
</script>

<template>
    <div class="flex min-h-screen bg-[#f7f5ef]">
        <Sidebar />

        <main
            class="min-w-0 flex-1 px-4 pb-8 pt-20 sm:px-6 md:px-8 md:py-8"
        >
            <!-- Header -->
            <div
                class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between"
            >
                <h1
                    class="font-serif text-2xl font-bold text-[#163653]"
                >
                    Transactions
                </h1>

                <NuxtButton
                    type="button"
                    size="lg"
                    class="w-full bg-[#d2a33a] px-5 text-sm font-medium text-[#1f2d42] hover:bg-[#c1922e] sm:w-auto"
                    @click="openAddTransaction"
                >
                    <NuxtIcon
                        name="lucide:plus"
                        class="mr-2 h-4 w-4"
                    />
                    Add transaction
                </NuxtButton>
            </div>

            <!-- Search -->
            <div class="relative mb-4">
                <NuxtInput
                    v-model="search"
                    type="text"
                    placeholder="Search by title..."
                    class="h-9 w-full rounded-lg border-[#d7d2c4] bg-white pl-10 text-sm"
                />

                <NuxtIcon
                    name="lucide:search"
                    class="pointer-events-none absolute left-3 top-1/2 z-10 h-4 w-4 -translate-y-1/2 text-[#8a939d]"
                />
            </div>

            <!-- Count -->
            <p
                class="mb-2 text-xs text-[#8a939d]"
            >
                {{ filteredTransactions.length }}
                transactions
            </p>

            <!-- Loading -->
            <div
                v-if="loading"
                class="flex min-h-40 items-center justify-center rounded-xl border border-[#ddd7c8] bg-white"
            >
                <NuxtIcon
                    name="lucide:loader-circle"
                    class="h-7 w-7 animate-spin text-[#2f7655]"
                />
            </div>

            <!-- Error -->
            <NuxtAlert
                v-else-if="error"
                color="error"
                variant="soft"
                :description="error"
            />

            <template v-else>
                <!-- Empty -->
                <NuxtCard
                    v-if="!filteredTransactions.length"
                    class="flex min-h-[72px] items-center justify-center rounded-xl border border-[#ddd7c8] bg-white px-4 py-4 shadow-none"
                >
                    <p
                        class="text-center text-xs text-[#8a939d]"
                    >
                        No transactions yet. Add your first one
                        to start your ledger.
                    </p>
                </NuxtCard>

                <!-- Transactions -->
                <NuxtCard
                    v-else
                    class="overflow-hidden rounded-xl border border-[#ddd7c8] bg-white shadow-none"
                >
                    <div
                        class="divide-y divide-[#eeeae0]"
                    >
                        <div
                            v-for="transaction in filteredTransactions"
                            :key="transaction.id"
                            class="px-3 sm:px-4"
                        >
                            <div
                                class="flex items-center justify-between gap-3 py-4"
                            >
                                <!-- Details -->
                                <div
                                    class="min-w-0 flex-1"
                                >
                                    <p
                                        class="truncate text-sm font-medium text-[#1d211b]"
                                    >
                                        {{ transaction.title }}
                                    </p>

                                    <div
                                        class="mt-1 flex min-w-0 items-center gap-2"
                                    >
                                        <span
                                            class="shrink-0 text-xs text-[#8a939d]"
                                        >
                                            {{
                                                formatDate(
                                                    transaction.transactionDate,
                                                )
                                            }}
                                        </span>

                                        <span
                                            v-if="transaction.category"
                                            class="truncate text-xs text-[#8a939d]"
                                        >
                                            •
                                            {{
                                                transaction.category.name
                                            }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Amount + Actions -->
                                <div
                                    class="flex shrink-0 items-center gap-1 sm:gap-2"
                                >
                                    <p
                                        class="whitespace-nowrap text-sm font-semibold"
                                        :class="
                                            transaction.type === 'income'
                                                ? 'text-[#0f5c45]'
                                                : 'text-[#d9553d]'
                                        "
                                    >
                                        {{
                                            transaction.type === 'income'
                                                ? '+'
                                                : '-'
                                        }}₹{{
                                            formatAmount(
                                                transaction.amount,
                                            )
                                        }}
                                    </p>

                                    <button
                                        type="button"
                                        title="Edit transaction"
                                        aria-label="Edit transaction"
                                        class="flex h-8 w-8 items-center justify-center rounded-lg text-[#53677a] transition hover:bg-[#f5f3ed] hover:text-[#163653]"
                                        @click="
                                            openEditTransaction(
                                                transaction,
                                            )
                                        "
                                    >
                                        <NuxtIcon
                                            name="lucide:pencil"
                                            class="h-4 w-4"
                                        />
                                    </button>

                                    <button
                                        type="button"
                                        title="Delete transaction"
                                        aria-label="Delete transaction"
                                        class="flex h-8 w-8 items-center justify-center rounded-lg text-[#d9553d] transition hover:bg-[#fce9e5]"
                                        @click="
                                            deleteTransaction(
                                                transaction.id,
                                            )
                                        "
                                    >
                                        <NuxtIcon
                                            name="lucide:trash-2"
                                            class="h-4 w-4"
                                        />
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </NuxtCard>
            </template>
        </main>

        <!-- Add / Edit -->
        <TransactionCard
            v-if="showTransactionModal"
            :transaction="editingTransaction"
            @close="closeTransactionModal"
            @save="
                editingTransaction
                    ? updateTransaction
                    : saveTransaction
            "
        />
    </div>
</template>