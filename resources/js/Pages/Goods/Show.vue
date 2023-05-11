<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";

defineProps({
    goods: Object,
});
</script>

<template>
    <AppLayout title="Goods">
        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <table class="min-w-full text-left text-sm font-light">
                    <thead class="font-medium dark:border-neutral-500">
                        <tr class="bg-green-700">
                            <th
                                scope="col"
                                class="px-3 py-3 bg-black text-white w-52 text-center"
                            >
                                شماره فنی
                            </th>
                            <th scope="col" class="px-3 py-3 text-white w-20">
                                دلار پایه
                            </th>
                            <th
                                scope="col"
                                class="px-3 py-3 text-white border-black border-r-2"
                            >
                                +10%
                            </th>

                            <!-- START TO Loop over the existing rates at database -->
                            <th
                                v-for="item in rates"
                                :class="item.status"
                                scope="col"
                                class="px-3 py-3 text-white text-center"
                            >
                                {{ item.amount }}
                            </th>
                            <!-- END the loop -->

                            <th
                                scope="col"
                                class="px-3 py-3 text-white w-52 text-center"
                            >
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
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>
