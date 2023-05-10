<script setup>
import axios from "axios";

defineProps({
    rates: Object,
});

let result = null;

const search = (val, rates) => {
    let pattern = val;
    let superMode = 0;
    const resultBox = document.getElementById("results");

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

        resultBox.innerHTML = `<img class='w-5 h-auto' src='/img/google.png' alt='google'>`;
        axios
            .post("/search", {
                pattern,
                superMode,
            })
            .then(function (response) {
                resultBox.innerHTML = print(response.data, rates);
            })
            .catch(function (error) {
                console.log(error);
            });
    } else {
        // resultBox.innerHTML = "";
    }
};

const print = (data, rates) => {
    let template = "";
    if (data) {
        for (let item of data[0]) {
            const id = item.id;
            const partNumber = item.partnumber;
            let price = item.price;
            const avgPrice = Math.round((price * 110) / 243.5);
            const weight = Math.round(item.weight, 2);
            const mobis = item.mobis;
            let status;

            if (mobis == "0.00") {
                status = "NO-Price";
            } else if (mobis == "-") {
                status = "NO-Mobis";
            } else if (mobis == null) {
                status = "Request";
            } else {
                status = "YES-Mobis";
            }

            template += `<tr class="transition duration-300 ease-in-out hover:bg-neutral-200">
                <td class='whitespace-nowrap bg-blue-900'>
                <div class='flex gap-1 text-white font-bold px-4'>`;
            if (status == "Request") {
                template +=
                    ` <a class='link-s Request' target='_blank' href='` +
                    partNumber +
                    `'>?</a>`;
            } else if (status == "NO-Price") {
                template +=
                    ` <a class='link-s NO-Price' target='_blank' href='` +
                    partNumber +
                    `'>!</a>`;
            } else if (status == `NO-Mobis`) {
                template +=
                    ` <a class='link-s NO-Mobis' target='_blank' href='` +
                    partNumber +
                    `'>x</a>`;
            } else {
                template += `<span class='spacer'></span>`;
            }

            template +=
                partNumber +
                `</div></td>
                <td class='whitespace-nowrap text-center px-3 py-3'>` +
                Math.round(avgPrice * 1.1) +
                `</td>
                <td class='orange whitespace-nowrap px-3 py-3' >` +
                Math.round(avgPrice * 1.2) +
                `</td>`;

            template += normalRate(avgPrice, rates);

            template +=
                `
                <td class='whitespace-nowrap w-24'>
                    <div class='flex justify-center gap-1 items-center px-2'>
                    <a target='_blank' href='https://www.google.com/search?tbm=isch&q=` +
                partNumber +
                `'>
                        <img class='w-5 h-auto' src='/img/google.png' alt='google'>
                    </a>
                    <a msg='` +
                partNumber +
                `'>
                        <img class='w-5 h-auto' src='/img/tel.png' alt='part'>
                    </a>
                    <a target='_blank' href='https://partsouq.com/en/search/all?q=` +
                partNumber +
                `'>
                        <img class='w-5 h-auto' src='/img/part.png' alt='part'>
                    </a>
                </div>
                </td>
                <td class='whitespace-nowrap px-3 py-3 kg'>
                    <div class='weight'>` +
                weight +
                ` KG</div>
                </td>
            </tr> `;

            if (status == "YES-Mobis") {
                price = mobis;
                price = price.replace(",", "");
                template +=
                    `<tr class='mobis'>
                <td class='part text-white left'> ` +
                    partNumber +
                    `-M</td>
                <td class='bold'>` +
                    Math.round(avgPrice) +
                    `</td>
                <td>` +
                    Math.round(avgPrice * 1.1) +
                    `</td>`;
                template += mobisRate(avgPrice, rates);
                template += `
                <td></td>
                <td></td>
                </tr>`;
            }
        }
        return template;
    }
};

const normalRate = (avg, rates) => {
    let result = "";

    for (let rate of rates) {
        result +=
            `
            <td class='whitespace-nowrap px-3 py-3 ` +
            rate.status +
            `' > ` +
            Math.round(avg * rate.amount * 1.2 * 1.2 * 1.3) +
            `</td>`;
    }

    return result;
};

const mobisRate = (avg, rates) => {
    let result = "";

    for (let rate of rates) {
        result +=
            `
        <td class='whitespace-nowrap px-3 py-3` +
            rate.status +
            `' > ` +
            Math.round(avg * rate.amount * 1.25 * 1.3) +
            `</td>`;
    }

    return result;
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
                @keyup="search($event.target.value, rates)"
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
                                class="px-3 py-3 bg-black text-white w-72 text-center"
                            >
                                شماره فنی
                            </th>
                            <th scope="col" class="px-3 py-3 text-white w-32">
                                دلار پایه
                            </th>
                            <th
                                scope="col"
                                class="px-3 py-3 text-white border-black border-r-2"
                            >
                                +10%
                            </th>

                            <!-- START TO Loop over the existing rates at database -->
                            <th
                                v-for="item in rates"
                                :class="item.status"
                                scope="col"
                                class="px-3 py-3 text-white text-center"
                            >
                                {{ item.amount }}
                            </th>
                            <!-- END the loop -->

                            <th
                                scope="col"
                                class="px-3 py-3 text-white w-52 text-center"
                            >
                                عملیات
                            </th>
                            <th scope="col" class="px-3 py-3 text-white">
                                وزن
                            </th>
                        </tr>
                    </thead>
                    <tbody id="results">
                        <div v-if="result">{{ result }}</div>
                        <tr
                            class="transition duration-300 ease-in-out hover:bg-neutral-200"
                        >
                            <td class="whitespace-nowrap px-3 py-3 font-bold">
                                1
                            </td>
                            <td class="whitespace-nowrap px-3 py-3">Mark</td>
                            <td class="whitespace-nowrap px-3 py-3">Otto</td>
                            <td class="whitespace-nowrap px-3 py-3">@mdo</td>
                            <td class="whitespace-nowrap px-3 py-3 font-medium">
                                1
                            </td>
                            <td class="whitespace-nowrap px-3 py-3">Mark</td>
                            <td class="whitespace-nowrap px-3 py-3">Otto</td>
                            <td class="whitespace-nowrap px-3 py-3">@mdo</td>
                            <td class="whitespace-nowrap px-3 py-3 font-medium">
                                1
                            </td>
                            <td class="whitespace-nowrap px-3 py-3">Mark</td>
                            <td class="whitespace-nowrap px-3 py-3">Otto</td>
                            <td class="whitespace-nowrap px-3 py-3">@mdo</td>
                            <td class="whitespace-nowrap px-3 py-3 font-medium">
                                1
                            </td>
                            <td class="whitespace-nowrap px-3 py-3">Mark</td>
                        </tr>
                        <tr
                            class="transition duration-300 ease-in-out hover:bg-neutral-200"
                        >
                            <td class="whitespace-nowrap px-3 py-3 font-medium">
                                1
                            </td>
                            <td class="whitespace-nowrap px-3 py-3">Mark</td>
                            <td class="whitespace-nowrap px-3 py-3">Otto</td>
                            <td class="whitespace-nowrap px-3 py-3">@mdo</td>
                            <td class="whitespace-nowrap px-3 py-3 font-medium">
                                1
                            </td>
                            <td class="whitespace-nowrap px-3 py-3">Mark</td>
                            <td class="whitespace-nowrap px-3 py-3">Otto</td>
                            <td class="whitespace-nowrap px-3 py-3">@mdo</td>
                            <td class="whitespace-nowrap px-3 py-3 font-medium">
                                1
                            </td>
                            <td class="whitespace-nowrap px-3 py-3">Mark</td>
                            <td class="whitespace-nowrap px-3 py-3">Otto</td>
                            <td class="whitespace-nowrap px-3 py-3">@mdo</td>
                            <td class="whitespace-nowrap px-3 py-3 font-medium">
                                1
                            </td>
                            <td class="whitespace-nowrap px-3 py-3">Mark</td>
                        </tr>
                        <tr
                            class="transition duration-300 ease-in-out hover:bg-neutral-200"
                        >
                            <td class="whitespace-nowrap px-3 py-3 font-medium">
                                1
                            </td>
                            <td class="whitespace-nowrap px-3 py-3">Mark</td>
                            <td class="whitespace-nowrap px-3 py-3">Otto</td>
                            <td class="whitespace-nowrap px-3 py-3">@mdo</td>
                            <td class="whitespace-nowrap px-3 py-3 font-medium">
                                1
                            </td>
                            <td class="whitespace-nowrap px-3 py-3">Mark</td>
                            <td class="whitespace-nowrap px-3 py-3">Otto</td>
                            <td class="whitespace-nowrap px-3 py-3">@mdo</td>
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
