<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
defineProps({ rates: Object, result: Array });
</script>

<template>
    <AppLayout title="Search">
        <div class="py-12">
            <div class="max-w-full mx-auto sm:px-6 lg:px-8">
                <div>
                    <div class="bg-gray-100 bg-opacity-25">
                        <div class="max-w-7xl overflow-x-auto mx-auto">
                            <table class="min-w-full text-left text-sm font-light">
                                <thead class="font-medium dark:border-neutral-500">
                                    <tr class="bg-green-700">
                                        <th scope="col" class="px-3 py-3 bg-black text-white w-72 text-center">
                                            شماره فنی
                                        </th>
                                        <th scope="col" class="px-3 py-3 text-white w-32">
                                            دلار پایین
                                        </th>
                                        <th scope="col" class="px-3 py-3 text-white border-black border-r-2">
                                            دلار میانگین
                                        </th>
                                        <th scope="col" class="px-3 py-3 text-white border-black border-r-2">
                                            دلار بالا 
                                        </th>

                                        <!-- START TO Loop over the existing rates at database -->
                                        <th v-for="item in rates" :class="item.status" scope="col"
                                            class="px-3 py-3 text-white text-center">
                                            {{ item.amount }}
                                        </th>
                                        <!-- END the loop -->

                                        <th scope="col" class="px-3 py-3 text-white w-52 text-center">
                                            عملیات
                                        </th>
                                        <th scope="col" class="px-3 py-3 text-white">
                                            وزن
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="results">
                                    {{
                                        result ? result : ""
                                    }}
                                    <tr class="transition duration-300 ease-in-out hover:bg-neutral-200">
                                        <td class="whitespace-nowrap px-3 py-3 font-bold">
                                            1
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-3">
                                            Mark
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-3">
                                            Otto
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-3">
                                            @mdo
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-3 font-medium">
                                            1
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-3">
                                            Mark
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-3">
                                            Otto
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-3">
                                            @mdo
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-3 font-medium">
                                            1
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-3">
                                            Mark
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-3">
                                            Otto
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-3">
                                            @mdo
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-3 font-medium">
                                            1
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-3">
                                            Mark
                                        </td>
                                    </tr>
                                    <tr class="transition duration-300 ease-in-out hover:bg-neutral-200">
                                        <td class="whitespace-nowrap px-3 py-3 font-medium">
                                            1
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-3">
                                            Mark
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-3">
                                            Otto
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-3">
                                            @mdo
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-3 font-medium">
                                            1
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-3">
                                            Mark
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-3">
                                            Otto
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-3">
                                            @mdo
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-3 font-medium">
                                            1
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-3">
                                            Mark
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-3">
                                            Otto
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-3">
                                            @mdo
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-3 font-medium">
                                            1
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-3">
                                            Mark
                                        </td>
                                    </tr>
                                    <tr class="transition duration-300 ease-in-out hover:bg-neutral-200">
                                        <td class="whitespace-nowrap px-3 py-3 font-medium">
                                            1
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-3">
                                            Mark
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-3">
                                            Otto
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-3">
                                            @mdo
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-3 font-medium">
                                            1
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-3">
                                            Mark
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-3">
                                            Otto
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-3">
                                            @mdo
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-3 font-medium">
                                            1
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-3">
                                            Mark
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-3">
                                            Otto
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-3">
                                            @mdo
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-3 font-medium">
                                            1
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-3">
                                            Mark
                                        </td>
                                    </tr>
                                    <tr class="transition duration-300 ease-in-out hover:bg-neutral-200">
                                        <td class="whitespace-nowrap px-6 py-4 font-medium">
                                            1
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4">
                                            Mark
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4">
                                            Otto
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4">
                                            @mdo
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 font-medium">
                                            1
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4">
                                            Mark
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4">
                                            Otto
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4">
                                            @mdo
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 font-medium">
                                            1
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4">
                                            Mark
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4">
                                            Otto
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4">
                                            @mdo
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 font-medium">
                                            1
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4">
                                            Mark
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                >
            </div>
        </div>
    </AppLayout>
</template>
