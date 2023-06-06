<script setup>

const form = useForm({
    _method: "GET",
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

const clearInput = () => { };
</script>

<template>
    <div class="bg-white rounded-lg col-span-5 scroll-auto">
        <div id="search_result" class="p-3">
            <table class="min-w-full text-left text-sm font-light">
                <thead class="font-medium bg-green-300">
                    <tr>
                        <th scope="col" class="px-3 text-center text-gray-800 py-3">
                            Part Number
                        </th>
                        <th scope="col" class="px-3 text-center text-gray-800 py-3">
                            Goods Amount
                        </th>
                        <th scope="col" class="px-3 text-center text-gray-800 py-3">
                            Price
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="element, key in item.result.sorted">
                        <td class="px-1 pt-2">
                            <p class="bold">
                                {{ item.result.relations[key.replace('z', '')].partnumber }}
                            </p>
                        </td>
                        <td class="px-1 pt-2">
                            <table class="min-w-full text-left text-sm font-light bg-gray-200 p-2 border-2 border-gray-400">
                                <thead class="font-medium">
                                    <tr>
                                        <th v-for="rate, index in item.result.existing[item.result.relations[key.replace('z', '')].id]"
                                            scope="col" class="text-gray-800 text-center bg-orange-200 py-2">
                                            {{ index }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="bg-violet-200 py-3">
                                        <td class="whitespace-nowrap px-3 py-2 text-center"
                                            v-for="rate, index in item.result.existing[item.result.relations[key.replace('z', '')].id]">
                                            {{ rate }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                        <td class="px-1 pt-2">
                            <table class="min-w-full text-left text-sm font-light bg-gray-200 p-2 border-2 border-gray-400">
                                <thead class="font-medium">
                                    <tr>
                                        <th v-for="rate in selected_rates" scope="col"
                                            class="text-gray-800 text-center bg-orange-200 py-2">
                                            {{ rate }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="bg-violet-200 py-3">
                                        <td class="whitespace-nowrap px-3 py-2 text-center" v-for="rate in selected_rates">
                                            {{
                                                Math.round(
                                                    Math.round((item.result.relations[key.replace('z', '')].price * 110) / 243.5) *
                                                    rate *
                                                    1.2 *
                                                    1.2 *
                                                    1.3
                                                )
                                            }}
                                        </td>
                                    </tr>
                                    <tr class="bg-indigo-200" v-if="
                                        item.result.relations[key.replace('z', '')].mobis !== null && item.result.relations[key.replace('z', '')].mobis !== '-'
                                    ">
                                        <td class="whitespace-nowrap px-3 text-center py-2" v-for="rate in selected_rates">
                                            {{
                                                Math.round(
                                                    Math.round((item.result.relations[key.replace('z', '')].price * 110) / 243.5) *
                                                    rate *
                                                    1.25 *
                                                    1.3
                                                )
                                            }}
                                        </td>
                                    </tr>
                                    <tr v-if="item.result.relations[key.replace('z', '')].korea">
                                        <td class="whitespace-nowrap px-3 text-center" v-for="rate in selected_rates">
                                            {{
                                                Math.round((item.result.relations[key.replace('z', '')].price * 110) / 243.5) *
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
</template>
