<script setup lang="ts">
import { ref, computed } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { VueRouteEnum } from '../enums/VueRouteEnum';
import { useAuthStore } from '../store/authStore';

const route = useRoute();
const router = useRouter();
const authStore = useAuthStore();

const isMobileOpen = ref(false);

const user = computed(() => authStore.user);

const userInitial = computed(() => {
    return user.value?.name?.charAt(0).toUpperCase() ?? 'U';
});

const toggleMobileSidebar = () => {
    isMobileOpen.value = !isMobileOpen.value;
};

const closeMobileSidebar = () => {
    isMobileOpen.value = false;
};

const goToDashboard = () => {
    router.push({
        name: VueRouteEnum.COMMONS.DASHBOARD,
    });

    closeMobileSidebar();
};

const goToTransactions = () => {
    router.push({
        name: VueRouteEnum.COMMONS.TRANSACTIONS,
    });

    closeMobileSidebar();
};

const isDashboard = () => {
    return route.name === VueRouteEnum.COMMONS.DASHBOARD;
};

const isTransactions = () => {
    return route.name === VueRouteEnum.COMMONS.TRANSACTIONS;
};
</script>

<template>
    <!-- Mobile Header -->
    <header
        class="fixed left-0 right-0 top-0 z-30 flex h-16 items-center bg-[#1f2d42] px-4 text-white md:hidden"
    >
        <NuxtButton
            type="button"
            variant="ghost"
            color="neutral"
            class="!px-2 text-white hover:bg-[#344156]"
            aria-label="Open sidebar"
            @click="toggleMobileSidebar"
        >
            <NuxtIcon
                name="lucide:menu"
                class="h-5 w-5"
            />
        </NuxtButton>

        <div class="ml-3 flex items-center gap-2">
            <div
                class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#d2a33a]"
            >
                <NuxtIcon
                    name="lucide:wallet"
                    class="h-4 w-4 text-[#1f2d42]"
                />
            </div>

            <span class="text-lg font-bold">
                Ledger
            </span>
        </div>
    </header>

    <!-- Mobile Backdrop -->
    <div
        v-if="isMobileOpen"
        class="fixed inset-0 z-40 bg-black/50 md:hidden"
        @click="closeMobileSidebar"
    />

    <!-- Sidebar -->
    <aside
        class="
            fixed
            left-0
            top-0
            z-50
            flex
            min-h-screen
            w-64
            flex-col
            bg-[#1f2d42]
            text-white
            transition-transform
            duration-300
            ease-in-out
            md:relative
            md:z-auto
            md:w-48
            md:translate-x-0
        "
        :class="
            isMobileOpen
                ? 'translate-x-0'
                : '-translate-x-full'
        "
    >
        <!-- Header -->
        <div
            class="flex h-16 items-center justify-between px-4"
        >
            <!-- Logo -->
            <div class="flex items-center gap-3">
                <div
                    class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-[#d2a33a]"
                >
                    <NuxtIcon
                        name="lucide:wallet"
                        class="h-4 w-4 text-[#1f2d42]"
                    />
                </div>

                <span class="text-lg font-bold">
                    Ledger
                </span>
            </div>

            <!-- Mobile Close -->
            <NuxtButton
                type="button"
                variant="ghost"
                color="neutral"
                class="!px-2 text-white hover:bg-[#344156] md:hidden"
                aria-label="Close sidebar"
                @click="closeMobileSidebar"
            >
                <NuxtIcon
                    name="lucide:x"
                    class="h-5 w-5"
                />
            </NuxtButton>
        </div>

        <!-- Navigation -->
        <nav class="mt-4 px-3">
            <!-- Dashboard -->
            <NuxtButton
                type="button"
                variant="ghost"
                color="neutral"
                :class="[
                    'w-full justify-start',
                    isDashboard()
                        ? 'bg-[#344156] text-[#d2a33a]'
                        : 'text-white',
                ]"
                @click="goToDashboard"
            >
                <NuxtIcon
                    name="lucide:layout-dashboard"
                    class="mr-2 h-4 w-4 shrink-0"
                />

                <span>
                    Dashboard
                </span>
            </NuxtButton>

            <!-- Transactions -->
            <NuxtButton
                type="button"
                variant="ghost"
                color="neutral"
                :class="[
                    'mt-1 w-full justify-start',
                    isTransactions()
                        ? 'bg-[#344156] text-[#d2a33a]'
                        : 'text-white',
                ]"
                @click="goToTransactions"
            >
                <NuxtIcon
                    name="lucide:list"
                    class="mr-2 h-4 w-4 shrink-0"
                />

                <span>
                    Transactions
                </span>
            </NuxtButton>
        </nav>

        <!-- User -->
        <div
            class="mt-auto border-t border-[#344156] px-4 py-4"
        >
            <div class="flex items-center gap-3">
                <!-- User Initial -->
                <div
                    class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-[#344156] text-xs"
                >
                    {{ userInitial }}
                </div>

                <!-- User Details -->
                <div class="min-w-0">
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
    </aside>
</template>