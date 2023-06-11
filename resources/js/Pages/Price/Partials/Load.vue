<script setup>
import { onMounted, onUpdated, ref } from 'vue';
import AppLayout from "@/Layouts/AppLayout.vue";
import CodeInfo from "./CodeInfo.vue";
import RelationsDetails from "./RelationsDetails.vue";
import GivenPrice from "./GivenPrice.vue";
import Estelam from "./Estelam.vue";

const props = defineProps({
  explodedCodes: Array,
  not_exist: Array,
  existing: Array,
  customer: String,
  completeCode: String,
  rates: Array,
});

const price = ref(0);

const updatePrice = (value) => {
  price.value = value;
}

onUpdated(() => {
  console.log(price.value)
})
</script>

<template>
  <AppLayout title="Rates">
    <div class="accordion mt-12">
      <!--  Panel 1  -->
      <div v-for="code, index of explodedCodes">
        <input type="checkbox" checked="true" name="panel" :id="index" class="hidden">
        <label :for="index" class="relative flex items-center bg-gray-700 text-white p-4 shadow border-b border-grey">
          {{ code }}
        </label>
        <div class="accordion__content overflow-hidden bg-grey-lighter">
          <div v-for="item, index of existing[code]" class="grid grid-cols-1 md:grid-cols-10 gap-6 lg:gap-2 lg:p-2">
            <CodeInfo :information="existing[code][index]['information']" :partNumber="index" />
            <RelationsDetails :rates="props.rates" :relation="existing[code][index]['relation']"
              :exist="existing[code][index]['exist']" @setPrice="(value) => updatePrice(value)" />
            <GivenPrice :information="existing[code][index]['information']"
              :givenPrice="existing[code][index]['givenPrice']" :price="price" />
            <!--  <Estelam /> -->
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<style scoped>
label:after {
  content: '+';
  position: absolute;
  right: 1em;
  color: #fff;
}

input:checked+label:after {
  content: '-';
  line-height: .8em;
}

.accordion__content {
  max-height: 0em;
  transition: all 0.4s cubic-bezier(0.865, 0.14, 0.095, 0.87);
}

input[name='panel']:checked~.accordion__content {
  /* Get this as close to what height you expect */
  max-height: 150000em;
}
</style>
