<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { useForm } from "@inertiajs/vue3";
import axios from "axios";

const props = defineProps({
    answeredNotifications: Array,
    adminNotification: Array,
    previousNotifications: Array,
    admin: Boolean,
});

const form = useForm({
    _method: "GET",
    id: null,
    customer: null,
    code: null,
});

const travelTO = (id, code, customer) => {
    form.id = id;
    form.code = code + "";
    form.customer = customer;
    form.post(route("price.load"), {
        errorBag: "LoadPrice",
        preserveScroll: true,
    });
};

const weDontHave = (id, code, customer) => {
    axios
        .post("/notification/clear", {
            id,
            code,
            customer,
        })
        .then(function (response) {
            location.reload();
        })
        .catch(function (error) {
            console.log(error);
        });
};

const markUsRead = (id) => {
    axios
        .post("/notification/read", {
            id,
        })
        .then(function (response) {
            location.reload();
        })
        .catch(function (error) {
            console.log(error);
        });
};



</script>

<template>
    <AppLayout title="notifications">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 px-6 bg-gray-100 bg-opacity-25 mt-20 rtl ">
            <div v-if="admin" class="max-w-7xl mb-5">
                <h1 class="text-2xl py-3 rtl" v-if="adminNotification">قیمت های پرسیده شده</h1>
                <table class="rtl min-w-full text-left text-sm font-light">
                    <thead class="font-medium dark:border-neutral-500">
                        <tr class="bg-green-700">
                            <th scope="col" class="px-3 py-3 text-white text-center">
                                شماره فنی
                            </th>
                            <th scope="col" class="px-3 py-3 text-white text-center">
                                مشتری
                            </th>
                            <th scope="col" class="px-3 py-3 text-white text-center">
                                کاربر ارسال کننده
                            </th>
                            <th scope="col" class="px-3 py-3 text-white text-center">
                                وضعیت
                            </th>
                            <th scope="col" class="px-3 py-3 text-white text-center w-24">
                                عملیات
                            </th>
                        </tr>
                    </thead>
                    <tbody id="results">
                        <tr v-if="adminNotification.length > 0" v-for="item in adminNotification"
                            class="transition duration-300 ease-in-out bg-neutral-200 hover:bg-neutral-100">
                            <td class="whitespace-nowrap px-3 py-3 text-center font-bold">
                                {{ item.code }}
                            </td>
                            <td class="whitespace-nowrap px-3 py-3 text-center font-bold">
                                {{ item.customer_name }}
                            </td>
                            <td class="whitespace-nowrap px-3 py-3 text-center font-bold">
                                {{ item.user_name }}
                            </td>
                            <td class="whitespace-nowrap px-3 py-3 text-center font-bold">
                                {{ item.status === 'pending' ? 'در حال انتظار' : 'بررسی شده' }}

                            </td>

                            <td class="whitespace-nowrap w-24">
                                <div class="flex justify-center gap-1 items-center px-2">
                                    <a>
                                        <i @click="travelTO(item.id, item.code, item.customer_id)"
                                            class="material-icons text-blue-500 hover:text-blue-700 hover:cursor-pointer">archive</i>
                                    </a>
                                    <a>
                                        <i @click="weDontHave(item.id, item.code, item.customer_id)"
                                            class="bold material-icons text-red-500 hover:text-red-700 hover:cursor-pointer">close</i>
                                    </a>
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
            </div>
            <div class="max-w-7xl ">
                <h1 class="text-2xl py-3 rtl">جواب های دریافتی</h1>
                <table class="rtl min-w-full text-left text-sm font-light">
                    <thead class="font-medium dark:border-neutral-500">
                        <tr class="bg-green-700">
                            <th scope="col" class="px-3 py-3 text-white text-center">
                                شماره فنی
                            </th>
                            <th scope="col" class="px-3 py-3 text-white text-center">
                                مشتری
                            </th>
                            <th scope="col" class="px-3 py-3 text-white text-center">
                                کاربر ارسال کننده
                            </th>
                            <th scope="col" class="px-3 py-3 text-white text-center">
                                قیمت داده شده </th>
                            <th scope="col" class="px-3 py-3 text-white text-center w-24">
                                عملیات
                            </th>
                        </tr>
                    </thead>
                    <tbody id="results">
                        <tr v-if="answeredNotifications.length > 0" v-for="item in answeredNotifications"
                            class="transition duration-300 ease-in-out bg-neutral-200 hover:bg-neutral-100">
                            <td class="whitespace-nowrap px-3 py-3 text-center font-bold">
                                {{ item.code }}
                            </td>
                            <td class="whitespace-nowrap px-3 py-3 text-center font-bold">
                                {{ item.customer_name }}
                            </td>
                            <td class="whitespace-nowrap px-3 py-3 text-center font-bold">
                                {{ item.user_name }}
                            </td>
                            <td class="whitespace-nowrap px-3 py-3 text-center font-bold">
                                {{ item.price }}

                            </td>

                            <td class="whitespace-nowrap w-24">
                                <div class="flex justify-center gap-1 items-center px-2">
                                    <a>
                                        <i @click="markUsRead(item.id)"
                                            class="material-icons text-blue-500 hover:text-blue-700 hover:cursor-pointer">remove_red_eye</i>
                                    </a>

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
            </div>
            <div class="max-w-7xl ">
                <h1 class="text-2xl py-3 rtl">مشاهده شده</h1>
                <table class="rtl min-w-full text-left text-sm font-light">
                    <thead class="font-medium dark:border-neutral-500">
                        <tr class="bg-green-700">
                            <th scope="col" class="px-3 py-3 text-white text-center">
                                شماره فنی
                            </th>
                            <th scope="col" class="px-3 py-3 text-white text-center">
                                مشتری
                            </th>
                            <th scope="col" class="px-3 py-3 text-white text-center">
                                کاربر ارسال کننده
                            </th>
                            <th scope="col" class="px-3 py-3 text-white text-center">
                                قیمت داده شده </th>
                            <th scope="col" class="px-3 py-3 text-white text-center w-24">
                                عملیات
                            </th>
                        </tr>
                    </thead>
                    <tbody id="results">
                        <tr v-if="previousNotifications.length > 0" v-for="item in previousNotifications"
                            class="transition duration-300 ease-in-out bg-neutral-200 hover:bg-neutral-100">
                            <td class="whitespace-nowrap px-3 py-3 text-center font-bold">
                                {{ item.code }}
                            </td>
                            <td class="whitespace-nowrap px-3 py-3 text-center font-bold">
                                {{ item.customer_name }}
                            </td>
                            <td class="whitespace-nowrap px-3 py-3 text-center font-bold">
                                {{ item.user_name }}
                            </td>
                            <td class="whitespace-nowrap px-3 py-3 text-center font-bold">
                                {{ item.price }}

                            </td>

                            <td class="whitespace-nowrap w-24">
                                <div class="flex justify-center gap-1 items-center px-2">
                                    <a>
                                        <i @click="markUsRead(item.id)"
                                            class="material-icons text-blue-500 hover:text-blue-700 hover:cursor-pointer">remove_red_eye</i>
                                    </a>

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
            </div>
        </div>
    </AppLayout>
</template>
