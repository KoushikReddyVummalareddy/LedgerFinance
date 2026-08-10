<script setup lang="ts">
import { computed, onMounted, ref } from 'vue';
import { CategoryService } from '../services/FinanceService';
import type { CategoryInterface } from '../interfaces/TransactionInterface';

const emit = defineEmits<{
    close: [];
    save: [
        {
            categoryId: number;
            title: string;
            amount: number;
            type: 'income' | 'expense';
            transactionDate: string;
            notes: string | null;
        },
    ];
}>();

const type = ref<'expense' | 'income'>('expense');
const title = ref('');
const amount = ref<number | null>(null);
const transactionDate = ref('');
const categoryId = ref<number | null>(null);

const categories = ref<CategoryInterface[]>([]);
const loading = ref(false);
const error = ref('');

const filteredCategories = computed(() => {
    return categories.value.filter(
        (category) => category.type === type.value,
    );
});

async function loadCategories() {
    loading.value = true;
    error.value = '';

    try {
        const response =
            await CategoryService.getCategories();

        categories.value = response.data.data;
    } catch {
        error.value = 'Unable to load categories.';
    } finally {
        loading.value = false;
    }
}

function selectType(
    selectedType: 'expense' | 'income',
) {
    type.value = selectedType;
    categoryId.value = null;
}

function save() {
    if (
        !title.value.trim() ||
        !amount.value ||
        !transactionDate.value ||
        !categoryId.value
    ) {
        return;
    }

    emit('save', {
        categoryId: categoryId.value,
        title: title.value.trim(),
        amount: Number(amount.value),
        type: type.value,
        transactionDate: transactionDate.value,
        notes: null,
    });
}

onMounted(() => {
    loadCategories();
});
</script>

<template>
    <!-- Overlay -->
    <div
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 px-4"
    >
        <!-- Modal -->
        <div
            class="w-full max-w-[430px] rounded-xl bg-white p-5 shadow-xl"
        >
            <!-- Header -->
            <div
                class="mb-4 flex items-center justify-between"
            >
                <h2
                    class="font-serif text-xl font-bold text-[#163653]"
                >
                    Add transaction
                </h2>

                <button
                    type="button"
                    aria-label="Close"
                    class="text-[#8a939d] hover:text-[#163653]"
                    @click="emit('close')"
                >
                    <NuxtIcon
                        name="lucide:x"
                        class="h-5 w-5"
                    />
                </button>
            </div>

            <!-- Transaction Type -->
            <div
                class="mb-4 grid grid-cols-2 gap-2"
            >
                <button
                    type="button"
                    class="h-9 rounded-lg border text-sm font-medium"
                    :class="
                        type === 'expense'
                            ? 'border-[#d9553d] bg-[#fce9e5] text-[#d9553d]'
                            : 'border-[#d7d2c4] bg-white text-[#53677a]'
                    "
                    @click="selectType('expense')"
                >
                    ↘ &nbsp; Expense
                </button>

                <button
                    type="button"
                    class="h-9 rounded-lg border text-sm font-medium"
                    :class="
                        type === 'income'
                            ? 'border-[#277c80] bg-[#e7f2ed] text-[#277c80]'
                            : 'border-[#d7d2c4] bg-white text-[#53677a]'
                    "
                    @click="selectType('income')"
                >
                    ↗ &nbsp; Income
                </button>
            </div>

            <!-- Title -->
            <div class="mb-3">
                <label
                    for="transaction-title"
                    class="mb-1 block text-[11px] font-medium uppercase tracking-wide text-[#53677a]"
                >
                    Title
                </label>

                <NuxtInput
                    id="transaction-title"
                    v-model="title"
                    type="text"
                    placeholder="e.g. Grocery run"
                    class="h-9 w-full rounded-lg border-[#d7d2c4] bg-white text-sm"
                />
            </div>

            <!-- Amount + Date -->
            <div
                class="mb-3 grid grid-cols-2 gap-3"
            >
                <!-- Amount -->
                <div>
                    <label
                        for="transaction-amount"
                        class="mb-1 block text-[11px] font-medium uppercase tracking-wide text-[#53677a]"
                    >
                        Amount
                    </label>

                    <NuxtInput
                        id="transaction-amount"
                        v-model="amount"
                        type="number"
                        min="0"
                        step="0.01"
                        placeholder="0.00"
                        class="h-9 w-full rounded-lg border-[#d7d2c4] bg-white text-sm"
                    />
                </div>

                <!-- Date -->
                <div>
                    <label
                        for="transaction-date"
                        class="mb-1 block text-[11px] font-medium uppercase tracking-wide text-[#53677a]"
                    >
                        Date
                    </label>

                    <NuxtInput
                        id="transaction-date"
                        v-model="transactionDate"
                        type="date"
                        class="h-9 w-full rounded-lg border-[#d7d2c4] bg-white text-sm"
                    />
                </div>
            </div>

            <!-- Category -->
            <div class="mb-4">
                <label
                    for="transaction-category"
                    class="mb-1 block text-[11px] font-medium uppercase tracking-wide text-[#53677a]"
                >
                    Category
                </label>

                <select
                    id="transaction-category"
                    v-model="categoryId"
                    class="h-9 w-full rounded-lg border border-[#d7d2c4] bg-white px-3 text-sm text-[#1f2d42] outline-none focus:border-[#53677a]"
                >
                    <option
                        :value="null"
                        disabled
                    >
                        Choose a category
                    </option>

                    <option
                        v-for="category in filteredCategories"
                        :key="category.id"
                        :value="category.id"
                    >
                        {{ category.name }}
                    </option>
                </select>
            </div>

            <!-- Error -->
            <p
                v-if="error"
                class="mb-3 text-xs text-[#d9553d]"
            >
                {{ error }}
            </p>

            <!-- Actions -->
            <div
                class="flex justify-end gap-2"
            >
                <NuxtButton
                    type="button"
                    variant="outline"
                    color="neutral"
                    class="border-[#d7d2c4] bg-white px-4 text-sm text-[#1f2d42]"
                    @click="emit('close')"
                >
                    Cancel
                </NuxtButton>

                <NuxtButton
                    type="button"
                    class="bg-[#d2a33a] px-4 text-sm font-medium text-[#1f2d42] hover:bg-[#c1922e]"
                    :disabled="
                        loading ||
                        !title.trim() ||
                        !amount ||
                        !transactionDate ||
                        !categoryId
                    "
                    @click="save"
                >
                    <NuxtIcon
                        name="lucide:check"
                        class="mr-2 h-4 w-4"
                    />

                    Save transaction
                </NuxtButton>
            </div>
        </div>
    </div>
</template>