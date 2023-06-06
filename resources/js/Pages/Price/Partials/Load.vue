<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import CodeInfo from "./CodeInfo.vue";
import RelationsDetails from "./RelationsDetails.vue";
import GivenPrice from "./GivenPrice.vue";
import Estelam from "./Estelam.vue";

const props = defineProps({
  allCodeData: Array,
  customer: String,
  completeCode: String,
});




</script>

<template>
  <AppLayout title="Rates">
    {{ sortable }}
    <div v-for="item in allCodeData">
      <div v-if="null != item.result" class="grid grid-cols-1 md:grid-cols-10 gap-6 lg:gap-2 lg:p-2">
        <CodeInfo />
        <RelationsDetails />
        <GivenPrice />
        <Estelam />
      </div>
     
    </div>
  </AppLayout>
</template>
