<script setup>
import { ref } from 'vue';
import { Link, router, useForm } from '@inertiajs/vue3';
import ActionMessage from '@/Components/ActionMessage.vue';
import FormSection from '@/Components/FullFormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
const props = defineProps({
    user: Object,
});

const verificationLinkSent = ref(null);
const photoPreview = ref(null);
const photoInput = ref(null);

</script>

<script>
    export default {
        created() {
            axios.get("/utils/distrolists")
                .then((response) => {
                    this.lists = response.data;
                });
        },

        data (){
            return {
                lists: '',

                form: useForm({
                    lists: []
                })
            };
        },

        methods: {
            submit: function () {
                this.form.post(route('distrolists.signup'), {
                    errorBag: 'updateProfileInformation',
                    preserveScroll: true,
                });
            },
            selectReport: function(report) {
                let index = this.form.lists.indexOf(report);

                if(index == -1) {
                    this.form.lists.push(report);
                } else {
                    this.form.lists.splice(index);
                }
            }
        }
    }
</script>

<template>
    <FormSection @submitted="submit">
        <template #title>
            Distribution Lists
        </template>

        <template #description>
            Manage the Distribution Lists you are subscribed to.
        </template>

        <template #form>
            <div v-for="list in lists" class="dark:text-gray-300 mb-2 w-full">
                <label>
                    <strong>{{ list.report.name }}</strong> <input @input="selectReport(list.id)" :checked="$page.props.auth.user.member.listIds.includes(list.id)" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 ml-2" type="checkbox">
                    <div class="mt-2"><em>{{list.trigger }}</em></div>
                    <div class="mt-2"><em>{{list.report.description }}</em></div>
                </label>
            </div>
        </template>

        <template #actions>
            <ActionMessage :on="form.recentlySuccessful" class="mr-3">
                Saved.
            </ActionMessage>

            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Save
            </PrimaryButton>
        </template>
    </FormSection>
</template>
