<script setup>
import { onMounted, ref } from 'vue';

const props = defineProps({
    rates: Array,
    relation: Array,
});

const stockRecords = ref(null);

const seekExist = (e) => {
    const element = e.target;
    if (element.hasAttribute("data-key")) {
        const partNumber = element.getAttribute('data-key');
        const brand = element.getAttribute('data-brand');

        const target = document.getElementById(partNumber + '-' + brand)
        target.style.display = 'block';
    }
}

const closeSeekExist = (e) => {
    const element = e.target;
    if (element.hasAttribute("data-key")) {
        const partNumber = element.getAttribute('data-key');
        const brand = element.getAttribute('data-brand');

        const target = document.getElementById(partNumber + '-' + brand)
        target.style.display = 'none';
    }

}

const calculate = (price, rate) => {
    return Math.round(
        Math.round((price * 110) / 243.5) *
        rate *
        1.25 *
        1.3
    )
}


onMounted(() => {
    stockRecords.value = props.relation.stockInfo;
})
</script>

<template>
    <div class="bg-white rounded-lg col-span-5">
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
                    <tr class="relative" v-for="element, key of props.relation.sorted">

                        <td class="text-bold px-1 pt-2">
                            <p class="bold">
                                {{ props.relation.goods[key].partnumber }}
                            </p>
                        </td>
                        <td class="px-1 pt-2">
                            <table class="min-w-full text-sm font-light p-2">
                                <thead class="font-medium">
                                    <tr>
                                        <th v-for="goodAmount, index in  props.relation.existing[key]" scope="col"
                                            :class="index == 'GEN' || index == 'MOB' ? index : 'brand-default'"
                                            class="text-white text-center py-2 relative hover:cursor-pointer"
                                            :data-key="key" :data-brand="index" @mouseover="seekExist"
                                            @mouseleave="closeSeekExist">
                                            {{ index }}
                                            <div class="custome-tooltip" :id="key + '-' + index">
                                                <div v-for="item, iterator in props.relation.stockInfo[key][index]">
                                                    <p v-if="item > 0"> {{ iterator }} : {{ item }}</p>
                                                </div>
                                            </div>
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
                            <table class="min-w-full text-left text-sm font-light">
                                <thead class="font-medium">
                                    <tr>
                                        <th v-for="rate in rates" scope="col" class="text-gray-800 text-center py-2"
                                            :class="rate.status !== 'N' ? rate.status : 'bg-green-700'">
                                            {{ rate.amount }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="py-3">
                                        <td class="text-bold whitespace-nowrap px-3 py-2 text-center"
                                            :class="rate.status !== 'N' ? rate.status : 'bg-gray-100'" v-for="rate in rates"
                                            @click="$emit('setPrice', calculate(props.relation.goods[key].price, rate.amount))">

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
                                    <tr class="bg-neutral-400"
                                        v-if="props.relation.goods[key].mobis > 0 && props.relation.goods[key].mobis !== '-'">
                                        <td class="text-bold whitespace-nowrap px-3 text-center py-2 " v-for="rate in rates"
                                            @click="$emit('setPrice', calculate(props.relation.goods[key].price, rate.amount))">
                                            {{
                                                calculate(props.relation.goods[key].price, rate.amount)
                                            }}
                                        </td>
                                    </tr>

                                    <tr class="bg-amber-600" v-if="props.relation.goods[key].korea > 0">
                                        <td class="text-bold whitespace-nowrap px-3 text-center py-2 " v-for="rate in rates"
                                            @click="$emit('setPrice', calculate(props.relation.goods[key].price, rate.amount))">
                                            {{
                                                calculate(props.relation.goods[key].price, rate.amount)

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

<style scoped>
.custome-tooltip {
    position: absolute;
    display: none;
    bottom: 100%;
    padding: 10px;
    border-radius: 5px;
    background-color: seagreen;
    width: 200px;
    z-index: 100000;
}
</style>
