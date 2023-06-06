<script setup>
import { router } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import axios from "axios";

const props = defineProps({
    goods: Object,
    count: Number,
});

let current_page = 0;
let pattern = null;

const removeItem = (e) => {
    const id = e.target.getAttribute('data-delete');
    if (confirm("Are you sure you want to delete this record?") == true) {
        router.delete(route("goods.delete", id));
    }
};

const remove = (id) => {

    if (confirm("Are you sure you want to delete this record?") == true) {
        router.delete(route("goods.delete", id));
    }
};

$(document).ready(() => {
    $(document).on("click", ".delete_good", removeItem);
});

const search = (value) => {
    pattern = value;
    const resultBox = document.getElementById("results");
    resultBox.innerHTML = `<tr class=''>
                <td colspan='6' class='py-10 text-center'> 
                    <img class=' block w-10 mx-auto h-auto' src='/img/loading.png' alt='google'>
                    </td>
            </tr>`;

    pattern = pattern.replace(/\s/g, "");
    pattern = pattern.replace(/-/g, "");
    pattern = pattern.replace(/_/g, "");
    axios
        .post("/goods/search", {
            pattern,
        })
        .then(function (response) {
            resultBox.setAttribute(
                "data-length",
                Math.ceil(response.data.count / 10)
            );
            resultBox.innerHTML = print(response.data.goods);
        })
        .catch(function (error) {
            console.log(error);
        });
};

const page = async (action) => {
    const results = document.getElementById("results");
    const total_pages = results.getAttribute("data-length");
    let data = null;
    switch (action) {
        case "prev":
            --current_page;
            if (current_page <= 0) {
                current_page = total_pages;
            }
            data = await getData(current_page, pattern);
            break;
        case "next":
            ++current_page;
            if (current_page > total_pages) {
                current_page = 0;
            }
            data = await getData(current_page, pattern);
            break;
    }
};

const getData = (page, pattern) => {
    const resultBox = document.getElementById("results");
    resultBox.innerHTML = `<tr class=''>
                <td colspan='6' class='py-10 text-center'> 
                    <img class=' block w-10 mx-auto h-auto' src='/img/loading.png' alt='google'>
                    </td>
            </tr>`;
    if (pattern) {
        pattern = pattern.replace(/\s/g, "");
        pattern = pattern.replace(/-/g, "");
        pattern = pattern.replace(/_/g, "");
    }
    axios
        .post("/goods/page", {
            page,
            pattern,
        })
        .then(function (response) {
            resultBox.setAttribute(
                "data-length",
                Math.ceil(response.data.count / 10)
            );
            resultBox.innerHTML = print(response.data.goods);
        })
        .catch(function (error) {
            console.log(error);
        });
};

const print = (data) => {
    let template = "";
    if (data.length > 0) {
        for (let item of data) {
            const id = item.id;
            const partNumber = item.partnumber;
            const price = item.price;
            const weight = Number(item.weight).toFixed(1);
            const mobis = item.mobis;
            const korea = item.korea;

            template +=
                `<tr class="transition duration-300 ease-in-out bg-neutral-200 hover:bg-neutral-100">
                <td class='whitespace-nowrap font-bold text-center'>` +
                partNumber +
                `</td>
                <td class='whitespace-nowrap font-bold text-center px-3 py-3'>` +
                price +
                `</td>
                <td class= 'whitespace-nowrap font-bold text-center px-3 py-3' >` +
                weight +
                `</td>
                <td class='whitespace-nowrap font-bold text-center px-3 py-3' >` +
                mobis +
                `</td>
                <td class='whitespace-nowrap font-bold text-center px-3 py-3' >` +
                korea +
                `</td>`;

            template += `
                <td class='whitespace-nowrap w-24'>
                    <div class='flex justify-center gap-1 items-center px-2'>
                        <div class="flex justify-center gap-1 items-center px-2">
                            <a target="_self" href="/goods/${id}/edit">
                                <i class="material-icons text-blue-500">create</i>
                            </a>
                            <i data-delete='${id}' class="delete_good material-icons text-red-600 cursor-pointer">delete_forever</i>
                        </div>
                </div>
                </td>
            </tr> `;
        }
        return template;
    } else {
        return `<tr v-else class="transition duration-300 ease-in-out bg-neutral-200">
                    <td colspan="6" class="whitespace-nowrap px-3 py-3 text-center font-bold text-orange-500">
                        <i class="material-icons text-red-500">mood_bad</i>
                        <br>
                                !قطعه ای برای  کد فنی وارد در سیستم پیدا نشد
                    </td>
                </tr>`;
    }
};
</script>

<template>
    <AppLayout title="Goods">
        <div>
            <div class="max-w-7xl overflow-x-auto mx-auto pt-11 pb-3 flex justify-between">
                <input type="text" name="serial" id="serial" class="rounded-md py-2 w-96 border-2 bg-gray-100" min="0"
                    max="30" @keyup="search($event.target.value, rates)" placeholder="Search base on Part Number..." />
                <a :href="route('goods.create')"
                    class="bg-indigo-500 hover:bg-indigo-400 rounded-md text-white px-4 flex justify-center items-center">
                    ثبت جنس جدید
                    <i class="px-2 material-icons hover:cursor-pointer">add_circle_outline</i>
                </a>
            </div>
            <div class="bg-gray-100 bg-opacity-25">
                <div class="max-w-7xl overflow-x-auto mx-auto">
                    <table class="rtl min-w-full text-left text-sm font-light">
                        <thead class="font-medium dark:border-neutral-500">
                            <tr class="bg-green-700">
                                <th scope="col" class="px-3 py-3 text-white text-center">
                                    شماره فنی
                                </th>
                                <th scope="col" class="px-3 py-3 text-white text-center">
                                    قیمت
                                </th>
                                <th scope="col" class="px-3 py-3 text-white text-center">
                                    وزن
                                </th>
                                <th scope="col" class="px-3 py-3 text-white text-center">
                                    موبیز
                                </th>
                                <th scope="col" class="px-3 py-3 text-white text-center">
                                    کورآ
                                </th>
                                <th scope="col" class="px-3 py-3 text-white text-center w-24">
                                    عملیات
                                </th>
                            </tr>
                        </thead>
                        <tbody id="results" :data-length="Math.round(count / 10)">
                            <tr v-if="goods.length > 0" v-for="item in goods"
                                class="transition duration-300 ease-in-out bg-neutral-200 hover:bg-neutral-100">
                                <td class="whitespace-nowrap px-3 py-3 text-center font-bold">
                                    {{ item.partnumber }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-3 text-center font-bold">
                                    {{ item.price }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-3 text-center font-bold">
                                    {{ item.weight }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-3 text-center font-bold">
                                    {{ item.mobis }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-3 text-center font-bold">
                                    {{ item.korea }}
                                </td>
                                <td class="whitespace-nowrap w-24">
                                    <div class="flex justify-center gap-1 items-center px-2">
                                        <a :href="route('goods.edit', item.id)">
                                            <i class="material-icons text-blue-500 hover:text-blue-700">create</i>
                                        </a>
                                        <form @submit.prevent="remove(item.id)">
                                            <button type="submit">
                                                <i class="material-icons text-red-600 hover:text-red-800">delete_forever</i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <tr v-else class="transition duration-300 ease-in-out bg-neutral-200">
                                <td colspan="14" class="whitespace-nowrap px-3 py-3 text-center text-red-500 font-bold">
                                    <i class="material-icons text-red-500">mood_bad</i>
                                    <br />
                                    !متاسفانه چیزی برای نمایش در پایگاه داده
                                    موجود نیست
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div v-if="goods.length > 0" class="flex justify-center py-3">
                        <ul class="flex">
                            <li class="bg-blue-400 hover:bg-blue-300 mx-2 flex justify-center items-center px-3 py-2 rounded-md cursor-pointer"
                                id="prev" @click="page('prev')">
                                <i class="material-icons text-white">fast_rewind</i>
                            </li>
                            <li class="bg-blue-400 hover:bg-blue-300 mx-2 flex justify-center items-center px-3 p-2 rounded-md cursor-pointer"
                                id="next" @click="page('next')">
                                <i class="material-icons text-white">fast_forward</i>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
