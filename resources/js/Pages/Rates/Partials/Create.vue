<script setup>
import { useForm } from "@inertiajs/vue3";
import ActionMessage from "@/Components/ActionMessage.vue";
import FormSection from "@/Components/FormSection.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";

defineProps({
    confirmsTwoFactorAuthentication: Boolean,
    sessions: Array,
});
</script>

<template>
    <AppLayout title="Profile">
        <FormSection @submitted="updateProfileInformation">
            <template #title> Price Rate </template>

            <template #description>
                Fill the following form to insert new rate fot hte goods price.
            </template>

            <template #form>
                <!-- Amount -->
                <div class="col-span-6 sm:col-span-4">
                    <InputLabel for="amount" value="Amount" />
                    <TextInput
                        id="amount"
                        v-model="form.amount"
                        type="text"
                        class="mt-1 block w-full"
                        autocomplete="amount"
                    />
                    <InputError :message="form.errors.amount" class="mt-2" />
                </div>

                <!-- status -->
                <div class="col-span-6 sm:col-span-4">
                    <InputLabel for="status" value="Status" />
                    <select
                        type="status"
                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                        autocomplete="username"
                        v-model="form.status"
                        id="status"
                    >
                        <option value="1">1</option>
                        <option value="1">1</option>
                        <option value="1">1</option>
                        <option value="1">1</option>
                    </select>
                    <InputError :message="form.errors.status" class="mt-2" />
                </div>
            </template>

            <template #actions>
                <ActionMessage :on="form.recentlySuccessful" class="mr-3">
                    Saved.
                </ActionMessage>

                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Save
                </PrimaryButton>
            </template>
        </FormSection>
    </AppLayout>
</template>
