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
        props: ['countyChunks'],

        created() {

        },

        data() {
            return {
                form: useForm({
                    type: '1',
                    sub_type: '1',
                    counties: [],
                    description: '',
                    effective_at: '',
                    expires_at: '',
                })
            };
        },

        methods: {
            selectCounty: function(county) {
                let index = this.form.counties.indexOf(county.id);

                if(index == -1) {
                    this.form.counties.push(county.id);
                } else {
                    this.form.counties.splice(index, 1);
                }
            },
            submit: function() {
                this.form.post(route('travelbans.store'));
            },

        },

        computed: {
        },

        watch: {
        }
    }
</script>

<template>
    <AppLayout title="Create Travel Warning">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Create Travel Warning
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="py-4 px-4 text-white bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <form @submit.prevent="submit">
                        <div class="w-1/2">
                            <div class="col-span-6 sm:col-span-4 mb-6">
                                <InputLabel for="value" value="Type of Order" />
                                <SelectInput
                                    id="name"
                                    v-model="form.type"
                                    type="text"
                                    class="mt-1 block w-full"
                                >
                                    <option value="1">Travel Warning</option>
                                    <option value="2">Travel Ban</option>
                                </SelectInput>
                                <InputError :message="form.errors.value" class="mt-2" />
                            </div>

                            <div class="col-span-6 sm:col-span-4 mb-6">
                                <InputLabel for="value" value="Type of Order" />
                                <SelectInput
                                    id="name"
                                    v-model="form.sub_type"
                                    type="text"
                                    class="mt-1 block w-full"
                                >
                                    <option value="1">State-Wide</option>
                                    <option value="2">Specific Counties</option>
                                </SelectInput>
                                <InputError :message="form.errors.value" class="mt-2" />
                            </div>

                            <div v-if="form.sub_type == 2">
                                <div class="mb-4">
                                    <div class="text-lg font-bold mb-4">Counties Effected</div>
                                    <div class="flex justify-between mb-4" v-for="chunk in countyChunks">
                                        <div v-for="counties, territory in chunk">
                                            <div class="text-md font-bold mb-2">Territory {{ territory }}</div>
                                            <div class="ml-2 mb-2" v-for="county in counties"><label >{{ county.name }} <input :checked="form.counties.includes(county.id)" @input="selectCounty(county)" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 ml-2" type="checkbox"></label></div>
                                        </div></div>
                                </div>
                            </div>

                            <div class="col-span-6 sm:col-span-4 mb-6">
                                <InputLabel for="description" value="Description" />
                                <textarea v-model="form.description" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm w-full" rows="5"></textarea>
                                <InputError :message="form.errors.value" class="mt-2" />
                            </div>

                            <hr />

                            <div class="mt-6 col-span-6 sm:col-span-4 mb-6">
                                <InputLabel for="value" value="Effective At" />
                                <TextInput
                                    id="name"
                                    v-model="form.effective_at"
                                    type="datetime-local"
                                    class="mt-1 block w-full"
                                />
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
