<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";

defineProps({
    goods: Object,
});
</script>

<template>
    <AppLayout title="Goods">
        <div>
            <div class="p-6 lg:p-8 flex justify-center">
                <input type="text" name="serial" id="serial" class="rounded-md py-3 text-center w-96 border-2 bg-gray-100"
                    min="0" max="30" @keyup="search($event.target.value, rates)"
                    placeholder="... کد فنی قطعه را وارد کنید" />
            </div>
            <div class="bg-gray-100 bg-opacity-25">
                <div class="max-w-7xl overflow-x-auto mx-auto">
                    <table class="min-w-full text-left text-sm font-light">
                        <thead class="font-medium dark:border-neutral-500">
                            <tr class="bg-green-700">
                                <th scope="col" class="px-3 py-3 bg-black text-white w-52 text-center">
                                    شماره فنی
                                </th>
                                <th scope="col" class="px-3 py-3 text-white w-20">
                                    قیمت
                                </th>
                                <th scope="col" class="px-3 py-3 text-white">
                                    وزن
                                </th>
                                <th scope="col" class="px-3 py-3 text-white">
                                    موبیز
                                </th>
                                <th scope="col" class="px-3 py-3 text-white">
                                    عملیات
                                </th>
                            </tr>
                        </thead>
                        <tbody id="results">
                            <tr v-if="goods.length > 0" v-for="item in goods"
                                class="transition duration-300 ease-in-out bg-neutral-300">
                                <td class="whitespace-nowrap px-3 py-3 text-center">
                                    {{ item.partNumber }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-3 text-center">
                                    {{ item.price }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-3 text-center font-bold">
                                    {{ (item.weight).tofixed(1) }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-3 text-center">
                                    {{ item.mobis }}
                                </td>
                                <td class="whitespace-nowrap w-24">
                                    <div class="flex justify-center gap-1 items-center px-2">
                                        <a target="_blank" :href="
                                            'https://www.google.com/search?tbm=isch&q=' +
                                            item.partNumber
                                        ">
                                            <img class="w-5 h-auto" src="/img/google.png" alt="google" />
                                        </a>
                                        <a msg="partNumber">
                                            <img class="w-5 h-auto" src="/img/tel.png" alt="part" />
                                        </a>
                                        <a target="_blank" :href="
                                            'https://www.google.com/search?tbm=isch&q=' +
                                            item.partNumber
                                        ">
                                            <img class="w-5 h-auto" src="/img/part.png" alt="part" />
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <tr v-else class="transition duration-300 ease-in-out bg-neutral-200">
                                <td colspan="14" class="whitespace-nowrap px-3 py-3 text-center text-red-500 font-bold">
                                    <i class="material-icons text-red-500">mood_bad</i>
                                    <br />
                                    !این قطعه فاقد موبیز می باشد
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
