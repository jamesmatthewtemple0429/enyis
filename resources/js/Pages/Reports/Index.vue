<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import { Link } from '@inertiajs/vue3';
</script>

<script>
    export default {
        props: ['roles'],

        methods: {
            appName: function(type) {
                switch(type) {
                    case 1:
                        return "RC Respond";
                    case 2:
                        return "RC Care";
                }
            }
        }
    }
</script>

<template>
    <AppLayout title="View Report List">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                View Report List
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

    <div class="mb-4"><Link :href="route('reports.create')"><PrimaryButton>Create Report</PrimaryButton></Link></div>
<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <div class="pb-4 bg-white dark:bg-gray-900">
        <label for="table-search" class="sr-only">Search</label>
        <div class="relative mt-1">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
            </div>
            <input type="text" id="table-search" class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search for items">
        </div>
    </div>
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th width="25%" scope="col" class="px-6 py-3">
                    Name
                </th>

                <th width="40%" scope="col" class="px-6 py-3">
                    Description
                </th>

                <th width="35%" scope="col" class="px-6 py-3">
                    Actions
                </th>
            </tr>
        </thead>
        <tbody>
         <tr v-if="roles.length == 0" class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600">
            <td class ="text-center py-4 px-4" dark:text-white colspan="100%">There are no Reports yet.</td>
         </tr>
            <tr v-for="role in roles" class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ role.name }}
                </th>
                <td class="px-6 py-4">
                   {{ role.description }}
                </td>
                <td class="px-6 py-4">
                    <Link :href="route('reports.show',role)"><PrimaryButton class="mr-2">Manage</PrimaryButton></Link>
                    <a target="_blank" :href="route('reports.test',role)"><PrimaryButton class="mr-2">Test Report</PrimaryButton></a>
                    <Link method="delete" as="button" :href="route('reports.destroy',role)"><DangerButton class="mr-2">Delete</DangerButton></Link></td>
            </tr>
        </tbody>
    </table>
</div>

            </div>
        </div>
    </AppLayout>
</template>
