<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { useForm } from "@inertiajs/vue3";
import axios from "axios";

const props = defineProps({
    notifications: Array
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


</script>

<template>
    <AppLayout title="notifications">
        <InputError :message="form.errors.customer" class="mt-2" />
        <InputError :message="form.errors.code" class="mt-2" />
        <div class="bg-gray-100 bg-opacity-25">
            <div class="max-w-7xl overflow-x-auto mx-auto">
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
                        <tr v-if="notifications.length > 0" v-for="item in notifications"
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
                                در حال انتظار
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
        </div>
    </AppLayout>
</template>
