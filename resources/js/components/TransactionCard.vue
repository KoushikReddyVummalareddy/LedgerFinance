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

const categoryItems = computed(() => {
    return filteredCategories.value.map(
        (category) => ({
            label: category.name,
            value: category.id,
        }),
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
        class="fixed inset-0 z-50 flex items-start justify-center overflow-y-auto bg-black/40 px-3 py-4 sm:items-center sm:px-4 sm:py-6"
    >
        <!-- Modal -->
        <div
            class="my-auto w-full max-w-[430px] rounded-xl bg-white p-4 shadow-xl sm:p-5"
        >
            <!-- Header -->
            <div
                class="mb-4 flex items-center justify-between"
            >
                <h2
                    class="font-serif text-lg font-bold text-[#163653] sm:text-xl"
                >
                    Add transaction
                </h2>

                <button
                    type="button"
                    aria-label="Close"
                    class="flex h-8 w-8 items-center justify-center rounded-lg text-[#8a939d] hover:bg-[#f5f3ed] hover:text-[#163653]"
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
                <!-- Expense -->
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

                <!-- Income -->
                <button
                    type="button"
                    class="h-9 rounded-lg border text-sm font-medium"
                    :class="
                        type === 'income'
                              ? 'border-[#0f5c45] bg-[#dceee7] text-[#0f5c45]'
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
                    placeholder="Enter Transaction Title"
                    class="w-full"
                />
            </div>

            <!-- Amount + Date -->
            <div
                class="mb-3 grid grid-cols-1 gap-3 sm:grid-cols-2"
            >
                <!-- Amount -->
                <div class="min-w-0">
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
                        class="w-full"
                    />
                </div>

                <!-- Date -->
                <div class="min-w-0">
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
                        class="w-full"
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

                <NuxtSelect
                    id="transaction-category"
                    v-model="categoryId"
                    :items="categoryItems"
                    value-key="value"
                    label-key="label"
                    placeholder="Choose a category"
                    :disabled="loading"
                    class="w-full"
                    :ui="{
                        content:
                            'z-[60] max-h-60 overflow-y-auto',
                    }"
                />
            </div>

            <!-- Loading -->
            <p
                v-if="loading"
                class="mb-3 text-xs text-[#8a939d]"
            >
                Loading categories...
            </p>

            <!-- No Categories -->
            <p
                v-else-if="
                    !filteredCategories.length &&
                    !error
                "
                class="mb-3 text-xs text-[#8a939d]"
            >
                No
                {{
                    type === 'expense'
                        ? 'expense'
                        : 'income'
                }}
                categories available.
            </p>

            <!-- Error -->
            <p
                v-if="error"
                class="mb-3 text-xs text-[#d9553d]"
            >
                {{ error }}
            </p>

            <!-- Actions -->
            <div
                class="flex flex-col-reverse gap-2 sm:flex-row sm:justify-end"
            >
                <NuxtButton
                    type="button"
                    variant="outline"
                    color="neutral"
                    class="w-full border-[#d7d2c4] bg-white px-4 text-sm text-[#1f2d42] sm:w-auto"
                    @click="emit('close')"
                >
                    Cancel
                </NuxtButton>

                <NuxtButton
                    type="button"
                    class="w-full bg-[#d2a33a] px-4 text-sm font-medium text-[#1f2d42] hover:bg-[#c1922e] sm:w-auto"
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