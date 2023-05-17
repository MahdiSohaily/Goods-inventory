<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { router } from "@inertiajs/vue3";
const remove = (id) => {
    if (confirm("Are you sure you want to delete this record?") == true) {
        router.delete(route("rates.delete", id));
    }
};
defineProps({
    rates: Object,
});
</script>

<template>
    <AppLayout title="Rates">
        <div class="max-w-5xl mx-auto py-20 sm:px-6 lg:px-8">
            <div class="mb-3">
                <a
                    :href="route('rates.create')"
                    class="bg-indigo-500 hover:bg-indigo-400 rounded-md text-white px-4 py-2"
                    >Create</a
                >
            </div>
            <table class="min-w-full text-left text-sm font-light">
                <thead class="font-medium dark:border-neutral-500">
                    <tr class="bg-green-700">
                        <th
                            scope="col"
                            class="px-3 py-3 text-white text-center"
                        >
                            Rate
                        </th>
                        <th
                            scope="col"
                            class="px-3 py-3 text-white text-center"
                        >
                            Status
                        </th>
                        <th
                            scope="col"
                            class="px-3 py-3 text-white text-center"
                        >
                            Color
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
                        v-if="rates.length > 0"
                        v-for="item in rates"
                        class="transition duration-300 ease-in-out bg-neutral-200 hover:bg-neutral-100"
                    >
                        <td
                            class="whitespace-nowrap px-3 py-3 text-center font-bold"
                        >
                            {{ item.amount }}
                        </td>
                        <td
                            class="whitespace-nowrap px-3 py-3 text-center font-bold"
                        >
                            {{ item.status }}
                        </td>
                        <td
                            class="whitespace-nowrap px-3 py-3 text-center font-bold"
                            :class="item.status"
                        >
                            {{}}
                        </td>
                        <td class="whitespace-nowrap w-24">
                            <div
                                class="flex justify-center gap-1 items-center px-2"
                            >
                                <a :href="route('rates.edit', item.id)">
                                    <i class="material-icons text-blue-500"
                                        >create</i
                                    >
                                </a>
                                <form @submit.prevent="remove(item.id)">
                                    <button type="submit">
                                        <i class="material-icons text-red-600"
                                            >delete_forever</i
                                        >
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
