<script setup>
import { onMounted, ref } from 'vue';
import axios from 'axios';

const props = defineProps({
    id: String,
    partNumber: String,
});

const relationInfo = ref(null);

const getRelationInfo = (id) => {
    axios
        .post("/price/info", {
            id,
        })
        .then(function (response) {
            response.data ? relationInfo.value = response.data : false;
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
        <div id="search_result" class="p-3">
            <p class="text-center bg-gray-600 text-white p-2 my-3 rounded-md">
                {{ props.partNumber }}
            </p>
            <div v-if="relationInfo">
                <p class="text-center my-2">{{ relationInfo.name }}</p>
                <p class="text-center my-2">{{ relationInfo.status_name }}</p>
                <!-- <ul>
                        <li class="text-center" v-for="elem in item.result.cars">
                            {{ elem.name }}
                        </li>
                    </ul> -->
            </div>
            <p v-else>
                رابطه ای پیدا نشد
            </p>
        </div>
    </div>
</template>
