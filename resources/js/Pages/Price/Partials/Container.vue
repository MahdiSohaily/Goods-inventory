<script setup>
import CodeInfo from "./CodeInfo.vue";
import RelationsDetails from "./RelationsDetails.vue";
import GivenPrice from "./GivenPrice.vue";
import Estelam from "./Estelam.vue";

const props = defineProps({
    information: Array,
    partNumber: String,
    relation: Array,
    exist: String,
  completeCode: String,
  rates: Array,
});

</script>
<template>
    <CodeInfo :information="existing[code][index]['information']" :partNumber="index" />
    <RelationsDetails :rates="props.rates" :relation="existing[code][index]['relation']"
        :exist="existing[code][index]['exist']" @setPrice="(value) => updatePrice(value)" />
    <GivenPrice :information="existing[code][index]['information']" :givenPrice="existing[code][index]['givenPrice']"
        :price="price" />
    <!--  <Estelam /> -->
</template>
<style></style>