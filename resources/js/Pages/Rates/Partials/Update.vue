<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { useForm } from "@inertiajs/vue3";
import ActionMessage from "@/Components/ActionMessage.vue";
import FormSection from "@/Components/FormSection.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";

const props = defineProps({
    rate: Object,
    rates: Object,
});

const form = useForm({
    _method: "PUT",
    amount: props.rate.amount,
    status: props.rate.status,
});

const updateRate = () => {
    form.post(route("rates.update",props.rate.id), {
        errorBag: "updateRate",
        preserveScroll: true,
    });
};

</script>

<template>
    <AppLayout title="Rates">
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <FormSection @submitted="updateRate">
                <template #title> Price Rate </template>

                <template #description>
                    Fill the following form to insert new rate fot hte goods
                    price.
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
                        <InputError
                            :message="form.errors.amount"
                            class="mt-2"
                        />
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
                            <option value="A" class="A">A</option>
                            <option value="B" class="B">B</option>
                            <option value="C" class="C">C</option>
                            <option value="D" class="D">D</option>
                            <option value="E" class="E">E</option>
                            <option value="F" class="F">F</option>
                            <option value="G" class="G">G</option>
                            <option value="N" class="N">N</option>
                        </select>
                        <InputError
                            :message="form.errors.status"
                            class="mt-2"
                        />
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
        </div>
    </AppLayout>
</template>
