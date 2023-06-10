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
            <table class="rtl min-w-full text-right text-sm font-light">
                <thead>
                    <tr class="min-w-full bg-green-600">
                        <td class="text-gray-600 bold py-2 pr-2">قیمت</td>
                        <td class="text-gray-600 bold py-2 pr-2">شماره فنی</td>
                        <td class="text-gray-600 bold py-2 pr-2">مشتری</td>
                    </tr>
                </thead>
                <tbody>
                    <template v-for="price in givenPrice">
                        <tr class="min-w-full mb-1 bg-indigo-200">

                            <td scope="col" class="text-gray-800 pr-2 py-1">
                                {{ price.price }}
                            </td>
                            <td scope="col" class="text-gray-800 pr-2 py-1">
                                {{ price.partnumber }}
                            </td>
                            <td scope="col" class="text-gray-800 pr-2 py-1">
                                {{ price.name }}
                            </td>
                        </tr>
                        <tr class="min-w-full mb-4 bg-orange-100">
                            <td colspan="3" scope="col" class="text-gray-800 pr-2 tiny-text">
                                {{ arrangeTime(price.created_at) }}
                            </td>
                        </tr>
                    </template>

                </tbody>
            </table>
            <FormRelation @submitted="savePrice(item.result.pattern)">
                <template #form>
                    <div class="pb-2">
                        <InputLabel for="price" value="قیمت" />
                        <TextInput id="price" v-model="form.price" type="text" class="mt-1 block w-full"
                            autocomplete="price" />
                        <InputError :message="form.errors.price" class="mt-2" />
                    </div>
                </template>

                <template #actions>
                    <ActionMessage :on="form.recentlySuccessful" class="mr-3">
                        عملیات موفقانه صورت گرفت.
                    </ActionMessage>

                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        ثبت
                    </PrimaryButton>
                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        ارسال به نیایش
                    </PrimaryButton>
                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        !!!نداریم
                    </PrimaryButton>
                </template>
            </FormRelation>
        </div>
    </div>
</template>
