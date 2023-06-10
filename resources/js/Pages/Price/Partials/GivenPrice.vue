<script setup>
import { useForm } from "@inertiajs/vue3";
import ActionMessage from "@/Components/ActionMessage.vue";
import FormRelation from "@/Components/FormRelation.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import arrangeTime from "../services/timeline.js";

const props = defineProps({
    givenPrice: Array,
});

const form = useForm({
    _method: "POST",
    customer: props.customer,
    partnumber: props.partNumber,
    completeCode: props.completeCode,
    price: null,
});

const savePrice = (pattern) => {
    form.partnumber = pattern;
    form.post(route("price.store"), {
        errorBag: "savePrice",
        preserveScroll: true,
        onSuccess: () => { },
    });
};

</script>

<template>
    <div class="bg-white rounded-lg shadow-md col-span-2">
        <div id="search_result" class="p-3">
            <table class="min-w-full text-left text-sm font-light">
                <thead>
                    <tr>
                        <th>
                        <th class="px-4 text-gray-600">قیمت</th>
                        <th class="px-4 text-gray-600">شماره فنی</th>
                        <th class="px-4 text-gray-600">مشتری</th>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <div class="min-w-full mb-1 border-2 border-gray-400" v-for="price in givenPrice">
                        <div class="min-w-full bg-indigo-100">

                            <td scope="col" class="px-3 text-gray-800 py-1 break-words">
                                {{ price.price }}
                            </td>
                            <td scope="col" class="px-3 text-gray-800 py-1 break-words">
                                {{ price.partnumber }}
                            </td>
                            <td scope="col" class="px-3 text-gray-800 py-1">
                                {{ price.name }}
                            </td>
                        </div>
                        <div class="min-w-full bg-orange-100 py-1">
                            <td colspan="3" scope="col" class="rtl px-3 text-gray-800 tiny-text">
                                {{ arrangeTime(price.created_at) }}
                            </td>
                        </div>
                    </div>
                </tbody>
            </table>
            <FormRelation @submitted="savePrice(item.result.pattern)">
                <template #form>
                    <div class="pb-2">
                        <InputLabel for="price" value="Price" />
                        <TextInput id="price" v-model="form.price" type="text" class="mt-1 block w-full"
                            autocomplete="price" />
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
