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
    props: ['members','interim', 'memberName'],

    created() {

    },

    data() {
        return {
            query: this.memberName,

            form: useForm({
                position: this.interim.position,
                account_id: this.interim.account_id,
                effective_at: this.interim.effective_at,
                expires_at: this.interim.expires_at
            })
        };
    },

    methods: {
        submit: function() {
            this.form.patch(route('interims.update', this.interim));
        },

        selectMember: function(member) {
            this.form.account_id = member.account_id;
            this.query = member.name;
        }

    },

    computed: {
        searchResults: function() {
            return _.filter(this.members, (member) => {
                return member.name.includes(this.query);
            });
        }
    },

    watch: {
    }
}
</script>

<template>
    <AppLayout title="Edit Interim Assignment">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Edit Interim Assignment
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="py-4 px-4 text-white bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <form @submit.prevent="submit">
                        <div class="w-1/2">

                            <div class="col-span-6 sm:col-span-4 mb-6">
                                <InputLabel for="value" value="Position" />
                                <SelectInput
                                    id="name"
                                    v-model="form.position"
                                    type="text"
                                    class="mt-1 block w-full"
                                >
                                    <option>Select a Position...</option>
                                    <option>Regional Disaster Officer</option>
                                    <option>Senior Disaster Program Manager</option>
                                    <option>Regional Mass Care & Response Specialist</option>
                                    <option>Disaster Program Manager - Territory 1</option>
                                    <option>Disaster Program Manager - Territory 2</option>
                                    <option>Disaster Program Manager - Territory 3</option>
                                    <option>Disaster Program Manager - Territory 4</option>
                                    <option>Disaster Program Manager - Territory 5</option>

                                </SelectInput>
                                <InputError :message="form.errors.value" class="mt-2" />
                            </div>

                            <div class="col-span-6 sm:col-span-4 mb-6">
                                <InputLabel for="value" value="Member" />
                                <TextInput
                                    id="name"
                                    v-model="query"
                                    type="text"
                                    class="mt-1 block w-full"
                                />
                                <InputError :message="form.errors.value" class="mt-2" />
                            </div>

                            <div v-if="searchResults.length < 10" class="mb-4" v-for="result in searchResults">
                                <PrimaryButton @click.prevent="selectMember(result)">{{ result.name }} - Member ID: {{ result.member_number }}</PrimaryButton>

                            </div>

                            <div class="col-span-6 sm:col-span-4 mb-6">
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
