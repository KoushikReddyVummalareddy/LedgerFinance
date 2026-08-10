<script setup lang="ts">
import { computed, onMounted, ref } from 'vue';

import Sidebar from '../../components/Sidebar.vue';
import TransactionCard from '../../components/TransactionCard.vue';

import { useTransaction } from './composables/useTransactions';

const {
    transactions,
    loading,
    error,
    getTransactions,
    createTransaction,
} = useTransaction();

const search = ref('');
const showAddTransaction = ref(false);

const filteredTransactions = computed(() => {
    const value = search.value
        .trim()
        .toLowerCase();

    if (!value) {
        return transactions.value;
    }

    return transactions.value.filter(
        (transaction) =>
            transaction.title
                .toLowerCase()
                .includes(value),
    );
});

const openAddTransaction = () => {
    showAddTransaction.value = true;
};

const closeAddTransaction = () => {
    showAddTransaction.value = false;
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

        closeAddTransaction();
    } catch {
        // Error is handled by useTransaction.
    }
};

const formatAmount = (amount: number) => {
    return Number(amount).toFixed(2);
};

onMounted(() => {
    getTransactions();
});
</script>

<template>
    <div class="flex min-h-screen bg-[#f7f5ef]">
        <!-- Sidebar -->
        <Sidebar />

        <!-- Content -->
        <main class="flex-1 px-8 py-8">

            <!-- Header -->
            <div
                class="mb-4 flex items-center justify-between"
            >
                <h1
                    class="font-serif text-2xl font-bold text-[#163653]"
                >
                    Transactions
                </h1>

                <NuxtButton
                    type="button"
                    size="lg"
                    class="bg-[#d2a33a] px-5 text-sm font-medium text-[#1f2d42] hover:bg-[#c1922e]"
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
                <NuxtIcon
                    name="lucide:search"
                    class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-[#8a939d]"
                />

                <NuxtInput
                    v-model="search"
                    type="text"
                    placeholder="Search by title..."
                    class="h-9 w-full rounded-lg border-[#d7d2c4] bg-white pl-9 text-sm"
                />
            </div>

            <!-- Transaction Count -->
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

            <!-- Transactions -->
            <template v-else>

                <!-- Empty -->
                <NuxtCard
                    v-if="!filteredTransactions.length"
                    class="flex h-[72px] items-center justify-center rounded-xl border border-[#ddd7c8] bg-white shadow-none"
                >
                    <p
                        class="text-xs text-[#8a939d]"
                    >
                        No transactions yet. Add your first one to start your ledger.
                    </p>
                </NuxtCard>

                <!-- Transaction List -->
                <NuxtCard
                    v-else
                    class="rounded-xl border border-[#ddd7c8] bg-white shadow-none"
                >
                    <div
                        class="divide-y divide-[#eeeae0]"
                    >
                        <div
                            v-for="transaction in filteredTransactions"
                            :key="transaction.id"
                            class="px-4"
                        >
                            <div
                                class="flex items-center justify-between py-4"
                            >
                                <div class="min-w-0">
                                    <p
                                        class="truncate text-sm font-medium text-[#1d211b]"
                                    >
                                        {{ transaction.title }}
                                    </p>

                                    <div
                                        class="mt-1 flex items-center gap-2"
                                    >
                                        <span
                                            class="text-xs text-[#8a939d]"
                                        >
                                            {{
                                                transaction.transactionDate
                                            }}
                                        </span>

                                        <span
                                            v-if="transaction.category"
                                            class="text-xs text-[#8a939d]"
                                        >
                                            •
                                            {{
                                                transaction.category.name
                                            }}
                                        </span>
                                    </div>
                                </div>

                                <p
                                    class="ml-4 shrink-0 text-sm font-semibold"
                                    :class="
                                        transaction.type === 'income'
                                            ? 'text-[#277c80]'
                                            : 'text-[#d9553d]'
                                    "
                                >
                                    {{
                                        transaction.type === 'income'
                                            ? '+'
                                            : '-'
                                    }}${{
                                        formatAmount(
                                            transaction.amount,
                                        )
                                    }}
                                </p>
                            </div>
                        </div>
                    </div>
                </NuxtCard>
            </template>
        </main>

        <!-- Add Transaction -->
        <TransactionCard
            v-if="showAddTransaction"
            @close="closeAddTransaction"
            @save="saveTransaction"
        />
    </div>
</template>