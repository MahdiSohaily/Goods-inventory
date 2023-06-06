<script setup>
import { useForm } from "@inertiajs/vue3";
import ActionMessage from "@/Components/ActionMessage.vue";
import FormRelation from "@/Components/FormRelation.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";

const selected_rates = [50, 51, 52, 55];

const form = useForm({
    _method: "POST",
    customer: props.customer,
    partnumber: null,
    price: null,
    code: props.completeCode,
});

const changeVal = (value) => {
    form.price = value;
};

const savePrice = (pattern) => {
    form.partnumber = pattern;
    form.post(route("price.store"), {
        errorBag: "savePrice",
        preserveScroll: true,
        onSuccess: () => { },
    });
};

const arrangeTime = (dateTime) => {
    const now = new Date();
    const create = new Date(dateTime);
    const diff = now - create;

    var msec = diff;
    var dd = Math.floor(msec / 1000 / 60 / 60 / 24);
    msec -= dd * 1000 * 60 * 60 * 24;
    var hh = Math.floor(msec / 1000 / 60 / 60);
    msec -= hh * 1000 * 60 * 60;

    var mm = Math.floor(msec / 1000 / 60);
    msec -= mm * 1000 * 60;

    var ss = Math.floor(msec / 1000);
    msec -= ss * 1000;

    let text = "";

    if (dd) {
        dd > 1 ? (text += `${dd} days and `) : (text += `${dd} day and `);
    }

    if (hh) {
        hh > 1 ? (text += `${hh} hours `) : (text += `${hh} hour `);
    }

    if (!hh && mm) {
        mm > 1 ? (text += `${mm} minutes `) : (text += `${mm} minute `);
    }

    if (!mm && !hh) {
        ss > 1 ? (text += `${ss} seconds `) : (text += `1 second `);
    }

    return `${text} ago`;
};
</script>

<template>
    <div class="bg-white rounded-lg shadow-md col-span-2">
        <div id="search_result" class="p-3">
            <table class="min-w-full text-left text-sm font-light">
                <thead>
                    <tr>
                        <th>
                            <span class="px-4 text-gray-600">part NA</span>
                            <span class="px-4 text-gray-600">Price</span>
                            <span class="px-4 text-gray-600">Client</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <div class="min-w-full mb-1 border-2 border-gray-400" v-if="item.result.ordered_price.price != null">
                        <div class="min-w-full bg-red-400">
                            <td scope="col" class="px-3 text-white py-2 break-words">
                                Ordered Price
                            </td>
                            <td colspan="2" scope="col" class="px-3 text-white py-2 break-words">
                                {{ item.result.ordered_price.price }}
                            </td>
                        </div>
                    </div>
                    <div class="min-w-full mb-1 border-2 border-gray-400" v-for="price in item.result.prices">
                        <div class="min-w-full bg-indigo-100">
                            <td scope="col" class="px-3 text-gray-800 py-1 break-words">
                                {{ price.partnumber }}
                            </td>
                            <td scope="col" class="px-3 text-gray-800 py-1 break-words">
                                {{ price.price }}
                            </td>
                            <td scope="col" class="px-3 text-gray-800 py-1">
                                {{ price.name }}
                            </td>
                        </div>
                        <div class="min-w-full bg-orange-100 py-1">
                            <td colspan="3" scope="col" class="px-3 text-gray-800">
                                {{ arrangeTime(price.created_at) }}
                            </td>
                        </div>
                    </div>
                </tbody>
            </table>
            <FormRelation @submitted="savePrice(item.result.pattern)">
                <template #form>
                    <!-- Name -->
                    <div class="pb-2">
                        <InputLabel for="price" value="Price" />
                        <TextInput id="price" @keyup="
                            (e) => {
                                changeVal(e.target.value);
                            }
                        " type="text" class="mt-1 block w-full" autocomplete="price" />
                        <InputError :message="form.errors.price" class="mt-2" />
                    </div>
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
</template>
