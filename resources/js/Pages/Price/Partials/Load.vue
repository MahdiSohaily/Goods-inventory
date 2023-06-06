<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import CodeInfo from "./CodeInfo.vue";
import RelationsDelatils from "./RelationsDelatils.vue";
import GivenPrice from "./GivenPrice.vue";

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
        <div class="bg-white rounded-lg shadow-md col-span-2">
          <div class="p-3">
            <table class="min-w-full text-left text-sm font-light">
              <thead class="font-medium bg-green-600">
                <tr>
                  <th scope="col" class="px-3 text-gray-800 py-3">
                    Part Number
                  </th>
                  <th scope="col" class="px-3 text-gray-800 py-3">Price</th>
                  <th scope="col" class="px-3 text-gray-800 py-3">client</th>
                  <th scope="col" class="px-3 text-gray-800 py-3">date</th>
                </tr>
              </thead>
              <tbody>
                <tr class="bg-gray-200" v-for="price in item.result.estelam">
                  <td scope="col" class="px-3 text-gray-800 py-3 break-words">
                    {{ price.codename }}
                  </td>
                  <td scope="col" class="px-3 text-gray-800 py-3 break-words">
                    {{ price.price }}
                  </td>
                  <td scope="col" class="px-3 text-gray-800 py-3">
                    {{ price.name }}
                  </td>
                  <td scope="col" class="px-3 text-gray-800 py-3">
                    {{ arrangeTime(price.time) }}
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div v-else class="w-96 my-96 mx-auto text-center h-40 bg-white rounded-lg lg:p-2 flex justify-center items-center">
        <p>No result ! {{ item.search }}</p>
      </div>
    </div>
  </AppLayout>
</template>
