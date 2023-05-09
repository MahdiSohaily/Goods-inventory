<script setup>
import axios from "axios";

defineProps({
    rates: Object,
});

const search = (val) => {
    let pattern = val;
    let superMode = 0;
    const resultBox = document.getElementById("s-result");

    if (document.getElementById("mode").checked) {
        superMode = 1;
    }

    if (
        (pattern.length > 4 && superMode == 1) ||
        (pattern.length > 6 && superMode == 0)
    ) {
        pattern = pattern.replace(/\s/g, "");
        pattern = pattern.replace(/-/g, "");
        pattern = pattern.replace(/_/g, "");
        axios
            .post("/search", {
                pattern,
                superMode,
            })
            .then(function (response) {
                console.log(response.data);
            })
            .catch(function (error) {
                console.log(error);
            });
    } else {
        // resultBox.innerHTML = "";
    }
};
</script>

<template>
    <div>
        <div class="p-6 lg:p-8 flex justify-center">
            <input
                type="text"
                name="serial"
                id="serial"
                class="rounded-md py-3 text-center w-96 border-2 bg-gray-100"
                min="0"
                max="30"
                @keyup="search($event.target.value)"
                placeholder="... کد فنی قطعه را وارد کنید"
            />
        </div>
        <div class="flex justify-center items-center pb-6">
            <input type="checkbox" name="super" id="mode" class="rounded-md" />
            <label for="mode" class="ml-1">Super Mode</label>
        </div>
        <div class="bg-gray-100 bg-opacity-25">
            <div class="max-w-7xl overflow-x-auto mx-auto">
                <table class="min-w-full text-left text-sm font-light">
                    <thead class="font-medium dark:border-neutral-500">
                        <tr class="bg-green-700">
                            <th
                                scope="col"
                                class="px-6 py-3 bg-black text-white w-72 text-center"
                            >
                                شماره فنی
                            </th>
                            <th scope="col" class="px-6 py-3 text-white w-32">
                                دلار پایه
                            </th>
                            <th
                                scope="col"
                                class="px-6 py-3 text-white border-black border-r-2"
                            >
                                +10%
                            </th>
                            <th
                                v-for="item in rates"
                                :class="item.status"
                                scope="col"
                                class="px-6 py-3 text-white"
                            >
                                {{ item.amount }}
                            </th>
                            <th scope="col" class="px-6 py-3 text-white">
                                عملیات
                            </th>
                            <th scope="col" class="px-6 py-3 text-white">kg</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            class="transition duration-300 ease-in-out hover:bg-neutral-200"
                        >
                            <td class="whitespace-nowrap px-6 py-3 font-medium">
                                1
                            </td>
                            <td class="whitespace-nowrap px-6 py-3">Mark</td>
                            <td class="whitespace-nowrap px-6 py-3">Otto</td>
                            <td class="whitespace-nowrap px-6 py-3">@mdo</td>
                            <td class="whitespace-nowrap px-6 py-3 font-medium">
                                1
                            </td>
                            <td class="whitespace-nowrap px-6 py-3">Mark</td>
                            <td class="whitespace-nowrap px-6 py-3">Otto</td>
                            <td class="whitespace-nowrap px-6 py-3">@mdo</td>
                            <td class="whitespace-nowrap px-6 py-3 font-medium">
                                1
                            </td>
                            <td class="whitespace-nowrap px-6 py-3">Mark</td>
                            <td class="whitespace-nowrap px-6 py-3">Otto</td>
                            <td class="whitespace-nowrap px-6 py-3">@mdo</td>
                            <td class="whitespace-nowrap px-6 py-3 font-medium">
                                1
                            </td>
                            <td class="whitespace-nowrap px-6 py-3">Mark</td>
                        </tr>
                        <tr
                            class="transition duration-300 ease-in-out hover:bg-neutral-200"
                        >
                            <td class="whitespace-nowrap px-6 py-3 font-medium">
                                1
                            </td>
                            <td class="whitespace-nowrap px-6 py-3">Mark</td>
                            <td class="whitespace-nowrap px-6 py-3">Otto</td>
                            <td class="whitespace-nowrap px-6 py-3">@mdo</td>
                            <td class="whitespace-nowrap px-6 py-3 font-medium">
                                1
                            </td>
                            <td class="whitespace-nowrap px-6 py-3">Mark</td>
                            <td class="whitespace-nowrap px-6 py-3">Otto</td>
                            <td class="whitespace-nowrap px-6 py-3">@mdo</td>
                            <td class="whitespace-nowrap px-6 py-3 font-medium">
                                1
                            </td>
                            <td class="whitespace-nowrap px-6 py-3">Mark</td>
                            <td class="whitespace-nowrap px-6 py-3">Otto</td>
                            <td class="whitespace-nowrap px-6 py-3">@mdo</td>
                            <td class="whitespace-nowrap px-6 py-3 font-medium">
                                1
                            </td>
                            <td class="whitespace-nowrap px-6 py-3">Mark</td>
                        </tr>
                        <tr
                            class="transition duration-300 ease-in-out hover:bg-neutral-200"
                        >
                            <td class="whitespace-nowrap px-6 py-3 font-medium">
                                1
                            </td>
                            <td class="whitespace-nowrap px-6 py-3">Mark</td>
                            <td class="whitespace-nowrap px-6 py-3">Otto</td>
                            <td class="whitespace-nowrap px-6 py-3">@mdo</td>
                            <td class="whitespace-nowrap px-6 py-3 font-medium">
                                1
                            </td>
                            <td class="whitespace-nowrap px-6 py-3">Mark</td>
                            <td class="whitespace-nowrap px-6 py-3">Otto</td>
                            <td class="whitespace-nowrap px-6 py-3">@mdo</td>
                            <td class="whitespace-nowrap px-6 py-3 font-medium">
                                1
                            </td>
                            <td class="whitespace-nowrap px-6 py-3">Mark</td>
                            <td class="whitespace-nowrap px-6 py-3">Otto</td>
                            <td class="whitespace-nowrap px-6 py-3">@mdo</td>
                            <td class="whitespace-nowrap px-6 py-3 font-medium">
                                1
                            </td>
                            <td class="whitespace-nowrap px-6 py-3">Mark</td>
                        </tr>
                        <tr
                            class="transition duration-300 ease-in-out hover:bg-neutral-200"
                        >
                            <td class="whitespace-nowrap px-6 py-4 font-medium">
                                1
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">Mark</td>
                            <td class="whitespace-nowrap px-6 py-4">Otto</td>
                            <td class="whitespace-nowrap px-6 py-4">@mdo</td>
                            <td class="whitespace-nowrap px-6 py-4 font-medium">
                                1
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">Mark</td>
                            <td class="whitespace-nowrap px-6 py-4">Otto</td>
                            <td class="whitespace-nowrap px-6 py-4">@mdo</td>
                            <td class="whitespace-nowrap px-6 py-4 font-medium">
                                1
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">Mark</td>
                            <td class="whitespace-nowrap px-6 py-4">Otto</td>
                            <td class="whitespace-nowrap px-6 py-4">@mdo</td>
                            <td class="whitespace-nowrap px-6 py-4 font-medium">
                                1
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">Mark</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
