<script setup>
const props = defineProps({
    partNumber: String,
});
</script>

<template>
    <div class="bg-white rounded-lg">
        <div id="search_result" class="p-3">
            <p class="text-center bg-gray-600 text-white p-2 my-3 rounded-md">
                {{ item.search }}
            </p>
            <p class="text-center my-2">{{ item.result.name }}</p>
            <p class="text-center my-2">{{ item.result.status }}</p>
            <ul>
                <li class="text-center" v-for="elem in item.result.cars">
                    {{ elem.name }}
                </li>
            </ul>
        </div>
    </div>
</template>
