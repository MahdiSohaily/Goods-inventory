<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { useForm } from "@inertiajs/vue3";
import ActionMessage from "@/Components/ActionMessage.vue";
import FormRelation from "@/Components/FormRelation.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";

const props = defineProps({
    code: String,
    pattern: Object,
    relations: Array,
    customer: Object,
    cars: Object,
});

const form = useForm({
    _method: "POST",
    customer: null,
    code: null,
});

const LoadPrice = () => {
    form.post(route("price.load"), {
        errorBag: "LoadPrice",
        preserveScroll: true,
        onSuccess: () => clearInput(),
    });
};
</script>

<template>
    <AppLayout title="Rates">
        <div class="h-70S grid grid-cols-1 my-8 md:grid-cols-9 gap-6 lg:gap-2 lg:p-2">
            <div class="bg-white rounded-lg shadow-md">
                <div class="flex items-center justify-between p-3">
                    <h2 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
                        {{ code }}
                    </h2>
                </div>
                <div id="search_result" class="p-3">
                    <p class="text-center">{{ pattern.name }}</p>
                    <ul>
                        <li class="text-center" v-for="item in cars">
                            {{ item.name }}
                        </li>
                    </ul>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-md col-span-4">
                <div class="flex items-center justify-between p-3">
                    <h2 class="text-xl font-semibold text-gray-800 flex items-center gap-2"></h2>
                </div>
                <SectionBorder />
                <div id="search_result" class="p-3">
                    <ul>
                        <li v-for="item in relations">{{ item }}</li>
                    </ul>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-md col-span-2">
                <div class="flex items-center justify-between p-3">
                    <h2 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
                        <i class="material-icons font-semibold text-orange-400">search</i>
                        Search Goods
                    </h2>
                </div>
                <SectionBorder />
                <div id="search_result" class="p-3">
                    <!-- Search Results are going to be appended here -->
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-md col-span-2">
                <div class="flex items-center justify-between p-3">
                    <h2 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
                        <i class="material-icons font-semibold text-orange-400">search</i>
                        Search Goods
                    </h2>
                </div>
                <SectionBorder />
                <div id="search_result" class="p-3">
                    <!-- Search Results are going to be appended here -->
                </div>
            </div>
        </div>
    </AppLayout>
</template>
