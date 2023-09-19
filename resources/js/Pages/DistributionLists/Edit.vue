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
    props: ['reports','list'],

    created() {

    },

    data() {
        return {
            form: useForm({
                access: this.list.access,
                type: this.list.type,
                frequency: this.list.frequency,
                time: this.list.time,
                date: this.list.date,
                include_primary: this.list.include_primary,
                include_backup: this.list.include_backup,
                include_supervisor: this.list.include_supervisor,
                day: this.list.day,
                report_id: this.list.report_id
            })
        };
    },

    methods: {
        submit: function() {
            this.form.patch(route('distributionlists.update', this.list));
        },

    },

    computed: {
    },

    watch: {
    }
}
</script>

<template>
    <AppLayout title="Edit Distribution List">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Edit Distribution List
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="py-4 px-4 text-white bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <form @submit.prevent="submit">
                        <div class="w-1/2">

                            <div class="col-span-6 sm:col-span-4 mb-6">
                                <InputLabel for="value" value="Access Type" />
                                <SelectInput
                                    id="name"
                                    v-model="form.access"
                                    type="text"
                                    class="mt-1 block w-full"
                                >
                                    <option value="1">All Members can Sign Up</option>
                                    <option value="2">Administrator must Assign</option>
                                </SelectInput>
                                <InputError :message="form.errors.value" class="mt-2" />
                            </div>

                            <div class="col-span-6 sm:col-span-4 mb-6">
                                <InputLabel for="value" value="Trigger Type" />
                                <SelectInput
                                    id="name"
                                    v-model="form.type"
                                    type="text"
                                    class="mt-1 block w-full"
                                >
                                    <option value="1">Time Based</option>
                                    <option value="2">Event Based</option>
                                </SelectInput>
                                <InputError :message="form.errors.value" class="mt-2" />
                            </div>

                            <div v-if="form.type == 1" class="col-span-6 sm:col-span-4 mb-6">
                                <InputLabel for="value" value="How often should it send?" />
                                <SelectInput
                                    id="name"
                                    v-model="form.frequency"
                                    type="text"
                                    class="mt-1 block w-full"
                                >
                                    <option value="1">Daily</option>
                                    <option value="2">Weekly</option>
                                    <option value="3">Monthly</option>
                                </SelectInput>
                                <InputError :message="form.errors.value" class="mt-2" />
                            </div>

                            <div v-if="form.frequency == 3" class="col-span-6 sm:col-span-4 mb-6">
                                <InputLabel for="value" value="Date" />
                                <TextInput
                                    id="name"
                                    v-model="form.date"
                                    type="text"
                                    class="mt-1 block w-full"
                                />
                                <InputError :message="form.errors.value" class="mt-2" />
                            </div>

                            <div v-if="form.frequency == 2" class="col-span-6 sm:col-span-4 mb-6">
                                <InputLabel for="value" value="What day should the Report send?" />
                                <SelectInput
                                    id="name"
                                    v-model="form.day"
                                    type="text"
                                    class="mt-1 block w-full"
                                >
                                    <option value="1">Monday</option>
                                    <option value="2">Tuesday</option>
                                    <option value="3">Wednesday</option>
                                    <option value="4">Thursday</option>
                                    <option value="5">Friday</option>
                                    <option value="6">Saturday</option>
                                    <option value="7">Sunday</option>
                                </SelectInput>
                                <InputError :message="form.errors.value" class="mt-2" />
                            </div>

                            <div v-if="form.type == 1" class="col-span-6 sm:col-span-4 mb-6">
                                <InputLabel for="value" value="What time should the Report send?" />
                                <SelectInput
                                    id="name"
                                    v-model="form.time"
                                    type="text"
                                    class="mt-1 block w-full"
                                >
                                    <option value="0">12 AM</option>
                                    <option value="1">1 AM</option>
                                    <option value="2">2 AM</option>
                                    <option value="3">3 AM</option>
                                    <option value="4">4 AM</option>
                                    <option value="5">5 AM</option>
                                    <option value="6">6 AM</option>
                                    <option value="7">7 AM</option>
                                    <option value="8">8 AM</option>
                                    <option value="9">9 AM</option>
                                    <option value="10">10 AM</option>
                                    <option value="11">11 AM</option>
                                    <option value="12">12 PM</option>
                                    <option value="13">1 PM</option>
                                    <option value="14">2 PM</option>
                                    <option value="15">3 PM</option>
                                    <option value="16">4 PM</option>
                                    <option value="17">5 PM</option>
                                    <option value="18">6 PM</option>
                                    <option value="19">7 PM</option>
                                    <option value="20">8 PM</option>
                                    <option value="21">9 PM</option>
                                    <option value="22">10 PM</option>
                                    <option value="23">11 PM</option>
                                </SelectInput>
                                <InputError :message="form.errors.value" class="mt-2" />
                            </div>

                            <div class="col-span-6 sm:col-span-4 mb-6">
                                <InputLabel for="value" value="How often should it send?" />
                                <SelectInput
                                    id="name"
                                    v-model="form.report_id"
                                    type="text"
                                    class="mt-1 block w-full"
                                >
                                    <option value="0">Select a Report....</option>
                                    <option v-for="report in reports" :value="report.id">{{  report.name }}</option>
                                </SelectInput>
                                <InputError :message="form.errors.value" class="mt-2" />
                            </div>

                            <div class="mb-2"><label >Include Primary DO <input :checked="form.include_primary == true" @input="form.include_primary = ! form.include_primary" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 ml-2" type="checkbox"></label></div>
                            <div class="mb-2"><label >Include Backup DO <input :checked="form.include_backup == true" @input="form.include_backup = ! form.include_backup" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 ml-2" type="checkbox"></label></div>
                            <div class="mb-2"><label >Include Supervisor<input :checked="form.include_supervisor == true"  @input="form.include_supervisor = ! form.include_supervisor" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 ml-2" type="checkbox"></label></div>


                            <PrimaryButton>Save</PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
