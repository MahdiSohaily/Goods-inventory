<script setup>
import { onMounted, ref, watch } from 'vue';
import CodeInfo from "./CodeInfo.vue";
import RelationsDetails from "./RelationsDetails.vue";
import GivenPrice from "./GivenPrice.vue";
import Estelam from "./Estelam.vue";

const props = defineProps({
    existing: Array,
    code: 'String',
    index: 'String',
    information: Array,
    partNumber: String,
    relation: Array,
    exist: String,
    givenPrice: String,
    rates: Array,
});

const price = ref(null);
const updated = ref(null);
const updatePrice = (value) => {
    price.value = value;
}

watch(price, (newValue) => updated.value = newValue);

</script>
<template>
    <CodeInfo :information="existing[code][index]['information']" :partNumber="index" />
    <RelationsDetails :rates="props.rates" :relation="existing[code][index]['relation']"
        :exist="existing[code][index]['exist']" @setPrice="(value) => updatePrice(value)" />
    <GivenPrice :information="existing[code][index]['information']" :givenPrice="existing[code][index]['givenPrice']"
        :price="updated" />
    <!--  <Estelam /> -->
</template>
<style></style>