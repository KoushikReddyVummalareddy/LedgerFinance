<script setup lang="ts">
import { ref } from 'vue';
import type { TransactionInterface } from '../interfaces/TransactionInterface';

const props = defineProps<{
    transaction: TransactionInterface;
}>();

const expanded = ref(false);

function formatDate(date: string): string {
    return date.substring(0, 10);
}
</script>

<template>
    <div
        class="cursor-pointer px-4 py-4 transition hover:bg-[#f8f6ef]"
        @click="expanded = !expanded"
    >
        <!-- Transaction -->
        <div class="flex items-center justify-between">
            <div class="min-w-0">
                <p
                    class="truncate text-sm font-medium text-[#1d211b]"
                >
                    {{ props.transaction.title }}
                </p>

                <div
                    class="mt-1 flex items-center gap-2"
                >
                    <span
                        class="text-xs text-[#8a939d]"
                    >
                        {{
                            formatDate(
                                props.transaction.transactionDate,
                            )
                        }}
                    </span>

                    <span
                        v-if="props.transaction.category"
                        class="text-xs text-[#8a939d]"
                    >
                        •
                        {{ props.transaction.category.name }}
                    </span>
                </div>
            </div>

            <div
                class="ml-4 flex shrink-0 items-center gap-3"
            >
                <p
                    class="text-sm font-semibold"
                    :class="
                        props.transaction.type === 'income'
                            ? 'text-[#277c80]'
                            : 'text-[#d9553d]'
                    "
                >
                    {{
                        props.transaction.type === 'income'
                            ? '+'
                            : '-'
                    }}${{
                        formatAmount(
                            props.transaction.amount,
                        )
                    }}
                </p>

                <NuxtIcon
                    name="lucide:chevron-down"
                    class="h-4 w-4 text-[#8a939d] transition-transform"
                    :class="
                        expanded
                            ? 'rotate-180'
                            : ''
                    "
                />
            </div>
        </div>

        <!-- Expanded Details -->
        <div
            v-if="expanded"
            class="mt-4 border-t border-[#eeeae0] pt-4"
        >
            <div
                class="grid grid-cols-2 gap-x-6 gap-y-4"
            >
                <!-- Title -->
                <div>
                    <p
                        class="text-[11px] font-medium uppercase tracking-wide text-[#8a939d]"
                    >
                        Title
                    </p>

                    <p
                        class="mt-1 text-sm text-[#1d211b]"
                    >
                        {{ props.transaction.title }}
                    </p>
                </div>

                <!-- Amount -->
                <div>
                    <p
                        class="text-[11px] font-medium uppercase tracking-wide text-[#8a939d]"
                    >
                        Amount
                    </p>

                    <p
                        class="mt-1 text-sm font-semibold"
                        :class="
                            props.transaction.type === 'income'
                                ? 'text-[#277c80]'
                                : 'text-[#d9553d]'
                        "
                    >
                        {{
                            props.transaction.type === 'income'
                                ? '+'
                                : '-'
                        }}${{
                            formatAmount(
                                props.transaction.amount,
                            )
                        }}
                    </p>
                </div>

                <!-- Category -->
                <div>
                    <p
                        class="text-[11px] font-medium uppercase tracking-wide text-[#8a939d]"
                    >
                        Category
                    </p>

                    <p
                        class="mt-1 text-sm text-[#1d211b]"
                    >
                        {{
                            props.transaction.category?.name ??
                            '-'
                        }}
                    </p>
                </div>

                <!-- Date -->
                <div>
                    <p
                        class="text-[11px] font-medium uppercase tracking-wide text-[#8a939d]"
                    >
                        Date
                    </p>

                    <p
                        class="mt-1 text-sm text-[#1d211b]"
                    >
                        {{
                            formatDate(
                                props.transaction.transactionDate,
                            )
                        }}
                    </p>
                </div>

                <!-- Type -->
                <div>
                    <p
                        class="text-[11px] font-medium uppercase tracking-wide text-[#8a939d]"
                    >
                        Type
                    </p>

                    <p
                        class="mt-1 text-sm capitalize text-[#1d211b]"
                    >
                        {{ props.transaction.type }}
                    </p>
                </div>

                <!-- Notes -->
                <div
                    v-if="props.transaction.notes"
                >
                    <p
                        class="text-[11px] font-medium uppercase tracking-wide text-[#8a939d]"
                    >
                        Notes
                    </p>

                    <p
                        class="mt-1 text-sm text-[#1d211b]"
                    >
                        {{ props.transaction.notes }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>