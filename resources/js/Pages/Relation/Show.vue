p
<script setup>
import { Link, router, useForm } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import SectionBorder from "@/Components/SectionBorder.vue";
import ActionMessage from '@/Components/ActionMessage.vue';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

defineProps({
    status: Object,
    cars: Object,
});

$(document).ready(() => {
    $(document).on("click", ".element", add);
});

const form = useForm({
    _method: "POST",
    name: null,
    status_id: null,
    car_id: null,
    values: [],
});

let result = null;

/***  This function fires on every keyup event on a specific input field and at a specific length
 *    sends an ajax request using the axios library.
 */
const search = (val) => {
    let pattern = val;
    const resultBox = document.getElementById("search_result");

    if (pattern.length > 6) {
        pattern = pattern.replace(/\s/g, "");
        pattern = pattern.replace(/-/g, "");
        pattern = pattern.replace(/_/g, "");

        resultBox.innerHTML = `<tr class=''>
                <div class='w-full h-96 flex justify-center items-center'>
                    <img class=' block w-10 mx-auto h-auto' src='/img/loading.png' alt='google'>
                    </div>
            </tr>`;
        axios
            .post(route("relations.search"), {
                pattern,
            })
            .then(function (response) {
                resultBox.innerHTML = prepareData(response.data);
            })
            .catch(function (error) {
                console.log(error);
            });
    } else {
        resultBox.innerHTML = "";
    }
};

/**
 * This function prepares data to be attached and returns it.
 */
const prepareData = (data) => {
    let template = "";
    if (data.length > 0) {
        for (let item of data) {
            if (item.pattern) {
                template +=
                    `<div class='w-full element flex justify-between items-center shadow-md hover:shadow-lg rounded-md px-4 py-3 mb-2 border-1 border-gray-300' id='search-` +
                    item.id +
                    `'>
                    <p class='text-sm font-semibold text-gray-600'>` +
                    item.partNumber +
                    `</p>
                    <i 
                        data-id='` +
                    item.id +
                    `'
                        data-partNumber='` +
                    item.partNumber +
                    `'
                        class='element material-icons add text-green-600 cursor-pointer rounded-circle hover:bg-gray-200'>add_circle_outline
                    </i>
                </div>`;
            } else {
                template +=
                    `<div class='w-full  flex justify-between items-center shadow-md hover:shadow-lg rounded-md px-4 py-3 mb-2 border-1 border-gray-300' id='search-` +
                    item.id +
                    `'>
                    <p class='text-sm font-semibold text-gray-600'>` +
                    item.partNumber +
                    `</p>
                    <i
                        data-id='` +
                    item.id +
                    `'
                        data-partNumber='` +
                    item.partNumber +
                    `'
                        class='element material-icons add text-green-600 cursor-pointer rounded-circle hover:bg-gray-200'>add_circle_outline
                    </i>
                </div>`;
            }
        }
    } else {
        template += `<div class='w-full text-center shadow-md hover:shadow-lg rounded-md px-4 py-3 mb-2 border-1 border-gray-300''>
                <i class='material-icons text-red-500'>error</i>
                <br/>
                <p class='text-sm font-semibold text-gray-600 text-red-500'> Nothing to show (<span class="text-sm">Check the part number</span>)</p>
            </div>`;
    }

    return template;
};

// A function to add a good to the relation box
const add = (e) => {
    const id = e.target.getAttribute("data-id");
    const partNumber = e.target.getAttribute("data-partnumber");
    form.values.push({ id: id, partNumber: partNumber });
    remove(id);
};

const remove_selected = (e) => {
    const id = e.target.getAttribute("data-id");
    form.values = form.values.filter((item) => {
        return item.id != id;
    });
    console.log(form.values);
};

const clearAll = () => {
    form.values = [];
};

// A function to load data a good to the relation box
function load(event, pattern_id) {
    const id = event.target.getAttribute("data-id");
    const remove = document.getElementById(id);

    const result = document.getElementById("s-result");
    const selected = document.getElementById("selected");

    const mode = document.getElementById("mode");
    mode.value = "update-" + pattern_id;

    result.removeChild(remove);

    if (id) {
        selected.innerHTML =
            "<img id='loading' src='<?php echo URL_ROOT . URL_SUBFOLDER ?>/public/img/loading.gif' alt=''>";
        axios
            .get("loadData/" + id)
            .then((response) => {
                setData(response.data);
                axios
                    .get("loadDescription/" + id)
                    .then((response) => {
                        setValue(response.data);
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            })
            .catch((error) => {
                console.log(error);
            });
    }
}

// A function to remove added goods from relation box
function remove(id) {
    const item = document.getElementById("search-" + id);
    item.remove();
}
</script>

<template>
    <AppLayout title="Relations">
        <div class="h-70S grid grid-cols-1 my-8 md:grid-cols-3 gap-6 lg:gap-8 p-6 lg:p-8">
            <div class="bg-white rounded-lg shadow-md">
                <div class="flex items-center justify-between p-3">
                    <h2 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
                        <i class="material-icons font-semibold text-orange-400">search</i>
                        Search Goods
                    </h2>
                </div>

                <div class="flex justify-center px-3">
                    <input type="text" name="serial" id="serial"
                        class="rounded-md py-3 w-full border-1 text-sm border-gray-300 focus:outline-none text-gray-500"
                        min="0" max="30" @keyup="search($event.target.value, rates)" placeholder="Part Number ..." />
                </div>
                <SectionBorder />
                <div id="search_result" class="p-3">
                    <!-- Search Results are going to be appended here -->
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md">
                <div class="flex items-center justify-between p-3">
                    <h2 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
                        <i class="material-icons text-green-600">beenhere</i>
                        Selected Items
                    </h2>
                    <button class="border-none bg-red-500 hover:bg-red-600 text-white rounded-lg px-4 py-2 text-sm"
                        @click="clearAll">
                        Clear All
                    </button>
                </div>
                <p class="px-3 mb-4 text-gray-500 text-sm leading-relaxed">
                    List of the selected items to be added on relation!.
                </p>
                <SectionBorder />

                <div id="selected_box" class="p-3">
                    <!-- selected items are going to be added here -->
                    <div v-if="form.values.length > 0" v-for="item in form.values"
                        class="w-full flex justify-between items-center shadow-md hover:shadow-lg rounded-md px-4 py-3 mb-2 border-1 border-gray-300">
                        <p class="text-sm font-semibold text-gray-600">
                            {{ item.partNumber }}
                        </p>
                        <i :data-id="item.id" :data-partNumber="item.partNumber" @click="remove_selected"
                            class="material-icons add text-red-600 cursor-pointer rounded-circle hover:bg-gray-200">do_not_disturb_on
                        </i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md">
                <div class="p-3">
                    <h2 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
                        <i class="material-icons font-semibold text-blue-500">save</i>
                        Register Relation
                    </h2>
                </div>

                <p class="px-3 py-1 mb-4 text-gray-500 text-sm leading-relaxed">
                    Fill out the following form in order to register a relation.
                </p>

                <SectionBorder />
                
                <p class="mt-4 text-sm">
                    <a href="https://laravel.com/docs" class="inline-flex items-center font-semibold text-indigo-700">
                        Explore the documentation

                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="ml-1 w-5 h-5 fill-indigo-500">
                            <path fill-rule="evenodd"
                                d="M5 10a.75.75 0 01.75-.75h6.638L10.23 7.29a.75.75 0 111.04-1.08l3.5 3.25a.75.75 0 010 1.08l-3.5 3.25a.75.75 0 11-1.04-1.08l2.158-1.96H5.75A.75.75 0 015 10z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>
                </p>
            </div>
        </div>
    </AppLayout>
</template>
