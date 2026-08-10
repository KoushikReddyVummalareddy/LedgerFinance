<script setup lang="ts">
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';

import Sidebar from '../../components/Sidebar.vue';
import TransactionCard from '../../components/TransactionCard.vue';

import { useDashboard } from './composables/useDashboard';
import { TransactionService } from '../../services/FinanceService';

const router = useRouter();

const {
    dashboard,
    loading,
    error,
    getDashboard,
} = useDashboard();

const showAddTransaction = ref(false);

const openAddTransaction = () => {
    showAddTransaction.value = true;
};

const closeAddTransaction = () => {
    showAddTransaction.value = false;
};

const saveTransaction = async (transaction: {
    title: string;
    amount: number;
    type: 'income' | 'expense';
    transactionDate: string;
    categoryId: number;
}) => {
    try {
        await TransactionService.createTransaction({
            title: transaction.title,
            amount: transaction.amount,
            type: transaction.type,
            transactionDate: transaction.transactionDate,
            categoryId: transaction.categoryId,
            notes: null,
        });

        closeAddTransaction();

        await getDashboard();
    } catch (err) {
        console.error(err);
    }
};

const goToTransactions = () => {
    router.push({
        name: 'transactions',
    });
};

const formatAmount = (amount: number) => {
    return Number(amount).toFixed(2);
};

onMounted(() => {
    getDashboard();
});
</script>

<template>
    <div class="flex min-h-screen bg-[#f7f5ef]">
        <!-- Sidebar -->
        <Sidebar />

        <!-- Content -->
        <main class="flex-1 px-8 py-8">

            <!-- Loading -->
            <div
                v-if="loading"
                class="flex min-h-64 items-center justify-center"
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

            <!-- Dashboard -->
            <template v-else-if="dashboard">

                <!-- Balance -->
                <div
                    class="flex items-end justify-between"
                >
                    <div>
                        <p
                            class="text-xs font-medium uppercase tracking-wide text-[#7d8b9b]"
                        >
                            Current Balance
                        </p>

                        <h1
                            class="mt-1 text-4xl font-bold text-[#163653]"
                        >
                            $
                            {{ formatAmount(dashboard.currentBalance) }}
                        </h1>

                        <div
                            class="mt-2 h-0.5 w-44 bg-[#d2a33a]"
                        />
                    </div>

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

                <!-- Summary -->
                <div
                    class="mt-5 grid grid-cols-2 gap-4"
                >
                    <!-- Income -->
                    <NuxtCard
                        class="rounded-xl border border-[#ddd7c8] bg-white shadow-none"
                    >
                        <div
                            class="flex items-center gap-2"
                        >
                            <div
                                class="flex h-6 w-6 items-center justify-center rounded-md bg-[#e7f2ed]"
                            >
                                <NuxtIcon
                                    name="lucide:arrow-up-right"
                                    class="h-3.5 w-3.5 text-[#277c80]"
                                />
                            </div>

                            <p
                                class="text-xs font-medium uppercase tracking-wide text-[#53677a]"
                            >
                                Total Income
                            </p>
                        </div>

                        <p
                            class="mt-3 text-xl font-semibold text-[#277c80]"
                        >
                            $
                            {{ formatAmount(dashboard.totalIncome) }}
                        </p>
                    </NuxtCard>

                    <!-- Expenses -->
                    <NuxtCard
                        class="rounded-xl border border-[#ddd7c8] bg-white shadow-none"
                    >
                        <div
                            class="flex items-center gap-2"
                        >
                            <div
                                class="flex h-6 w-6 items-center justify-center rounded-md bg-[#fce9e5]"
                            >
                                <NuxtIcon
                                    name="lucide:arrow-down-right"
                                    class="h-3.5 w-3.5 text-[#d9553d]"
                                />
                            </div>

                            <p
                                class="text-xs font-medium uppercase tracking-wide text-[#53677a]"
                            >
                                Total Expenses
                            </p>
                        </div>

                        <p
                            class="mt-3 text-xl font-semibold text-[#d9553d]"
                        >
                            $
                            {{ formatAmount(dashboard.totalExpense) }}
                        </p>
                    </NuxtCard>
                </div>

                <!-- Recent Transactions -->
                <section class="mt-7">
                    <p
                        class="mb-2 text-xs font-medium uppercase tracking-wide text-[#7d8b9b]"
                    >
                        Recent Transactions
                    </p>

                    <NuxtCard
                        class="rounded-xl border border-[#ddd7c8] bg-white shadow-none"
                    >
                        <!-- Empty -->
                        <div
                            v-if="
                                !dashboard.recentTransactions?.length
                            "
                            class="flex h-[72px] items-center justify-center"
                        >
                            <p
                                class="text-xs text-[#8a939d]"
                            >
                                No transactions yet. Add your first one to start your ledger.
                            </p>
                        </div>

                        <!-- Transactions -->
                        <div
                            v-else
                            class="divide-y divide-[#eeeae0]"
                        >
                            <div
                                v-for="transaction in dashboard.recentTransactions"
                                :key="transaction.id"
                                class="cursor-pointer py-3 transition hover:bg-[#f8f6ef]"
                                @click="goToTransactions"
                            >
                                <div
                                    class="flex items-center justify-between"
                                >
                                    <div>
                                        <p
                                            class="text-sm font-medium text-[#1d211b]"
                                        >
                                            {{ transaction.title }}
                                        </p>

                                        <p
                                            class="mt-1 text-xs text-[#8a939d]"
                                        >
                                            {{ transaction.transactionDate }}
                                        </p>
                                    </div>

                                    <p
                                        class="text-sm font-semibold"
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
                                            formatAmount(transaction.amount)
                                        }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </NuxtCard>
                </section>
            </template>
        </main>

        <!-- Add Transaction Modal -->
        <TransactionCard
            v-if="showAddTransaction"
            @close="closeAddTransaction"
            @save="saveTransaction"
        />
    </div>
</template>