<script setup>
import { onMounted, ref } from 'vue';
import axios from 'axios';

const props = defineProps({
    rates: Array,
    relation: Array,
    exist: Array,
});

const allRelations = ref(null);




onMounted(() => {
    // getRelations(props.id);
})
</script>

<template>
    <div class="bg-white rounded-lg col-span-5 scroll-auto">
        <div id="search_result" class="p-3">
            <table class="min-w-full text-left text-sm font-light">
                <thead class="font-medium bg-green-300">
                    <tr>
                        <th scope="col" class="px-3 text-gray-800 py-3">
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
                <tbody>
                    <tr v-for="element of props.relation">
                        <td class="text-bold px-1 pt-2">
                            <p class="bold">
                                {{ element.partnumber }}
                            </p>
                        </td>
                        <td class="px-1 pt-2">
                            <table class="min-w-full text-left text-sm font-light bg-gray-200 p-2 border-2 border-gray-400">
                                <thead class="font-medium">
                                    <tr>
                                        <th v-for="rate, index in props.exist" scope="col"
                                            class="text-gray-800 text-center bg-orange-200 py-2">
                                            {{ index }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="py-3">
                                        <td class="whitespace-nowrap px-3 py-2 text-center"
                                            v-for="rate, index in props.exist">
                                            {{ rate }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                        <td class="px-1 pt-2">
                            <table class="min-w-full text-left text-sm font-light p-2 border-2 border-gray-400">
                                <thead class="font-medium">
                                    <tr>
                                        <th v-for="rate in rates" scope="col"
                                            class="text-gray-800 text-center py-2" :class="rate.status !== 'N' ? rate.status : 'bg-indigo-300'">
                                            {{ rate.amount }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="py-3">
                                        <td class="text-bold whitespace-nowrap px-3 py-2 text-center" :class="rate.status !== 'N' ? rate.status : 'bg-indigo-100'"
                                            v-for="rate in rates">

                                            {{
                                                Math.round(
                                                    Math.round((element.price * 110) / 243.5) *
                                                    rate.amount *
                                                    1.2 *
                                                    1.2 *
                                                    1.3
                                                )
                                            }}
                                        </td>
                                    </tr>
                                    <tr  v-if="element.mobis !== null && element.mobis !== '-'">
                                        <td class="text-bold whitespace-nowrap px-3 text-center py-2" :class="rate.status !== 'N' ? rate.status : 'bg-indigo-100'" v-for="rate in rates">
                                            {{
                                                Math.round(
                                                    Math.round((element.price * 110) / 243.5) *
                                                    rate.amount *
                                                    1.25 *
                                                    1.3
                                                )
                                            }}
                                        </td>
                                    </tr>
                                    <tr v-if="element.korea">
                                        <td class="text-bold whitespace-nowrap px-3 text-center" :class="rate.status !== 'N' ? rate.status : 'bg-indigo-100'" v-for="rate in selected_rates">
                                            {{
                                                Math.round((element.price * 110) / 243.5) *
                                                rate.amount *
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
