<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";

defineProps({
    rates: Object,
});
</script>

<template>
    <AppLayout title="Profile">
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <table class="min-w-full text-left text-sm font-light">
                <thead class="font-medium dark:border-neutral-500">
                    <tr class="bg-green-700">
                        <th
                            scope="col"
                            class="px-3 py-3 bg-black text-white w-52 text-center"
                        >
                            Rate
                        </th>
                        <th scope="col" class="px-3 py-3 text-white w-20">
                            Status
                        </th>
                        <th
                            scope="col"
                            class="px-3 py-3 text-white border-black border-r-2"
                        >
                            Color
                        </th>
                        <th
                            scope="col"
                            class="px-3 py-3 text-white w-32 text-center"
                        >
                            عملیات
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
    </AppLayout>
</template>
