<script setup>
import { onMounted, ref } from 'vue';
import axios from 'axios';

const props = defineProps({
    rates: Array,
    relation: Array,
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
                            شماره فنی
                        </th>
                        <th scope="col" class="px-3 text-gray-800 py-3">
                            مقدار موجودی
                        </th>
                        <th scope="col" class="px-3 text-gray-800 py-3">
                            قیمت به اساس نرخ ارز
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="element, key of props.relation.sorted">
                        <td class="text-bold px-1 pt-2">
                            <p class="bold">
                                {{ props.relation.goods[key].partnumber }}
                            </p>
                        </td>
                        <td class="px-1 pt-2">
                            <table class="min-w-full text-left text-sm font-light p-2 border-2 border-gray-400">
                                <thead class="font-medium">
                                    <tr>
                                        <th v-for="goodAmount, index in  props.relation.existing[key]" scope="col"
                                            :class="index == 'GEN' || index == 'MOB' ? index : 'brand-default'"
                                            class="text-white text-center py-2">
                                            {{ index }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="py-3">
                                        <td :class="index == 'GEN' || index == 'MOB' ? index : 'brand-default'"
                                            class="whitespace-nowrap text-white px-3 py-2 text-center"
                                            v-for="goodAmount, index in  props.relation.existing[key]">
                                            {{ goodAmount }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                        <td class="px-1 pt-2">
                            <table class="min-w-full text-left text-sm font-light p-2 border-2 border-gray-400">
                                <thead class="font-medium">
                                    <tr>
                                        <th v-for="rate in rates" scope="col" class="text-gray-800 text-center py-2"
                                            :class="rate.status !== 'N' ? rate.status : 'bg-indigo-300'">
                                            {{ rate.amount }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="py-3">
                                        <td class="text-bold whitespace-nowrap px-3 py-2 text-center"
                                            :class="rate.status !== 'N' ? rate.status : 'bg-indigo-100'"
                                            v-for="rate in rates">

                                            {{
                                                Math.round(
                                                    Math.round((props.relation.goods[key].price * 110) / 243.5) *
                                                    rate.amount *
                                                    1.2 *
                                                    1.2 *
                                                    1.3
                                                )
                                            }}
                                        </td>
                                    </tr>
                                    <tr class="bg-neutral-500"
                                        v-if="props.relation.goods[key].mobis !== null && props.relation.goods[key].mobis !== '-'">
                                        <td class="text-bold whitespace-nowrap px-3 text-center py-2 "
                                            v-for="rate in rates">
                                            {{
                                                Math.round(
                                                    Math.round((props.relation.goods[key].price * 110) / 243.5) *
                                                    rate.amount *
                                                    1.25 *
                                                    1.3
                                                )
                                            }}
                                        </td>
                                    </tr>
                                    <tr v-if="props.relation.goods[key].korea">
                                        <td class="text-bold whitespace-nowrap px-3 text-center"
                                            v-for="rate in selected_rates">
                                            {{
                                                Math.round((props.relation.goods[key].price * 110) / 243.5) *
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
