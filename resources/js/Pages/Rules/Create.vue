<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import TextInput from '@/Components/TextInput.vue';
    import SelectInput from '@/Components/SelectInput.vue';
    import { useForm } from '@inertiajs/vue3';
</script>

<script>
    export default {
        props: ['members','roles'],

        created() {

        },

        data() {
            return {
                name: 'Statewide',
                description: '',

                memberName: '',

                form: useForm({
                    subject: '0',
                    field: '0',
                    operator: '0',
                    value: '',
                    role_id: '0',
                    allow_interim: '0'
                })
            };
        },

        methods: {
            submit: function() {
                this.form.post(route('rules.store'));
            },

            assignMember: function(member) {
                this.memberName = member.name;
                this.memberModel = member;
                this.form.member = member.name;
            }
        },

        computed: {
            availableCounties: function() {
                return _.filter(this.counties, (county) => {
                    return county.territory === this.territory;
                });
            },

            availableCities: function() {
                return _.filter(this.cities, (city) => {
                    return city.county === this.county;
                });
            },

            availableMembers: function() {
                if(this.memberName === '') return [];

                return _.filter(this.members, (member) => {
                    return member.name.toLowerCase().includes(this.memberName.toLowerCase());
                });
            }
        },

        watch: {
            territory: function() {
                this.form.territory = this.territory;
            },

            memberName: function() {
            },

            county: function() {
                this.form.county = this.county;
            }
        }
    }
</script>

<template>
    <AppLayout title="Create Auth Rule">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Create Auth Rule
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="py-4 px-4 text-white bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <form @submit.prevent="submit">
                        <div class="w-1/2">
                            <div class="col-span-6 sm:col-span-4 mb-6">
                                <InputLabel for="value" value="Subject" />
                                <SelectInput
                                    id="subject"
                                    v-model="form.subject"
                                    class="mt-1 block w-full"
                                >
                                    <option value="0">Select a Subject...</option>
                                    <option>Member</option>
                                    <option>Position</option>
                                    <option>Qualification</option>
                                </SelectInput>
                                <InputError :message="form.errors.subject" class="mt-2" />
                            </div>

                            <div class="col-span-6 sm:col-span-4 mb-6">
                                <InputLabel for="value" value="Field" />
                                <SelectInput
                                    id="subject"
                                    v-model="form.field"
                                    class="mt-1 block w-full"
                                >
                                    <option value="0">Select a Field...</option>
                                    <option v-if="form.subject != 'Member'" value="name">Name</option>
                                    <option v-if="form.subject == 'Member'" value="member_name">Member Number</option>
                                    <option v-if="form.subject == 'Member'" value="account_id">Account ID</option>
                                    <option v-if="form.subject == 'Member'" value="chapter">Chapter</option>
                                    <option v-if="form.subject == 'Member'" value="territory">Territory</option>
                                    <option v-if="form.subject == 'Member'" value="county">County</option>
                                    <option v-if="form.subject == 'Member'" value="status">Status</option>
                                </SelectInput>
                                <InputError :message="form.errors.subject" class="mt-2" />
                            </div>

                            <div class="col-span-6 sm:col-span-4 mb-6">
                                <InputLabel for="value" value="Operator" />
                                <SelectInput
                                    id="operator"
                                    v-model="form.operator"
                                    class="mt-1 block w-full"
                                >
                                    <option value="0">Select an Operator...</option>
                                    <option value=">">Greater Than</option>
                                    <option value=">=">Greater Than/Equal To</option>
                                    <option value="<">Less Than</option>
                                    <option value="<=">Less Than/Equal To</option>
                                    <option value="==">Equal To</option>
                                    <option value="like">Like</option>
                                </SelectInput>
                                <InputError :message="form.errors.operator" class="mt-2" />
                            </div>


                            <div class="col-span-6 sm:col-span-4 mb-6">
                                <InputLabel for="value" value="Value" />
                                <TextInput
                                    id="value"
                                    v-model="form.value"
                                    type="text"
                                    class="mt-1 block w-full"
                                />
                                <InputError :message="form.errors.value" class="mt-2" />
                            </div>

                            <hr />

                            <div class="mt-4 mb-4 col-span-6 sm:col-span-4 mb-6">
                                <InputLabel for="role_id" value="System Role" />
                                <SelectInput
                                    id="subject"
                                    v-model="form.role_id"
                                    class="mt-1 block w-full"
                                >
                                    <option value="0">Select a System Role...</option>
                                    <option v-for="role in roles" :value="role.id">{{  role.name }}</option>>
                                </SelectInput>
                                <InputError :message="form.errors.role_id" class="mt-2" />
                            </div>

                            <div class="col-span-6 sm:col-span-4 mb-4">
                                <InputLabel for="allow_interim" value="Allow Interim Assignment" />
                                <SelectInput
                                    id="allow_interim"
                                    v-model="form.allow_interim"
                                    class="mt-1 block w-full"
                                >
                                    <option value="0">Select a Allowed Interim Assignment...</option>
                                    <option>Regional Disaster Officer</option>
                                    <option>Senior Disaster Program Manager</option>
                                    <option>Regional Mass Care & Response Specialist</option>
                                    <option>Disaster Program Manager - Territory 1</option>
                                    <option>Disaster Program Manager - Territory 2</option>
                                    <option>Disaster Program Manager - Territory 3</option>
                                    <option>Disaster Program Manager - Territory 4</option>
                                    <option>Disaster Program Manager - Territory 5</option>

                                </SelectInput>
                                <InputError :message="form.errors.allow_interim" class="mt-2" />
                            </div>


                            <PrimaryButton>Save</PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
