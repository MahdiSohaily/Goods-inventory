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
    allCodeData: Array,
    customer: String,
});

const selected_rates = [50, 51, 52, 55];

const form = useForm({
    _method: "POST",
    form_id: null,
    customer: props.customer,
    partnumber: null,
    price: null,
});

const savePrice = () => {
    form.post(route("price.store"), {
        errorBag: "savePrice",
        preserveScroll: true,
        onSuccess: () => clearInput(),
    });
};
</script>

<template>
    <AppLayout title="Rates">
        <div
            class="h-70S grid grid-cols-1 md:grid-cols-10 gap-6 lg:gap-2 lg:p-2"
        >
            <div class="bg-white rounded-lg">
                <div class="flex items-center justify-between">
                    <h2
                        class="text-xl font-semibold bg-violet-600 w-full rounded-t-md p-3 text-center text-white"
                    >
                        Part Number
                    </h2>
                </div>
                <div id="search_result" class="p-3">
                    <p class="text-center">{{ code }}</p>
                    <p class="text-center">{{ pattern.name }}</p>
                    <ul>
                        <li class="text-center" v-for="item in cars">
                            {{ item.name }}
                        </li>
                    </ul>
                </div>
            </div>
            <div class="bg-white rounded-lg col-span-5">
                <div class="flex items-center justify-between">
                    <h2
                        class="text-xl font-semibold bg-violet-600 w-full rounded-t-md p-3 text-center text-white"
                    >
                        Related Parts
                    </h2>
                </div>
                <SectionBorder />
                <div id="search_result" class="p-3">
                    <table class="min-w-full text-left text-sm font-light">
                        <thead class="font-medium bg-green-600">
                            <tr>
                                <th
                                    scope="col"
                                    class="px-3 text-gray-800 py-3 break-words w-36"
                                >
                                    Part Number
                                </th>
                                <th scope="col" class="px-3 text-gray-800 py-3">
                                    Goods Amount
                                </th>
                                <th scope="col" class="px-3 text-gray-800 py-3">
                                    Price
                                </th>
                            </tr>
                        </thead>
                        <tbody id="results">
                            <tr
                                class="bg-gray-300 border-2 border-b-gray-500"
                                v-for="relation in relations"
                            >
                                <td class="px-3">
                                    {{ relation.partnumber }}
                                </td>
                                <td>
                                    {{ relation.mobis }}
                                </td>
                                <td class="px-2 py-3">
                                    <table
                                        class="text-left text-sm font-light bg-gray-200 p-2 border-2 border-gray-700"
                                    >
                                        <thead class="font-medium">
                                            <tr>
                                                <th
                                                    v-for="rate in selected_rates"
                                                    scope="col"
                                                    class="text-gray-800 text-center bg-orange-200 py-2"
                                                >
                                                    {{ rate }}
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="results">
                                            <tr class="bg-violet-200 py-3">
                                                <td
                                                    class="whitespace-nowrap px-3 py-2 text-center"
                                                    v-for="rate in selected_rates"
                                                >
                                                    {{
                                                        Number(
                                                            Math.round(
                                                                (relation.price *
                                                                    110) /
                                                                    243.5
                                                            ) *
                                                                rate *
                                                                1.2 *
                                                                1.2 *
                                                                1.3
                                                        ).toFixed(1)
                                                    }}
                                                </td>
                                            </tr>
                                            <tr
                                                class="bg-indigo-200"
                                                v-if="
                                                    relation.mobis !== null &&
                                                    relation.mobis !== '-'
                                                "
                                            >
                                                <td
                                                    class="whitespace-nowrap px-3 text-center py-2"
                                                    v-for="rate in selected_rates"
                                                >
                                                    {{
                                                        Number(
                                                            Math.round(
                                                                (relation.price *
                                                                    110) /
                                                                    243.5
                                                            ) *
                                                                rate *
                                                                1.25 *
                                                                1.3
                                                        ).toFixed(1)
                                                    }}
                                                </td>
                                            </tr>
                                            <tr v-if="relation.korea">
                                                <td
                                                    class="whitespace-nowrap px-3 text-center"
                                                    v-for="rate in selected_rates"
                                                >
                                                    {{
                                                        Math.round(
                                                            (relation.price *
                                                                110) /
                                                                243.5
                                                        ) *
                                                        rate *
                                                        1.25 *
                                                        1.3
                                                    }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="rounded-lg bg-white shadow-md col-span-2">
                <div class="flex items-center justify-between">
                    <h2
                        class="text-xl font-semibold bg-violet-600 w-full rounded-t-md p-3 text-center text-white"
                    >
                        Given Prices
                    </h2>
                </div>
                <div id="search_result" class="p-3">
                    <table class="min-w-full text-left text-sm font-light">
                        <thead class="font-medium bg-green-600">
                            <tr>
                                <th scope="col" class="px-3 text-gray-800 py-3">
                                    Part Number
                                </th>
                                <th scope="col" class="px-3 text-gray-800 py-3">
                                    Price
                                </th>
                                <th scope="col" class="px-3 text-gray-800 py-3">
                                    client
                                </th>
                                <th scope="col" class="px-3 text-gray-800 py-3">
                                    date
                                </th>
                            </tr>
                        </thead>
                        <tbody id="results">
                            <tr class="bg-gray-200" v-for="price in prices">
                                <td
                                    scope="col"
                                    class="px-3 text-gray-800 py-3 break-words"
                                >
                                    {{ price.partnumber }}
                                </td>
                                <td
                                    scope="col"
                                    class="px-3 text-gray-800 py-3 break-words"
                                >
                                    {{ price.price }}
                                </td>
                                <td scope="col" class="px-3 text-gray-800 py-3">
                                    {{ price.name }}
                                </td>
                                <td scope="col" class="px-3 text-gray-800 py-3">
                                    {{ price.created_at }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <FormRelation @submitted="savePrice">
                        <template #form>
                            <!-- Name -->
                            <div class="pb-2">
                                <InputLabel for="price" value="Price" />
                                <TextInput
                                    id="price"
                                    v-model="form.price"
                                    type="text"
                                    class="mt-1 block w-full"
                                    autocomplete="price"
                                />
                                <InputError
                                    :message="form.errors.price"
                                    class="mt-2"
                                />
                            </div>
                        </template>

                        <template #actions>
                            <ActionMessage
                                :on="form.recentlySuccessful"
                                class="mr-3"
                            >
                                Saved.
                            </ActionMessage>

                            <PrimaryButton
                                :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing"
                            >
                                Save
                            </PrimaryButton>
                        </template>
                    </FormRelation>
                </div>
            </div>
            <div class="rounded-lg bg-white shadow-md col-span-2">
                <div class="flex items-center justify-between">
                    <h2
                        class="text-xl font-semibold bg-violet-600 w-full rounded-t-md p-3 text-center text-white"
                    >
                        Received Prices
                    </h2>
                </div>
                <SectionBorder />
                <div class="p-3">
                    <table class="min-w-full text-left text-sm font-light">
                        <thead class="font-medium bg-green-600">
                            <tr>
                                <th scope="col" class="px-3 text-gray-800 py-3">
                                    Part Number
                                </th>
                                <th scope="col" class="px-3 text-gray-800 py-3">
                                    Price
                                </th>
                                <th scope="col" class="px-3 text-gray-800 py-3">
                                    client
                                </th>
                                <th scope="col" class="px-3 text-gray-800 py-3">
                                    date
                                </th>
                            </tr>
                        </thead>
                        <tbody id="results">
                            <tr class="bg-gray-200" v-for="price in prices">
                                <td
                                    scope="col"
                                    class="px-3 text-gray-800 py-3 break-words"
                                >
                                    {{ price.partnumber }}
                                </td>
                                <td
                                    scope="col"
                                    class="px-3 text-gray-800 py-3 break-words"
                                >
                                    {{ price.price }}
                                </td>
                                <td scope="col" class="px-3 text-gray-800 py-3">
                                    {{ price.name }}
                                </td>
                                <td scope="col" class="px-3 text-gray-800 py-3">
                                    {{ price.created_at }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
