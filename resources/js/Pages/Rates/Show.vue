<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import axios from "axios";
import { router } from "@inertiajs/vue3";
const remove = (id) => {
    if (confirm("Are you sure you want to delete this record?") == true) {
        router.delete(route("rates.delete", id));
    }
};
defineProps({
    rates: Object,
});

const toggleSelected = (e) => {
    const value = e.target.checked;
    const id = e.target.getAttribute('data-id');
    axios
        .post("/rate/toggle/selected", {
            value,
            id
        })
        .then(function (response) {

        })
        .catch(function (error) {
            console.log(error);
        });
}
</script>

<template>
    <AppLayout title="Rates">
        <div class="rtl max-w-5xl mx-auto py-20 sm:px-6 lg:px-8">
            <div class="mb-3">
                <a :href="route('rates.create')"
                    class=" flex items-center w-52 bg-indigo-500 hover:bg-indigo-400 rounded-md text-white px-4 py-2">
                    <i class="px-2 material-icons hover:cursor-pointer">add_circle_outline</i>
                    ثبت نرخ ارز جدید</a>
            </div>
            <table class="min-w-full text-left text-sm font-light">
                <thead class="font-medium dark:border-neutral-500">
                    <tr class="bg-green-700">
                        <th scope="col" class="px-3 py-3 text-white text-center">
                            نرخ ارز
                        </th>
                        <th scope="col" class="px-3 py-3 text-white text-center">
                            شاخص نرخ
                        </th>
                        <th scope="col" class="px-3 py-3 text-white text-center">
                            زنگ شاخص
                        </th>
                        <th scope="col" class="px-3 py-3 text-white text-center">
                            انتخاب به عنوان پیش فرض
                        </th>
                        <th scope="col" class="px-3 py-3 text-white text-center">
                            عملیات
                        </th>
                    </tr>
                </thead>
                <tbody id="results">
                    <tr v-if="rates.length > 0" v-for="item in rates"
                        class="transition duration-300 ease-in-out bg-neutral-200 hover:bg-neutral-100">
                        <td class="whitespace-nowrap px-3 py-3 text-center font-bold">
                            {{ item.amount }}
                        </td>
                        <td class="whitespace-nowrap px-3 py-3 text-center font-bold">
                            {{ item.status }}
                        </td>
                        <td class="whitespace-nowrap px-3 py-3 text-center font-bold" :class="item.status">
                            {{}}
                        </td>
                        <td class="whitespace-nowrap px-3 py-3 text-center font-bold">
                            <input type="checkbox" name="selected" id="selected" :checked="item.selected" :data-id="item.id"
                                @click="toggleSelected">
                        </td>
                        <td class="whitespace-nowrap w-24">
                            <div class="flex justify-center gap-1 items-center px-2">
                                <a :href="route('rates.edit', item.id)">
                                    <i class="material-icons text-blue-500">create</i>
                                </a>
                                <form @submit.prevent="remove(item.id)">
                                    <button type="submit">
                                        <i class="material-icons text-red-600">delete_forever</i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </AppLayout>
</template>
