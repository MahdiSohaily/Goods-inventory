<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { useForm } from "@inertiajs/vue3";
import ActionMessage from "@/Components/ActionMessage.vue";
import FormRelation from "@/Components/FormRelation.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";

const props = defineProps({
  allCodeData: Array,
  customer: String,
  completeCode: String,
});

const selected_rates = [50, 51, 52, 55];

const form = useForm({
  _method: "POST",
  customer: props.customer,
  partnumber: null,
  price: null,
  code: props.completeCode,
});

const changeVal = (value) => {
  const validated = value.replace(/\D+/g, "");
  form.price = validated;
};

const savePrice = (pattern) => {
  form.partnumber = pattern;
  form.post(route("price.store"), {
    errorBag: "savePrice",
    preserveScroll: true,
    onSuccess: () => { },
  });
};
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
    <div v-for="item in allCodeData">
      <div v-if="null != item.result" class="grid grid-cols-1 md:grid-cols-10 gap-6 lg:gap-2 lg:p-2">
        <div class="bg-white rounded-lg">
          <div id="search_result" class="p-3">
            <p class="text-center bg-gray-600 text-white p-2 my-3 rounded-md">
              {{ item.search }}
            </p>
            <p class="text-center my-2">{{ item.result.name }}</p>
            <ul>
              <li class="text-center" v-for="elem in item.result.cars">
                {{ elem.name }}
              </li>
            </ul>
          </div>
        </div>
        <div class="bg-white rounded-lg col-span-5 scroll-auto">
          <div id="search_result" class="p-3">
            <table class="min-w-full text-left text-sm font-light">
              <thead class="font-medium bg-green-300">
                <tr>
                  <th scope="col" class="px-3 text-center text-gray-800 py-3">
                    Part Number
                  </th>
                  <th scope="col" class="px-3 text-center text-gray-800 py-3">
                    Goods Amount
                  </th>
                  <th scope="col" class="px-3 text-center text-gray-800 py-3">
                    Price
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="relation in item.result.relations">
                  <td class="px-1 pt-2">
                    <p class="bold">
                      {{ relation.partnumber }}
                    </p>
                  </td>
                  <td class="px-1 pt-2">
                    <table class="min-w-full text-left text-sm font-light bg-gray-200 p-2 border-2 border-gray-400">
                      <thead class="font-medium">
                        <tr>
                          <th v-for="rate, index in item.result.existing[relation.id]" scope="col"
                            class="text-gray-800 text-center bg-orange-200 py-2">
                            {{ index }}
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr class="bg-violet-200 py-3">
                          <td class="whitespace-nowrap px-3 py-2 text-center"
                            v-for="rate, index in item.result.existing[relation.id]">
                            {{ rate }}
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </td>
                  <td class="px-1 pt-2">
                    <table class="min-w-full text-left text-sm font-light bg-gray-200 p-2 border-2 border-gray-400">
                      <thead class="font-medium">
                        <tr>
                          <th v-for="rate in selected_rates" scope="col"
                            class="text-gray-800 text-center bg-orange-200 py-2">
                            {{ rate }}
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr class="bg-violet-200 py-3">
                          <td class="whitespace-nowrap px-3 py-2 text-center" v-for="rate in selected_rates">
                            {{
                              Number(
                                Math.round((relation.price * 110) / 243.5) *
                                rate *
                                1.2 *
                                1.2 *
                                1.3
                              ).toFixed(1)
                            }}
                          </td>
                        </tr>
                        <tr class="bg-indigo-200" v-if="
                          relation.mobis !== null && relation.mobis !== '-'
                        ">
                          <td class="whitespace-nowrap px-3 text-center py-2" v-for="rate in selected_rates">
                            {{
                              Number(
                                Math.round((relation.price * 110) / 243.5) *
                                rate *
                                1.25 *
                                1.3
                              ).toFixed(1)
                            }}
                          </td>
                        </tr>
                        <tr v-if="relation.korea">
                          <td class="whitespace-nowrap px-3 text-center" v-for="rate in selected_rates">
                            {{
                              Math.round((relation.price * 110) / 243.5) *
                              rate *
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
        <div class="bg-white rounded-lg shadow-md col-span-2">
          <div id="search_result" class="p-3">
            <table class="min-w-full text-left text-sm font-light">
              <thead>
                <tr>
                  <th>
                    <span class="px-4 text-gray-600">part NA</span>
                    <span class="px-4 text-gray-600">Price</span>
                    <span class="px-4 text-gray-600">Client</span>
                  </th>
                </tr>
              </thead>
              <tbody>
                <div class="min-w-full mb-1 border-2 border-gray-400" v-if="item.result.ordered_price">
                  <div class="min-w-full bg-red-400">
                    <td scope="col" class="px-3 text-white py-2 break-words">
                     Ordered Price
                    </td>
                    <td colspan="2" scope="col" class="px-3 text-white py-2 break-words">
                      {{ item.result.ordered_price.price }}
                    </td>
                  </div>
                </div>
                <div class="min-w-full mb-1 border-2 border-gray-400" v-for="price in item.result.prices">
                  <div class="min-w-full bg-indigo-100">
                    <td scope="col" class="px-3 text-gray-800 py-1 break-words">
                      {{ price.partnumber }}
                    </td>
                    <td scope="col" class="px-3 text-gray-800 py-1 break-words">
                      {{ price.price }}
                    </td>
                    <td scope="col" class="px-3 text-gray-800 py-1">
                      {{ price.name }}
                    </td>
                  </div>
                  <div class="min-w-full bg-orange-100 py-1">
                    <td colspan="3" scope="col" class="px-3 text-gray-800">
                      {{ arrangeTime(price.created_at) }}
                    </td>
                  </div>
                </div>
              </tbody>
            </table>
            <FormRelation @submitted="savePrice(item.result.pattern)">
              <template #form>
                <!-- Name -->
                <div class="pb-2">
                  <InputLabel for="price" value="Price" />
                  <TextInput id="price" @keyup="
                    (e) => {
                      changeVal(e.target.value);
                    }
                  " type="text" class="mt-1 block w-full" autocomplete="price" />
                  <InputError :message="form.errors.price" class="mt-2" />
                </div>
              </template>

              <template #actions>
                <ActionMessage :on="form.recentlySuccessful" class="mr-3">
                  Saved.
                </ActionMessage>

                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                  Save
                </PrimaryButton>
              </template>
            </FormRelation>
          </div>
        </div>
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
