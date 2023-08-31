<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import TextInput from '@/Components/TextInput.vue';
    import { useForm } from '@inertiajs/vue3';
    import SelectInput from "@/Components/SelectInput.vue";
</script>

<script>
    export default {
        props: [],

        created() {

        },

        data() {
            return {
                form: useForm({
                    audience: 'All Workforce',
                    message: '',
                    expires_at: ''
                })
            };
        },

        methods: {
            submit: function() {
                this.form.post(route('announcements.store'));
            },

        },

        computed: {
        },

        watch: {
        }
    }
</script>

<template>
    <AppLayout title="Create Announcement">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Create Announcement
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="py-4 px-4 text-white bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <form @submit.prevent="submit">
                        <div class="w-1/2">

                            <div class="col-span-6 sm:col-span-4 mb-6">
                                <InputLabel for="value" value="Audience" />
                                <SelectInput
                                    id="name"
                                    v-model="form.audience"
                                    type="text"
                                    class="mt-1 block w-full"
                                >
                                    <option>All Workforce</option>
                                    <option>DAT Responders</option>
                                    <option>Duty Officers</option>
                                    <option>DAT Responders</option>
                                    <option>Territory 1</option>
                                    <option>Territory 2</option>
                                    <option>Territory 3</option>
                                    <option>Territory 4</option>
                                    <option>Territory 5</option>

                                </SelectInput>
                                <InputError :message="form.errors.value" class="mt-2" />
                            </div>

                            <div class="col-span-6 sm:col-span-4 mb-6">
                                <InputLabel for="description" value="Announcement Content" />
                                <textarea v-model="form.message" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm w-full" rows="5"></textarea>
                                <InputError :message="form.errors.value" class="mt-2" />
                            </div>

                            <div class="col-span-6 sm:col-span-4 mb-6">
                                <InputLabel for="value" value="Expires At" />
                                <TextInput
                                    id="name"
                                    v-model="form.expires_at"
                                    type="datetime-local"
                                    class="mt-1 block w-full"
                                />
                                <InputError :message="form.errors.value" class="mt-2" />
                            </div>

                            <PrimaryButton>Save</PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
