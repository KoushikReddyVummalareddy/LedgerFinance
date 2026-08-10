<script setup lang="ts">
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { useAuth } from './composables/useAuth';

const router = useRouter();

const { register, loading, error } = useAuth();

const name = ref('');
const email = ref('');
const password = ref('');
const passwordConfirmation = ref('');

const goToLogin = () => {
    router.push('/login');
};

const handleRegister = async () => {
    try {
        await register(
            name.value,
            email.value,
            password.value,
            passwordConfirmation.value,
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
            <div class="mb-6 text-center">
                <img
                    src="/images/ledgerfinance.png"
                    alt="LedgerFinance"
                    class="mx-auto mb-3 h-20 w-20 object-contain"
                />

                <h1 class="text-3xl font-bold tracking-tight text-[#1d211b]">
                    LedgerFinance
                </h1>

                <p class="mt-2 text-base text-[#657064]">
                    A quiet place to keep the household accounts.
                </p>
            </div>

            <NuxtCard
                class="rounded-2xl border-[#ddd7c8] bg-[#fcfaf5] shadow-sm"
            >
                <div
                    class="mb-6 grid grid-cols-2 overflow-hidden rounded-xl border border-[#d7d2c4]"
                >
                    <NuxtButton
                        type="button"
                        color="neutral"
                        variant="ghost"
                        size="lg"
                        class="rounded-none"
                        @click="goToLogin"
                    >
                        Log in
                    </NuxtButton>

                    <NuxtButton
                        type="button"
                        size="lg"
                        class="rounded-none bg-[#2f7655] text-white hover:bg-[#28664a]"
                    >
                        Register
                    </NuxtButton>
                </div>

                <NuxtForm
                    :state="{
                        name,
                        email,
                        password,
                        passwordConfirmation,
                    }"
                    class="space-y-5"
                    @submit="handleRegister"
                >
                    <NuxtFormField
                        label="Name"
                        name="name"
                    >
                        <NuxtInput
                            v-model="name"
                            type="text"
                            autocomplete="name"
                            placeholder="Your name"
                            class="w-full"
                        />
                    </NuxtFormField>

                    <NuxtFormField
                        label="Email"
                        name="email"
                    >
                        <NuxtInput
                            v-model="email"
                            type="email"
                            autocomplete="email"
                            placeholder="you@example.com"
                            class="w-full"
                        />
                    </NuxtFormField>

                    <NuxtFormField
                        label="Password"
                        name="password"
                    >
                        <NuxtInput
                            v-model="password"
                            type="password"
                            autocomplete="new-password"
                            placeholder="Your password"
                            class="w-full"
                        />
                    </NuxtFormField>

                    <NuxtFormField
                        label="Confirm Password"
                        name="password_confirmation"
                    >
                        <NuxtInput
                            v-model="passwordConfirmation"
                            type="password"
                            autocomplete="new-password"
                            placeholder="Confirm your password"
                            class="w-full"
                        />
                    </NuxtFormField>

                    <NuxtAlert
                        v-if="error"
                        color="error"
                        variant="soft"
                        :description="error"
                    />

                    <NuxtButton
                        type="submit"
                        block
                        :loading="loading"
                        class="bg-[#2f7655] text-white hover:bg-[#28664a]"
                    >
                        {{
                            loading
                                ? 'Creating account...'
                                : 'Register'
                        }}
                    </NuxtButton>
                </NuxtForm>

                <p class="mt-6 text-center text-sm text-[#817d70]">
                    Your data stays on your account only.
                </p>
            </NuxtCard>
        </div>
    </div>
</template>