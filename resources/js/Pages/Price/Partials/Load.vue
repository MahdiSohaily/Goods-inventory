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



const arrangeTime = (dateTime) => {
  const now = new Date();
  const create = new Date(dateTime);
  const diff = now - create;

  var msec = diff;
  var dd = Math.floor(msec / 1000 / 60 / 60 / 24);
  msec -= dd * 1000 * 60 * 60 * 24;
  var hh = Math.floor(msec / 1000 / 60 / 60);
  msec -= hh * 1000 * 60 * 60;

  var mm = Math.floor(msec / 1000 / 60);
  msec -= mm * 1000 * 60;

  var ss = Math.floor(msec / 1000);
  msec -= ss * 1000;

  let text = "";

  if (dd) {
    dd > 1 ? (text += `${dd} days and `) : (text += `${dd} day and `);
  }

  if (hh) {
    hh > 1 ? (text += `${hh} hours `) : (text += `${hh} hour `);
  }

  if (!hh && mm) {
    mm > 1 ? (text += `${mm} minutes `) : (text += `${mm} minute `);
  }

  if (!mm && !hh) {
    ss > 1 ? (text += `${ss} seconds `) : (text += `1 second `);
  }

  return `${text} ago`;
};
</script>

<template>
  <AppLayout title="Rates">
    {{ sortable }}
    <div v-for="item in allCodeData">
      <div v-if="null != item.result" class="grid grid-cols-1 md:grid-cols-10 gap-6 lg:gap-2 lg:p-2">
        <CodeInfo />
        <RelationsDelatils />
        <GivenPrice />
        <Estelam />
      </div>
     
    </div>
  </AppLayout>
</template>
