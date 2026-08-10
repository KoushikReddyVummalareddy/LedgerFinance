<script setup lang="ts">
import { reactive, ref } from 'vue';
import { useRouter } from 'vue-router';
import { useAuth } from './composables/useAuth';

const router = useRouter();

const { login, loading, error } = useAuth();

const form = reactive({
    email: '',
    password: '',
});

const showPassword = ref(false);

const goToRegister = () => {
    router.push('/register');
};

const handleLogin = async () => {
    try {
        await login(
            form.email,
            form.password,
        );

        await router.push('/dashboard');
    } catch {
        // Error is handled by useAuth.
    }
};
</script>

<template>
    <div class="min-h-screen bg-[#f8f7f2] px-4 py-8">
        <div class="mx-auto w-full max-w-lg">

            <!-- Header -->
            <div class="mb-6 text-center">
                <img
                    src="/images/ledgerfinance.png"
                    alt="LedgerFinance"
                    class="mx-auto mb-3 h-20 w-20 object-contain"
                />

                <h1
                    class="text-3xl font-bold tracking-tight text-[#1d211b]"
                >
                    LedgerFinance
                </h1>

                <p class="mt-2 text-base text-[#657064]">
                    A quiet place to keep the household accounts.
                </p>
            </div>

            <!-- Login Card -->
            <NuxtCard
                class="rounded-2xl border-[#ddd7c8] bg-[#fcfaf5] shadow-sm"
            >
                <!-- Tabs -->
                <div
                    class="mb-6 grid grid-cols-2 overflow-hidden rounded-xl border border-[#d7d2c4]"
                >
                    <NuxtButton
                        type="button"
                        size="lg"
                        class="rounded-none bg-[#2f7655] text-white hover:bg-[#28664a]"
                    >
                        Log in
                    </NuxtButton>

                    <NuxtButton
                        type="button"
                        color="neutral"
                        variant="ghost"
                        size="lg"
                        class="rounded-none"
                        @click="goToRegister"
                    >
                        Register
                    </NuxtButton>
                </div>

                <!-- Form -->
                <NuxtForm
                    :state="form"
                    class="space-y-5"
                    @submit="handleLogin"
                >
                    <!-- Email -->
                    <NuxtFormField
                        label="Email"
                        name="email"
                    >
                        <NuxtInput
                            v-model="form.email"
                            type="email"
                            autocomplete="email"
                            placeholder="you@example.com"
                            class="w-full"
                        />
                    </NuxtFormField>

                    <!-- Password -->
                    <NuxtFormField
                        label="Password"
                        name="password"
                    >
                        <NuxtInput
                            v-model="form.password"
                            :type="
                                showPassword
                                    ? 'text'
                                    : 'password'
                            "
                            autocomplete="current-password"
                            placeholder="Your password"
                            class="w-full"
                        >
                            <template #trailing>
                                <NuxtButton
                                    type="button"
                                    color="neutral"
                                    variant="ghost"
                                    :icon="
                                        showPassword
                                            ? 'lucide:eye-off'
                                            : 'lucide:eye'
                                    "
                                    :aria-label="
                                        showPassword
                                            ? 'Hide password'
                                            : 'Show password'
                                    "
                                    @click="
                                        showPassword =
                                            !showPassword
                                    "
                                />
                            </template>
                        </NuxtInput>
                    </NuxtFormField>

                    <!-- Error -->
                    <NuxtAlert
                        v-if="error"
                        color="error"
                        variant="soft"
                        :description="error"
                    />

                    <!-- Login -->
                    <NuxtButton
                        type="submit"
                        block
                        :loading="loading"
                        class="bg-[#2f7655] text-white hover:bg-[#28664a]"
                    >
                        {{
                            loading
                                ? 'Logging in...'
                                : 'Log in'
                        }}
                    </NuxtButton>
                </NuxtForm>

                <!-- Privacy -->
                <p class="mt-6 text-center text-sm text-[#817d70]">
                    Your data stays on your account only.
                </p>
            </NuxtCard>
        </div>
    </div>
</template>