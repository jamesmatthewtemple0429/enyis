<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.transform(data => ({
        ...data,
        remember: form.remember ? 'on' : '',
    })).post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Log in" />

    <AuthenticationCard>
        <template #logo>
            <AuthenticationCardLogo />
        </template>

        <div class="text-center font-bold text-gray-700 dark:text-gray-300 mb-8">Eastern New York Information System</div>

        <div class="text-center text-gray-700 dark:text-gray-300 mb-8">The Eastern New York Information System is designed to aid the Eastern New York Region's Disaster Cycle Services in managing its operations. In order to access this system, you must be Employee or Volunteer of the Eastern New York Region and have a Red Cross Issued Email Address. Click the link below to sign in now.</div>

        <a :href="route('auth.redirect')"><div class="text-center"><PrimaryButton>Sign in with Microsoft</PrimaryButton></div></a>
    </AuthenticationCard>
</template>
