<script setup>
import { useForm } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import SectionBorder from "@/Components/SectionBorder.vue";
import ActionMessage from "@/Components/ActionMessage.vue";
import FormRelation from "@/Components/FormRelation.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";

// Initialize function, create initial tokens with itens that are already selected by the user
function init(element) {
    // Create div that wroaps all the elements inside (select, elements selected, search div) to put select inside
    const wrapper = document.createElement("div");
    wrapper.addEventListener("click", clickOnWrapper);
    wrapper.classList.add("multi-select-component");

    // Create elements of search
    const search_div = document.createElement("div");
    search_div.classList.add("search-container");
    const input = document.createElement("input");
    input.classList.add("selected-input");
    input.setAttribute("autocomplete", "off");
    input.setAttribute("tabindex", "0");
    input.addEventListener("keyup", inputChange);
    input.addEventListener("keydown", deletePressed);
    input.addEventListener("click", openOptions);

    const dropdown_icon = document.createElement("a");
    dropdown_icon.setAttribute("href", "#");
    dropdown_icon.classList.add("dropdown-icon");

    dropdown_icon.addEventListener("click", clickDropdown);
    const autocomplete_list = document.createElement("ul");
    autocomplete_list.classList.add("autocomplete-list");
    search_div.appendChild(input);
    search_div.appendChild(autocomplete_list);
    search_div.appendChild(dropdown_icon);

    // set the wrapper as child (instead of the element)
    element.parentNode.replaceChild(wrapper, element);
    // set element as child of wrapper
    wrapper.appendChild(element);
    wrapper.appendChild(search_div);

    createInitialTokens(element);
    addPlaceholder(wrapper);
}

function removePlaceholder(wrapper) {
    const input_search = wrapper.querySelector(".selected-input");
    input_search.removeAttribute("placeholder");
}

function addPlaceholder(wrapper) {
    const input_search = wrapper.querySelector(".selected-input");
    const tokens = wrapper.querySelectorAll(".selected-wrapper");
    if (!tokens.length && !(document.activeElement === input_search))
        input_search.setAttribute("placeholder", "---------");
}

// Function that create the initial set of tokens with the options selected by the users
function createInitialTokens(select) {
    let { options_selected } = getOptions(select);
    const wrapper = select.parentNode;
    for (let i = 0; i < options_selected.length; i++) {
        createToken(wrapper, options_selected[i]);
    }
}

// Listener of user search
function inputChange(e) {
    const wrapper = e.target.parentNode.parentNode;
    const select = wrapper.querySelector("select");
    const dropdown = wrapper.querySelector(".dropdown-icon");

    const input_val = e.target.value;

    if (input_val) {
        dropdown.classList.add("active");
        populateAutocompleteList(select, input_val.trim());
    } else {
        dropdown.classList.remove("active");
        const event = new Event("click");
        dropdown.dispatchEvent(event);
    }
}

// Listen for clicks on the wrapper, if click happens focus on the input
function clickOnWrapper(e) {
    const wrapper = e.target;
    if (wrapper.tagName == "DIV") {
        const input_search = wrapper.querySelector(".selected-input");
        const dropdown = wrapper.querySelector(".dropdown-icon");
        if (!dropdown.classList.contains("active")) {
            const event = new Event("click");
            dropdown.dispatchEvent(event);
        }
        input_search.focus();
        removePlaceholder(wrapper);
    }
}

function openOptions(e) {
    const input_search = e.target;
    const wrapper = input_search.parentElement.parentElement;
    const dropdown = wrapper.querySelector(".dropdown-icon");
    if (!dropdown.classList.contains("active")) {
        const event = new Event("click");
        dropdown.dispatchEvent(event);
    }
    e.stopPropagation();
}

// Function that create a token inside of a wrapper with the given value
function createToken(wrapper, value) {
    const search = wrapper.querySelector(".search-container");
    // Create token wrapper
    const token = document.createElement("div");
    token.classList.add("selected-wrapper");
    const token_span = document.createElement("span");
    token_span.classList.add("selected-label");
    token_span.innerText = value;
    const close = document.createElement("a");
    close.classList.add("selected-close");
    close.setAttribute("tabindex", "-1");
    close.setAttribute("data-option", value);
    close.setAttribute("data-hits", 0);
    close.setAttribute("href", "#");
    close.innerText = "x";
    close.addEventListener("click", removeToken);
    token.appendChild(token_span);
    token.appendChild(close);
    wrapper.insertBefore(token, search);
}

// Listen for clicks in the dropdown option
function clickDropdown(e) {
    const dropdown = e.target;
    const wrapper = dropdown.parentNode.parentNode;
    const input_search = wrapper.querySelector(".selected-input");
    const select = wrapper.querySelector("select");
    dropdown.classList.toggle("active");

    if (dropdown.classList.contains("active")) {
        removePlaceholder(wrapper);
        input_search.focus();

        if (!input_search.value) {
            populateAutocompleteList(select, "", true);
        } else {
            populateAutocompleteList(select, input_search.value);
        }
    } else {
        clearAutocompleteList(select);
        addPlaceholder(wrapper);
    }
}

// Clears the results of the autocomplete list
function clearAutocompleteList(select) {
    const wrapper = select.parentNode;

    const autocomplete_list = wrapper.querySelector(".autocomplete-list");
    autocomplete_list.innerHTML = "";
}

// Populate the autocomplete list following a given query from the user
function populateAutocompleteList(select, query, dropdown = false) {
    const { autocomplete_options } = getOptions(select);

    let options_to_show;

    if (dropdown) options_to_show = autocomplete_options;
    else options_to_show = autocomplete(query, autocomplete_options);

    const wrapper = select.parentNode;
    const input_search = wrapper.querySelector(".search-container");
    const autocomplete_list = wrapper.querySelector(".autocomplete-list");
    autocomplete_list.innerHTML = "";
    const result_size = options_to_show.length;

    if (result_size == 1) {
        const li = document.createElement("li");
        li.innerText = options_to_show[0];
        li.setAttribute("data-value", options_to_show[0]);
        li.addEventListener("click", selectOption);
        autocomplete_list.appendChild(li);
        if (query.length == options_to_show[0].length) {
            const event = new Event("click");
            li.dispatchEvent(event);
        }
    } else if (result_size > 1) {
        for (let i = 0; i < result_size; i++) {
            const li = document.createElement("li");
            li.innerText = options_to_show[i];
            li.setAttribute("data-value", options_to_show[i]);
            li.addEventListener("click", selectOption);
            autocomplete_list.appendChild(li);
        }
    } else {
        const li = document.createElement("li");
        li.classList.add("not-cursor");
        li.innerText = "No options found";
        autocomplete_list.appendChild(li);
    }
}

// Listener to autocomplete results when clicked set the selected property in the select option
function selectOption(e) {
    const wrapper = e.target.parentNode.parentNode.parentNode;
    const input_search = wrapper.querySelector(".selected-input");
    const option = wrapper.querySelector(
        `select option[value="${e.target.dataset.value}"]`
    );

    option.setAttribute("selected", "");
    createToken(wrapper, e.target.dataset.value);
    if (input_search.value) {
        input_search.value = "";
    }

    input_search.focus();

    e.target.remove();
    const autocomplete_list = wrapper.querySelector(".autocomplete-list");

    if (!autocomplete_list.children.length) {
        const li = document.createElement("li");
        li.classList.add("not-cursor");
        li.innerText = "No options found";
        autocomplete_list.appendChild(li);
    }

    const event = new Event("keyup");
    input_search.dispatchEvent(event);
    e.stopPropagation();
}

// function that returns a list with the autcomplete list of matches
function autocomplete(query, options) {
    // No query passed, just return entire list
    if (!query) {
        return options;
    }
    let options_return = [];

    for (let i = 0; i < options.length; i++) {
        if (
            query.toLowerCase() ===
            options[i].slice(0, query.length).toLowerCase()
        ) {
            options_return.push(options[i]);
        }
    }
    return options_return;
}

// Returns the options that are selected by the user and the ones that are not
function getOptions(select) {
    // Select all the options available
    const all_options = Array.from(select.querySelectorAll("option")).map(
        (el) => el.value
    );

    // Get the options that are selected from the user
    const options_selected = Array.from(
        select.querySelectorAll("option:checked")
    ).map((el) => el.value);

    // Create an autocomplete options array with the options that are not selected by the user
    const autocomplete_options = [];
    all_options.forEach((option) => {
        if (!options_selected.includes(option)) {
            autocomplete_options.push(option);
        }
    });

    autocomplete_options.sort();

    return {
        options_selected,
        autocomplete_options,
    };
}

// Listener for when the user wants to remove a given token.
function removeToken(e) {
    // Get the value to remove
    const value_to_remove = e.target.dataset.option;
    const wrapper = e.target.parentNode.parentNode;
    const input_search = wrapper.querySelector(".selected-input");
    const dropdown = wrapper.querySelector(".dropdown-icon");
    // Get the options in the select to be unselected
    const option_to_unselect = wrapper.querySelector(
        `select option[value="${value_to_remove}"]`
    );
    option_to_unselect.removeAttribute("selected");
    // Remove token attribute
    e.target.parentNode.remove();
    input_search.focus();
    dropdown.classList.remove("active");
    const event = new Event("click");
    dropdown.dispatchEvent(event);
    e.stopPropagation();
}

// Listen for 2 sequence of hits on the delete key, if this happens delete the last token if exist
function deletePressed(e) {
    const wrapper = e.target.parentNode.parentNode;
    const input_search = e.target;
    const key = e.keyCode || e.charCode;
    const tokens = wrapper.querySelectorAll(".selected-wrapper");

    if (tokens.length) {
        const last_token_x = tokens[tokens.length - 1].querySelector("a");
        let hits = +last_token_x.dataset.hits;

        if (key == 8 || key == 46) {
            if (!input_search.value) {
                if (hits > 1) {
                    // Trigger delete event
                    const event = new Event("click");
                    last_token_x.dispatchEvent(event);
                } else {
                    last_token_x.dataset.hits = 2;
                }
            }
        } else {
            last_token_x.dataset.hits = 0;
        }
    }
    return true;
}

// You can call this function if you want to add new options to the select plugin
// Target needs to be a unique identifier from the select you want to append new option for example #multi-select-plugin
// Example of usage addOption("#multi-select-plugin", "tesla", "Tesla")
function addOption(target, val, text) {
    const select = document.querySelector(target);
    let opt = document.createElement("option");
    opt.value = val;
    opt.innerHTML = text;
    select.appendChild(opt);
}

$(document).ready(() => {
    const select = document.querySelectorAll("[data-multi-select-plugin]");
    select.forEach((select) => {
        init(select);
    });

    // Dismiss on outside click
    document.addEventListener("click", () => {
        // get select that has the options available
        const select = document.querySelectorAll("[data-multi-select-plugin]");
        for (let i = 0; i < select.length; i++) {
            if (event) {
                var isClickInside = select[
                    i
                ].parentElement.parentElement.contains(event.target);

                if (!isClickInside) {
                    const wrapper = select[i].parentElement.parentElement;
                    const dropdown = wrapper.querySelector(".dropdown-icon");
                    const autocomplete_list =
                        wrapper.querySelector(".autocomplete-list");
                    //the click was outside the specifiedElement, do something
                    dropdown.classList.remove("active");
                    autocomplete_list.innerHTML = "";
                    addPlaceholder(wrapper);
                }
            }
        }
    });
});

defineProps({
    status: Object,
    cars: Object,
});

$(document).ready(() => {
    $(document).on("click", ".add_element", add);
    $(document).on("click", ".load_element", load);
});

const form = useForm({
    _method: "POST",
    name: null,
    serial: null,
    price: null,
    status_id: [],
    pattern_id: null,
    car_id: null,
    values: [],
});

let result = null;
let url = "relations.store";

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

        form.serial = pattern;

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
                result = response.data;
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
                    `<div class='w-full flex justify-between items-center shadow-md hover:shadow-lg rounded-md px-4 py-3 mb-2 border-1 border-gray-300' id='search-` +
                    item.id +
                    `'>
                    <p class='text-sm font-semibold text-gray-600'>` +
                    item.partNumber +
                    `</p>
                    <i 
                        data-id='` +
                    item.id +
                    `'
                        data-pattern='` +
                    item.pattern +
                    `'
                        data-partNumber='` +
                    item.partNumber +
                    `'
                        class='load_element material-icons add text-blue-600 cursor-pointer rounded-circle hover:bg-gray-200'>cloud_download
                    </i>
                </div>`;
            } else {
                template +=
                    `<div class='w-full flex justify-between items-center shadow-md hover:shadow-lg rounded-md px-4 py-3 mb-2 border-1 border-gray-300' id='search-` +
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
                        class='add_element material-icons add text-green-600 cursor-pointer rounded-circle hover:bg-gray-200'>add_circle_outline
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
};

const clearAll = () => {
    form._method = "POST";
    form.pattern_id = null;
    form.name = null;
    form.price = null;
    form.status_id = null;
    form.car_id = [];
    form.values = [];
};

// A function to load data a good to the relation box
function load(e) {
    const pattern = e.target.getAttribute("data-pattern");
    if (!form.pattern_id) {
        form.pattern_id = pattern;
        axios
            .post(route("relations.load"), {
                pattern,
            })
            .then(function (response) {
                push_data(response.data);
                form._method = "PUT";
            })
            .catch(function (error) {
                console.log(error);
            });
        load_pattern_ifo(form.pattern_id);
    } else {
        alert(
            "You can't load two relation at once (clear all to load new relation)"
        );
    }
}

const push_data = (data) => {
    for (const item of data) {
        remove(item.id);
        form.values.push({ id: item.id, partNumber: item.partNumber });
    }
};

const load_pattern_ifo = (id) => {
    axios
        .post(route("relations.pattern"), {
            id,
        })
        .then(function (response) {
            form.name = response.data.pattern.name;
            form.price = response.data.pattern.price;
            form.car_id = response.data.cars;
            form.status_id = response.data.pattern.status_id;
        })
        .catch(function (error) {
            console.log(error);
        });
};

// A function to remove added goods from relation box
function remove(id) {
    const item = document.getElementById("search-" + id);
    if (item) {
        item.remove();
    }
}

const createRelation = () => {
    form.post(route(url), {
        preserveScroll: true,
        onSuccess: (response) => {
            console.log(response);
            clearAll();
        },
    });
};
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

                <FormRelation @submitted="createRelation">
                    <template #form>
                        <!-- Name -->
                        <div class="pb-2">
                            <InputLabel for="name" value="Name" />
                            <TextInput id="name" v-model="form.name" type="text" class="mt-1 block w-full"
                                autocomplete="name" />
                            <InputError :message="form.errors.name" class="mt-2" />
                        </div>
                        <div class="pb-2">
                            <InputLabel for="price" value="Price" />
                            <TextInput id="price" v-model="form.price" type="text" class="mt-1 block w-full"
                                autocomplete="price" />
                            <InputError :message="form.errors.price" class="mt-2" />
                        </div>
                        <div class="pb-2">
                                <InputLabel for="cars" value="Car" />
                                <select type="cars" multiple
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    autocomplete="username" v-model="form.car_id" id="cars">
                                    <option v-for="item in cars" :value="item.id" class="text-sm">
                                        {{ item.name }}
                                    </option>
                                </select>
                                <InputError :message="form.errors.car_id" class="mt-2" />
                            </div>
                        <div class="pb-2">
                            <InputLabel for="status" value="Status" />
                            <select type="status"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                autocomplete="username" v-model="form.status_id" id="status">
                                <option v-for="item in status" :value="item.id" class="text-sm">
                                    {{ item.name }}
                                </option>
                            </select>
                            <InputError :message="form.errors.status_id" class="mt-2" />
                        </div>
                        <!-- <div class="container">
                            <select multiple data-multi-select-plugin autocomplete="username" v-model="form.car_id"
                                id="cars">
                                <option v-for="item in cars" :value="item.id" class="text-sm"
                                    :selected="form.car_id != null && form.car_id.includes(item.id)">
                                    {{ item.name }}
                                </option>
                            </select>
                        </div>
                         -->
                        <InputError :message="form.errors.values" class="mt-2" />
                    </template>

                    <template #actions>
                        <ActionMessage :on="form.recentlySuccessful" class="mr-3">
                            Saved.
                        </ActionMessage>

                        <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Save
                        </PrimaryButton>
                    </template>
                </FormRelation>
            </div>
        </div>
    </AppLayout>
</template>
