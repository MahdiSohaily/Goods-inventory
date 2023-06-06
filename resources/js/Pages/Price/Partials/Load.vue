<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import CodeInfo from "./CodeInfo.vue";
import RelationsDetails from "./RelationsDetails.vue";
import GivenPrice from "./GivenPrice.vue";
import Estelam from "./Estelam.vue";

// const props = defineProps({
//   allCodeData: Array,
//   customer: String,
//   completeCode: String,
// });




</script>

<template>
  <AppLayout title="Rates">
    <div>
      <div class="grid grid-cols-1 md:grid-cols-10 gap-6 lg:gap-2 lg:p-2">
        <CodeInfo :partNumber="null"  />
        <RelationsDetails />
        <GivenPrice :customer="1" :partNumber="null" :completeCode="null" />
        <Estelam />
      </div>

    </div>
  </AppLayout>
</template>
