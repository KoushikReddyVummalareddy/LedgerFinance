<script setup lang="ts">
import { ref, computed } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { VueRouteEnum } from '../enums/VueRouteEnum';
import { useAuthStore } from '../store/authStore';

const route = useRoute();
const router = useRouter();
const authStore = useAuthStore();

const isCollapsed = ref(false);

const user = computed(() => authStore.user);

const userInitial = computed(() => {
    return user.value?.name?.charAt(0).toUpperCase() ?? 'U';
});

const toggleSidebar = () => {
    isCollapsed.value = !isCollapsed.value;
};

const goToDashboard = () => {
    router.push({
        name: VueRouteEnum.COMMONS.DASHBOARD,
    });
};

const goToTransactions = () => {
    router.push({
        name: VueRouteEnum.COMMONS.TRANSACTIONS,
    });
};

const isDashboard = () => {
    return route.name === VueRouteEnum.COMMONS.DASHBOARD;
};

const isTransactions = () => {
    return route.name === VueRouteEnum.COMMONS.TRANSACTIONS;
};
</script>

<template>
    <aside
        class="relative flex min-h-screen flex-col bg-[#1f2d42] text-white transition-all duration-300"
        :class="isCollapsed ? 'w-16' : 'w-48'"
    >
        <!-- Header -->
        <div
            class="flex h-16 items-center px-4"
            :class="
                isCollapsed
                    ? 'justify-center'
                    : 'justify-start'
            "
        >
            <!-- Logo -->
            <div
                class="flex items-center gap-3"
                :class="
                    isCollapsed
                        ? 'justify-center'
                        : ''
                "
            >
                <div
                    class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-[#d2a33a]"
                >
                    <NuxtIcon
                        name="lucide:wallet"
                        class="h-4 w-4 text-[#1f2d42]"
                    />
                </div>

                <span
                    v-if="!isCollapsed"
                    class="text-lg font-bold"
                >
                    Ledger
                </span>
            </div>
        </div>

        <!-- Navigation -->
        <nav
            class="mt-4"
            :class="
                isCollapsed
                    ? 'px-2'
                    : 'px-3'
            "
        >
            <!-- Dashboard -->
            <NuxtButton
                type="button"
                variant="ghost"
                color="neutral"
                :class="[
                    'w-full',
                    isCollapsed
                        ? 'justify-center px-0'
                        : 'justify-start',
                    isDashboard()
                        ? 'bg-[#344156] text-[#d2a33a]'
                        : 'text-white',
                ]"
                :aria-label="
                    isCollapsed
                        ? 'Dashboard'
                        : undefined
                "
                @click="goToDashboard"
            >
                <NuxtIcon
                    name="lucide:layout-dashboard"
                    class="h-4 w-4 shrink-0"
                    :class="
                        isCollapsed
                            ? ''
                            : 'mr-2'
                    "
                />

                <span v-if="!isCollapsed">
                    Dashboard
                </span>
            </NuxtButton>

            <!-- Transactions -->
            <NuxtButton
                type="button"
                variant="ghost"
                color="neutral"
                :class="[
                    'mt-1 w-full',
                    isCollapsed
                        ? 'justify-center px-0'
                        : 'justify-start',
                    isTransactions()
                        ? 'bg-[#344156] text-[#d2a33a]'
                        : 'text-white',
                ]"
                :aria-label="
                    isCollapsed
                        ? 'Transactions'
                        : undefined
                "
                @click="goToTransactions"
            >
                <NuxtIcon
                    name="lucide:list"
                    class="h-4 w-4 shrink-0"
                    :class="
                        isCollapsed
                            ? ''
                            : 'mr-2'
                    "
                />

                <span v-if="!isCollapsed">
                    Transactions
                </span>
            </NuxtButton>
        </nav>

        <!-- Bottom Section -->
        <div class="mt-auto">

            <!-- Collapse / Expand -->
            <div
                class="border-t border-[#344156]"
                :class="
                    isCollapsed
                        ? 'px-2 py-3'
                        : 'px-3 py-3'
                "
            >
                <NuxtButton
                    type="button"
                    variant="ghost"
                    color="neutral"
                    :class="[
                        'w-full text-[#9ba6b5] hover:bg-[#344156] hover:text-white',
                        isCollapsed
                            ? 'justify-center px-0'
                            : 'justify-start',
                    ]"
                    :aria-label="
                        isCollapsed
                            ? 'Expand sidebar'
                            : 'Collapse sidebar'
                    "
                    @click="toggleSidebar"
                >
                    <NuxtIcon
                        :name="
                            isCollapsed
                                ? 'lucide:chevron-right'
                                : 'lucide:chevron-left'
                        "
                        class="h-4 w-4 shrink-0"
                        :class="
                            isCollapsed
                                ? ''
                                : 'mr-2'
                        "
                    />

                    <span v-if="!isCollapsed">
                        Collapse
                    </span>
                </NuxtButton>
            </div>

            <!-- User -->
            <div
                class="border-t border-[#344156]"
                :class="
                    isCollapsed
                        ? 'px-2 py-4'
                        : 'px-4 py-4'
                "
            >
                <div
                    class="flex items-center"
                    :class="
                        isCollapsed
                            ? 'justify-center'
                            : 'gap-3'
                    "
                >
                    <!-- User Initial -->
                    <div
                        class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-[#344156] text-xs"
                    >
                        {{ userInitial }}
                    </div>

                    <!-- User Details -->
                    <div
                        v-if="!isCollapsed"
                        class="min-w-0"
                    >
                        <p
                            class="truncate text-xs font-medium text-white"
                        >
                            {{ user?.name ?? 'User' }}
                        </p>

                        <p
                            class="truncate text-[10px] text-[#9ba6b5]"
                        >
                            {{ user?.email ?? '' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </aside>
</template>