<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import SelectInput from "@/Components/SelectInput.vue";
import _, { map } from 'underscore';

</script>

<script>
export default {
    props: ['positions','section','role'],

    created() {

    },

    data() {
        return {
            query: this.role.position,
            form: useForm({
                position: this.role.position,
                priority: this.role.priority,
                allow_multiple: this.role.allow_multiple
            })
        };
    },

    methods: {
        submit: function() {
            this.form.patch(route('sections.roles.update', {section: this.section, role: this.role }));
        },

        selectMember: function(member) {
            this.form.position = member;
            this.query = member;
        }

    },

    computed: {
        searchResults: function() {
            if(this.query === '') return [];

            return _.filter(this.positions, (position) => {
                return position.toLowerCase().includes(this.query.toLowerCase());
            });
        }
    },

    watch: {
        query: function() {
            this.form.position = this.query;
        }
    }
}
</script>

<template>
    <AppLayout title="Add Leadership Role">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Add Leadership Role
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="py-4 px-4 text-white bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <form @submit.prevent="submit">
                        <div class="w-1/2">
                            <div class="col-span-6 sm:col-span-4 mb-6">
                                <InputLabel for="value" value="Priority" />
                                <TextInput
                                    id="name"
                                    v-model="form.priority"
                                    type="number"
                                    class="mt-1 block w-full"
                                />
                                <InputError :message="form.errors.value" class="mt-2" />
                            </div>

                            <div class="col-span-6 sm:col-span-4 mb-6">
                                <InputLabel for="value" value="Position" />
                                <TextInput
                                    id="name"
                                    v-model="query"
                                    type="text"
                                    class="mt-1 block w-full"
                                />
                                <InputError :message="form.errors.value" class="mt-2" />
                            </div>

                            <div v-if="searchResults.length > 0" class="mb-4" v-for="result in searchResults">
                                <PrimaryButton @click.prevent="selectMember(result)">{{ result }}</PrimaryButton>
                            </div>

                            <div class="mb-6"><label>Allow Multiple Members<input @input="form.allow_multiple = ! form.allow_multiple" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 ml-2" type="checkbox"></label>

                            </div>
                            <PrimaryButton>Save</PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
