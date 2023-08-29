<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import TextInput from '@/Components/TextInput.vue';
    import { useForm } from '@inertiajs/vue3';
</script>

<script>
    export default {
        props: ['members','permissionChunks'],

        created() {

        },

        data() {
            return {
                name: 'Statewide',
                description: '',

                memberName: '',

                form: useForm({
                    name: '',
                    description: '',
                    is_admin: false,
                    permissions: []
                })
            };
        },

        methods: {
            submit: function() {
                this.form.post(route('roles.store'));
            },

            selectPerm: function(permission) {
                let index = this.form.permissions.indexOf(permission.id);

                if(index == -1) {
                    this.form.permissions.push(permission.id);
                } else {
                    this.form.permissions.splice(index, 1);
                }
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
    <AppLayout title="Create System Role">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Create System Role
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="py-4 px-4 text-white bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <form @submit.prevent="submit">
                        <div class="w-1/2">

                            <div class="col-span-6 sm:col-span-4 mb-6">
                                <InputLabel for="value" value="Role Name" />
                                <TextInput
                                    id="name"
                                    v-model="form.name"
                                    type="text"
                                    class="mt-1 block w-full"
                                />
                                <InputError :message="form.errors.value" class="mt-2" />
                            </div>

                            <div class="col-span-6 sm:col-span-4 mb-6">
                                <InputLabel for="description" value="Description" />
                                <TextInput
                                    id="description"
                                    v-model="form.description"
                                    type="text"
                                    class="mt-1 block w-full"
                                />
                                <InputError :message="form.errors.value" class="mt-2" />
                            </div>

                            <div class="col-span-6 sm:col-span-4 mb-6">
                                <label>Role has Global Administrator Access <input @input="form.is_admin = ! form.is_admin" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 ml-2" type="checkbox"></label>
                            </div>

                            <div class="flex justify-between" v-for="permissionSets in permissionChunks">
                                <div v-for="permissions,title in permissionSets">
                                    <div class="font-bold text-lg mb-4">{{ title }}</div>

                                    <div class="mb-2" v-for="permission in permissions"><label >{{ permission.name }} <input @input="selectPerm(permission)" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 ml-2" type="checkbox"></label></div>

                                </div>
                            </div>

                            <PrimaryButton>Save</PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
