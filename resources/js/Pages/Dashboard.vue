<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="dark:text-gray-300 py-4 px-4">
                        <p class="mb-2">Hello {{ $page.props.auth.user.member.name }}!</p>
                        <p class="mb-2">Your status is: {{ $page.props.auth.user.member.status }}</p>
                        <p class="mb-2">Your live in: {{ $page.props.auth.user.member.county }}</p>
                        <p class="mb-2">Your Member Number is: {{ $page.props.auth.user.member.member_number }}</p>

                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
