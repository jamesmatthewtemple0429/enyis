<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
</script>

<script>
    import { useForm } from '@inertiajs/vue3';
export default {
    props: ['report'],

    created() {

    },

    data() {
        return {
            type: 1,

            form: useForm({
                name: this.report.name,
                description: this.report.description,
            })
        };
    },

    methods: {
        submit: function() {
            this.form.patch(route('reports.update', this.report));
        },

    },

    computed: {
    },

    watch: {
        type: function() {
            this.form.type = this.type;

            if(this.type == 3) {
                this.form.model = "WeatherAlert";
            } else if (this.type == 4) {
                this.form.model = "WeatherForecast";
            }
        }
    }
}
</script>

<template>
    <AppLayout title="Edit Report">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Edit Report
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="py-4 px-4 text-white bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <form @submit.prevent="submit">
                        <div class="w-1/2">
                            <div class="col-span-6 sm:col-span-4 mb-6">
                                <InputLabel for="Name" value="Name" />
                                <TextInput
                                    id="name"
                                    v-model="form.name"
                                    type="text"
                                    class="mt-1 block w-full"
                                />
                                <InputError :message="form.errors.name" class="mt-2" />
                            </div>


                            <div class="col-span-6 sm:col-span-4 mb-6">
                                <InputLabel for="description" value="Description" />
                                <textarea v-model="form.description" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm w-full" rows="5"></textarea>
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
