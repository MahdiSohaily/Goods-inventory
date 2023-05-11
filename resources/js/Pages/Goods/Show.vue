<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import axios from "axios";

defineProps({
    goods: Object,
    count: Number,
});
let current_page = 0;
let pattern = null;

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
            data = await getData(current_page);
            break;
    }
};

const getData = (page, pattern) => {
    const resultBox = document.getElementById("results");
    axios
        .post("/search", {
            pattern,
            page,
        })
        .then(function (response) {
            resultBox.innerHTML = print(response.data);
        })
        .catch(function (error) {
            console.log(error);
        });
};

const print = (data, rates) => {
    let template = "";
    if (data[0].length > 0) {
        for (let item of data[0]) {
            const partNumber = item.partnumber;
            let price = item.price;
            let avgPrice = Math.round((price * 110) / 243.5);
            const weight = Number(item.weight).toFixed(1);
            const mobis = item.mobis;
            let status;

            if (mobis == "0.00") {
                status = "NO-Price";
            } else if (mobis == "-") {
                status = "NO-Mobis";
            } else if (mobis == null) {
                status = "Request";
            } else {
                status = "YES-Mobis";
            }

            template += `<tr class="transition duration-300 ease-in-out hover:bg-neutral-200">
                <td class='whitespace-nowrap bg-blue-900'>
                <div class='flex gap-1 text-white font-bold'>`;
            if (status == "Request") {
                template +=
                    ` <a class='link-s ml-4 Request' target='_blank' href='mobis/` +
                    partNumber +
                    `'>?</a>`;
            } else if (status == "NO-Price") {
                template +=
                    ` <a class='link-s ml-4 NO-Price' target='_blank' href='mobis/` +
                    partNumber +
                    `'>!</a>`;
            } else if (status == `NO-Mobis`) {
                template +=
                    ` <a class='link-s ml-4 NO-Mobis' target='_blank' href='mobis/` +
                    partNumber +
                    `'>x</a>`;
            } else {
                template += `<span class='ml-11'></span>`;
            }

            template +=
                partNumber +
                `</div></td>
                <td class='whitespace-nowrap text-center px-3 py-3'>` +
                Math.round(avgPrice * 1.1) +
                `</td>
                <td class='orange whitespace-nowrap text-center px-3 py-3 border-black border-r-2' >` +
                Math.round(avgPrice * 1.2) +
                `</td>`;

            template += normalRate(avgPrice, rates);

            template +=
                `
                <td class='whitespace-nowrap w-24'>
                    <div class='flex justify-center gap-1 items-center px-2'>
                    <a target='_blank' href='https://www.google.com/search?tbm=isch&q=` +
                partNumber +
                `'>
                        <img class='w-5 h-auto' src='/img/google.png' alt='google'>
                    </a>
                    <a msg='` +
                partNumber +
                `'>
                        <img class='w-5 h-auto' src='/img/tel.png' alt='part'>
                    </a>
                    <a target='_blank' href='https://partsouq.com/en/search/all?q=` +
                partNumber +
                `'>
                        <img class='w-5 h-auto' src='/img/part.png' alt='part'>
                    </a>
                </div>
                </td>
                <td class='whitespace-nowrap px-3 py-3 kg'>
                    <div class='weight'>` +
                weight +
                ` KG</div>
                </td>
            </tr> `;

            if (status == "YES-Mobis") {
                price = mobis;
                price = price.replace(",", "");
                avgPrice = Math.round((price * 110) / 243.5);
                template +=
                    `<tr class='bg-gray-300 transition duration-400 ease-in-out hover:bg-neutral-500'>
                        <td class='text-white font-bold pl-12'> ` +
                    partNumber +
                    `-M</td>
                        <td class='font-bold whitespace-nowrap text-center px-3 py-3'>` +
                    Math.round(avgPrice) +
                    `</td>
                        <td class='whitespace-nowrap px-3 py-3 text-center border-black border-r-2'>` +
                    Math.round(avgPrice * 1.1) +
                    `</td>`;
                template += mobisRate(avgPrice, rates);
                template += `<td></td><td></td></tr>`;
            }
        }
        return template;
    } else {
        return `<tr v-else class="transition duration-300 ease-in-out bg-neutral-200">
                    <td colspan="14" class="whitespace-nowrap px-3 py-3 text-center font-bold text-orange-500">
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
            <div class="p-6 lg:p-8 flex justify-center">
                <input
                    type="text"
                    name="serial"
                    id="serial"
                    class="rounded-md py-3 text-center w-96 border-2 bg-gray-100"
                    min="0"
                    max="30"
                    @keyup="search($event.target.value, rates)"
                    placeholder="... کد فنی قطعه را وارد کنید"
                />
            </div>
            <div class="bg-gray-100 bg-opacity-25">
                <div class="max-w-7xl overflow-x-auto mx-auto">
                    <table class="min-w-full text-left text-sm font-light">
                        <thead class="font-medium dark:border-neutral-500">
                            <tr class="bg-green-700">
                                <th
                                    scope="col"
                                    class="px-3 py-3 text-white text-center"
                                >
                                    شماره فنی
                                </th>
                                <th
                                    scope="col"
                                    class="px-3 py-3 text-white text-center"
                                >
                                    قیمت
                                </th>
                                <th
                                    scope="col"
                                    class="px-3 py-3 text-white text-center"
                                >
                                    وزن
                                </th>
                                <th
                                    scope="col"
                                    class="px-3 py-3 text-white text-center"
                                >
                                    موبیز
                                </th>
                                <th
                                    scope="col"
                                    class="px-3 py-3 text-white text-center"
                                >
                                    عملیات
                                </th>
                            </tr>
                        </thead>
                        <tbody
                            id="results"
                            :data-length="Math.round(count / 10)"
                        >
                            <tr
                                v-if="goods.length > 0"
                                v-for="item in goods"
                                class="transition duration-300 ease-in-out bg-neutral-200 hover:bg-neutral-100"
                            >
                                <td
                                    class="whitespace-nowrap px-3 py-3 text-center font-bold"
                                >
                                    {{ item.partnumber }}
                                </td>
                                <td
                                    class="whitespace-nowrap px-3 py-3 text-center font-bold"
                                >
                                    {{ item.price }}
                                </td>
                                <td
                                    class="whitespace-nowrap px-3 py-3 text-center font-bold"
                                >
                                    {{ item.weight }}
                                </td>
                                <td
                                    class="whitespace-nowrap px-3 py-3 text-center font-bold"
                                >
                                    {{ item.mobis }}
                                </td>
                                <td class="whitespace-nowrap w-24">
                                    <div
                                        class="flex justify-center gap-1 items-center px-2"
                                    >
                                        <a
                                            target="_blank"
                                            :href="
                                                'https://www.google.com/search?tbm=isch&q=' +
                                                item.partnumber
                                            "
                                        >
                                            <img
                                                class="w-5 h-auto"
                                                src="/img/google.png"
                                                alt="google"
                                            />
                                        </a>
                                        <a msg="partnumber">
                                            <img
                                                class="w-5 h-auto"
                                                src="/img/tel.png"
                                                alt="part"
                                            />
                                        </a>
                                        <a
                                            target="_blank"
                                            :href="
                                                'https://www.google.com/search?tbm=isch&q=' +
                                                item.partnumber
                                            "
                                        >
                                            <img
                                                class="w-5 h-auto"
                                                src="/img/part.png"
                                                alt="part"
                                            />
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <tr
                                v-else
                                class="transition duration-300 ease-in-out bg-neutral-200"
                            >
                                <td
                                    colspan="14"
                                    class="whitespace-nowrap px-3 py-3 text-center text-red-500 font-bold"
                                >
                                    <i class="material-icons text-red-500"
                                        >mood_bad</i
                                    >
                                    <br />
                                    !متاسفانه چیزی برای نمایش در پایگاه داده
                                    موجود نیست
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div
                        v-if="goods.length > 0"
                        class="flex justify-center py-3"
                    >
                        <ul class="flex">
                            <li
                                class="bg-blue-400 hover:bg-blue-300 mx-2 flex justify-center items-center px-3 py-2 rounded-md cursor-pointer"
                                id="prev"
                                @click="page('prev')"
                            >
                                <i class="material-icons">fast_rewind</i>
                            </li>
                            <li
                                class="bg-blue-400 hover:bg-blue-300 mx-2 flex justify-center items-center px-3 p-2 rounded-md cursor-pointer"
                                id="next"
                                @click="page('next')"
                            >
                                <i class="material-icons">fast_forward</i>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
