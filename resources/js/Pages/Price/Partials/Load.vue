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
    customer: props.customer,
    partnumber: null,
    price: null,
});

const savePrice = (pattern) => {
    form.partnumber = pattern;
    form.post(route("price.store"), {
        errorBag: "savePrice",
        preserveScroll: true,
        onSuccess: () => {
            alert("price added");
        },
    });
};
</script>

<template>
    <AppLayout title="Rates">
        <div v-for="item in allCodeData">
            <div
                v-if="null != item.result"
                class="grid grid-cols-1 md:grid-cols-10 gap-6 lg:gap-2 lg:p-2"
            >
                <div class="bg-white rounded-lg">
                    <div id="search_result" class="p-3">
                        <p
                            class="text-center bg-gray-600 text-white p-2 my-3 rounded-md"
                        >
                            {{ item.search }}
                        </p>
                        <p class="text-center my-2">{{ item.result.name }}</p>
                        <ul>
                            <li
                                class="text-center"
                                v-for="elem in item.result.cars"
                            >
                                {{ elem.name }}
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="bg-white rounded-lg col-span-5">
                    <div id="search_result" class="p-3">
                        <table class="min-w-full text-left text-sm font-light">
                            <thead class="font-medium bg-green-300">
                                <tr>
                                    <th
                                        scope="col"
                                        class="px-3 text-center text-gray-800 py-3"
                                    >
                                        Part Number
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-3 text-center text-gray-800 py-3"
                                    >
                                        Goods Amount
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-3 text-center text-gray-800 py-3"
                                    >
                                        Price
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="results">
                                <tr v-for="relation in item.result.relations">
                                    <td class="px-1 pt-2">
                                        <p class="bold">
                                            {{ relation.partnumber }}
                                        </p>
                                    </td>
                                    <td class="px-1 pt-2">
                                        <table
                                            class="min-w-full text-left text-sm font-light bg-gray-200 p-2 border-2 border-gray-400"
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
                                                        relation.mobis !==
                                                            null &&
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
                                    <td class="px-1 pt-2">
                                        <table
                                            class="min-w-full text-left text-sm font-light bg-gray-200 p-2 border-2 border-gray-400"
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
                                                        relation.mobis !==
                                                            null &&
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
                <div class="bg-white shadow-md col-span-2">
                    <div id="search_result" class="p-3">
                        <table class="min-w-full text-left text-sm font-light">
                            <thead class="font-medium bg-green-600">
                                <tr>
                                    <th
                                        scope="col"
                                        class="px-3 text-gray-800 py-3"
                                    >
                                        Part Number
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-3 text-gray-800 py-3"
                                    >
                                        Price
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-3 text-gray-800 py-3"
                                    >
                                        client
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-3 text-gray-800 py-3"
                                    >
                                        date
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="results">
                                <tr
                                    class="bg-gray-200"
                                    v-for="price in item.result.prices"
                                >
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
                                    <td
                                        scope="col"
                                        class="px-3 text-gray-800 py-3"
                                    >
                                        {{ price.name }}
                                    </td>
                                    <td
                                        scope="col"
                                        class="px-3 text-gray-800 py-3"
                                    >
                                        {{ price.created_at }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <FormRelation
                            @submitted="savePrice(item.result.pattern)"
                        >
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
                <div class="bg-white shadow-md col-span-2">
                    <div class="p-3">
                        <table class="min-w-full text-left text-sm font-light">
                            <thead class="font-medium bg-green-600">
                                <tr>
                                    <th
                                        scope="col"
                                        class="px-3 text-gray-800 py-3"
                                    >
                                        Part Number
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-3 text-gray-800 py-3"
                                    >
                                        Price
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-3 text-gray-800 py-3"
                                    >
                                        client
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-3 text-gray-800 py-3"
                                    >
                                        date
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="results">
                                <tr
                                    class="bg-gray-200"
                                    v-for="price in item.result.prices"
                                >
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
                                    <td
                                        scope="col"
                                        class="px-3 text-gray-800 py-3"
                                    >
                                        {{ price.name }}
                                    </td>
                                    <td
                                        scope="col"
                                        class="px-3 text-gray-800 py-3"
                                    >
                                        {{ price.created_at }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div v-else class="bg-white rounded-lg lg:p-2">
                <p>No result for {{ item.search }}</p>
            </div>
        </div>
    </AppLayout>
</template>
