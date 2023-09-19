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
        props: ['section','fields'],

        created() {

        },

        data() {
            return {
                form: useForm({
                    name: '1',
                    operator: '=',
                    is_dynamic: false,
                    value: '',
                })
            };
        },

        methods: {
            submit: function() {
                this.form.post(route('sections.filters.store', this.section));
            },

        },

        computed: {
        },

        watch: {
        }
    }
</script>

<template>
    <AppLayout title="Add Data Filter">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Add Data Filter
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="py-4 px-4 text-white bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <form @submit.prevent="submit">
                        <div class="w-1/2">

                            <div class="col-span-6 sm:col-span-4 mb-6">
                                <InputLabel for="value" value="Field" />
                                <SelectInput
                                    id="name"
                                    v-model="form.name"
                                    class="mt-1 block w-full"
                                >
                                    <option value="0">Select a Field...</option>
                                    <option v-for="field in fields" :value="field.key">{{ field.display }} ({{ field.key }}) </option>
                                </SelectInput>
                                <InputError :message="form.errors.value" class="mt-2" />
                            </div>

                            <div class="col-span-6 sm:col-span-4 mb-6">
                                <InputLabel for="value" value="Field" />
                                <SelectInput
                                    id="name"
                                    v-model="form.operator"
                                    class="mt-1 block w-full"
                                >
                                    <option value=">=">Greater than or equal to</option>                                    <option value="0">Greater than or equal to</option>
                                    <option value=">">Greater than</option>
                                    <option value="=">Equal To</option>
                                    <option value="<=">Less than or equal to </option>
                                    <option value="<">Less than</option>
                                    <option value="in">In (Comma-Seperated List)</option>
                                    <option value="date">Date</option>
                                    <option value="yesterday">Yesterday</option>

                                    <option value="null">Empty/Null</option>
                                    <option value="day">Days Ago</option>

                                    <option value="gTime">Greater than current time</option>
                                    <option value="lTime">Less than current time</option>

                                </SelectInput>
                                <InputError :message="form.errors.value" class="mt-2" />
                            </div>


                            <div v-if="form.operator !== 'gTime' && form.operator !== 'lTime'" class="mb-2">
                                <strong>This value is dynamic, and can be set by user on report generation.</strong> <input @input="form.is_dynamic = ! form.is_dynamic" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 ml-2" type="checkbox">
                            </div>


                            <div v-if="form.operator !== 'gTime' && form.operator !== 'lTime' && form.is_dynamic == false" class="col-span-6 sm:col-span-4 mb-6">
                                <InputLabel for="value" value="Value" />
                                <TextInput
                                    id="value"
                                    v-model="form.value"
                                    type="text"
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
