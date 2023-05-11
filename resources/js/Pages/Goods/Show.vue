<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import axios from "axios";

defineProps({
    goods: Object,
    count: Number,
});
let current_page = 0;

const page = async (action) => {
    const results = document.getElementById("results");
    let data = null;
    switch (action) {
        case "prev":
            --current_page;
            alert(current_page);
            data = await getData(current_page);
            break;
        case "next":
            ++current_page;
            alert(current_page);
            data = await getData(current_page);
            break;
    }
};

const getData = (page) => {
    axios
        .post("/search", {
            pattern,
            superMode,
        })
        .then(function (response) {
            resultBox.innerHTML = print(response.data, rates);
        })
        .catch(function (error) {
            console.log(error);
        });
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
                        <tbody id="results">
                            <tr
                                :data-length="goods.length"
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
