<script setup>
import { onMounted, ref } from 'vue';
import axios from 'axios';

const props = defineProps({
    id: String,
    partNumber: String,
});

const relationInfo = ref(null);
const relationCars = ref(null);

const getRelationInfo = (id) => {
    axios
        .post("/price/info", {
            id,
        })
        .then(function (response) {
            if (response.data) {
                relationInfo.value = response.data.info;
                relationCars.value = response.data.cars;
            }

        })
        .catch(function (error) {
            console.log(error);
        });
}


onMounted(() => {
    getRelationInfo(props.id);
})
</script>

<template>
    <div class="bg-white rounded-lg">
        <div id="search_result" class="rtl p-3">
            <p class="text-center bg-gray-600 text-white p-2 my-3 rounded-md">
                {{ props.partNumber }}
            </p>
            <div v-if="relationInfo">
                <p class="my-2">{{ relationInfo.name }}</p>
                <p class="my-2">وضعیت: {{ relationInfo.status_name }}</p>
                <ul>
                    <li class="" v-for="elem in relationCars">
                        {{ elem.name }}
                    </li>
                </ul>
            </div>
            <p v-else>
                رابطه ای پیدا نشد
            </p>
        </div>
    </div>
</template>
