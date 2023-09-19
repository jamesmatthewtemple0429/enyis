<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import TextInput from '@/Components/TextInput.vue';
    import { useForm } from '@inertiajs/vue3';
    import SelectInput from "@/Components/SelectInput.vue";
    import DangerButton from "@/Components/DangerButton.vue";
    import _, { map } from 'underscore';

</script>

<script>
    export default {
        props: ['report','territories','counties','models','fields'],

        created() {

        },

        data() {
            return {
                showingNewRole: false,
                type: '1',
                field: '0',
                model: '0',

                selectedFields: [],
                territory: 0,
                county: 0,

                form: useForm({
                    name: '',
                    priority: '1',
                    type: '1',
                    model: '0',
                    territory: '0',
                    county: null,
                    value: '',
                    fields: []
                })
            };
        },

        methods: {
            submit: function() {
                this.form.post(route('reports.sections.store',this.report));
            },

            addField: function() {
                let field = _.first(_.filter(this.availableFields, (field) => {
                    return field.key === this.field;
                }));

                this.form.fields.push({
                    key: this.field,
                    display: field.display
                });
                this.selectedFields.push(field.display);
                this.field = '';
            },

            remField: function(field) {
                let found = _.first(_.filter(this.fields[this.model], (f) => {
                    return f.display === field;
                }));

                let fieldIndex = this.form.fields.indexOf(found.key);
                let selectedIndex = this.selectedFields.indexOf(found.display);

                this.form.fields.splice(fieldIndex);
                this.selectedFields.splice(selectedIndex);
            }
        },

        computed: {
            availableFields: function() {
                if(this.model != 0) {
                    if(this.form.fields.length != 0) {
                        return _.filter(this.fields[this.model], (field) => {
                            return ! this.form.fields.includes(field.key);
                        });
                    } else {
                        return this.fields[this.model];
                    }
                }

                return [];
            },

            availableCounties: function() {
                if(this.territory != 0) {
                    return _.filter(this.counties, (county) => {
                        return county.territory == this.territory;
                    });
                } else {
                    return this.counties;
                }
            }
        },

        watch: {
            type: function(value) {
                this.form.type = value;

                if(this.type == 3) {
                    this.form.model = "WeatherAlert";
                } else if (this.type == 4) {
                    this.form.model = "WeatherForecast";
                }
            },

            territory: function() {
              this.form.territory = this.territory;
            },

            model: function() {
                this.form.model = this.model;

                this.selectedFields = [];
                this.form.fields = [];
            }
        }
    }
</script>

<template>
    <AppLayout title="Create Section">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Create Section
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
                                <InputLabel for="priority" value="Priority" />
                                <TextInput
                                    id="priority"
                                    v-model="form.priority"
                                    type="number"
                                    class="mt-1 block w-full"
                                />
                                <InputError :message="form.errors.priority" class="mt-2" />
                            </div>

                            <div class="col-span-6 sm:col-span-4 mb-6">
                                <InputLabel for="value" value="Section Type" />
                                <SelectInput
                                    id="name"
                                    v-model="type"
                                    class="mt-1 block w-full"
                                >
                                    <option value="1">Text</option>
                                    <option value="2">Duty Officers</option>
                                    <option value="3">Weather Alerts</option>
                                    <option value="4">Local Weather Data</option>
                                    <option value="5">Leadership Chart</option>
                                    <option value="6">Data Table</option>
                                    <option value="7">Page Break</option>


                                </SelectInput>
                                <InputError :message="form.errors.value" class="mt-2" />
                            </div>

                            <div v-if="type == 1" class="col-span-6 sm:col-span-4 mb-6">
                                <InputLabel for="description" value="Value" />
                                <textarea v-model="form.value" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm w-full" rows="5"></textarea>
                                <InputError :message="form.errors.value" class="mt-2" />
                            </div>

                            <div v-if="type == 3 || type == 4" class="col-span-6 sm:col-span-4 mb-6">
                                <InputLabel for="description" value="Territory" />
                                <SelectInput
                                    id="name"
                                    v-model="territory"
                                    class="mt-1 block w-full"
                                >
                                    <option value="0">Select a Territory...</option>
                                    <option v-for="territory in territories" :value="territory">Territory {{ territory }}</option>

                                </SelectInput>
                                <InputError :message="form.errors.value" class="mt-2" />
                            </div>

                            <div v-if="type == 3 || type == 4" class="col-span-6 sm:col-span-4 mb-6">
                                <InputLabel for="description" value="County" />
                                <SelectInput
                                    id="name"
                                    v-model="county"
                                    class="mt-1 block w-full"
                                >
                                    <option value="0">Select a County...</option>
                                    <option v-for="territory in availableCounties" :value="territory.id">{{ territory.name }}</option>

                                </SelectInput>
                                <InputError :message="form.errors.value" class="mt-2" />
                            </div>

                            <div v-if="type == 6" class="col-span-6 sm:col-span-4 mb-6">
                                <InputLabel for="model" value="Data Model" />
                                <SelectInput
                                    id="name"
                                    v-model="model"
                                    class="mt-1 block w-full"
                                >
                                    <option value="0">Select a Data Model...</option>
                                    <option v-for="model in models" :value="model">{{ model }}</option>

                                </SelectInput>
                                <InputError :message="form.errors.value" class="mt-2" />
                            </div>

                            <div v-if="model != 0" class="font-bold text-lg mb-6">
                                Viewable Fields
                            </div>
                            <div v-if="model != 0" class="flex justify-between">
                                <div class="mr-2 col-span-12 sm:col-span-4">
                                    <InputLabel for="Field" value="Field" />
                                    <SelectInput
                                        id="name"
                                        v-model="field"
                                        class="mt-1 block w-full"
                                    >
                                        <option value="0">Select a Field...</option>
                                        <option v-for="model in availableFields" :value="model.key">{{ model.display}} ({{ model.key}})</option>

                                    </SelectInput>
                                    <InputError :message="form.errors.name" class="mt-2" />
                                </div>
                                <div class="col-span-8 sm:col-span-4">
                                    <PrimaryButton class="mt-6" @click.prevent="addField">Add</PrimaryButton>
                                </div>
                            </div>

                            <div class="mt-6" v-if="model != 0">
                                <div class="mb-6 pr-6" v-for="field in selectedFields">{{ field }} <DangerButton @click.prevent="remField(field)">X</DangerButton></div>
                            </div>

                            <PrimaryButton class="mt-10" >Save</PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
