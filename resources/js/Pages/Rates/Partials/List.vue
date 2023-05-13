<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { useForm } from "@inertiajs/vue3";
import ActionMessage from "@/Components/ActionMessage.vue";
import FormSection from "@/Components/FormSection.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";

const updateGood = () => {
    form.post(route("goods.update", props.good.id), {
        errorBag: "updateGood",
        preserveScroll: true,
        // onSuccess: () => clearInput(),
    });
};
</script>

<template>
    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">list</div>
</template>
