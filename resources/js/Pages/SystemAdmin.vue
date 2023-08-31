<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { Head, Link, router } from '@inertiajs/vue3';
</script>

<script>
    export default {
        props: ['sectionChunks']
    }
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
                <div class="bg-white dark:text-gray-300 dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                   <div class="py-4 px-4">
                       <div v-for="sectionSet in sectionChunks">
                           <div class="flex justify-between">
                               <div v-for="section in sectionSet">
                                   <div class="text-lg font-bold mb-4">{{ section.name }}</div>

                                   <div class="mb-4">{{ section.description }}</div>

                                   <div><Link :href="section.url"><PrimaryButton>Manage {{ section.name }}</PrimaryButton></Link></div>
                               </div>
                           </div>
                       </div>
                   </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
