<script setup>
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
</script>

<template>
    <div>
        <div class="p-6 lg:p-8 flex justify-center">
            <input type="text" name="serial" id="serial" class="rounded-md py-3 text-center w-96 border-2 bg-gray-100"
                min="0" max="30" onkeyup="search(this.value)" placeholder="... کد فنی قطعه را وارد کنید" />
        </div>

        <div class="bg-gray-100 bg-opacity-25">
            <div class="max-w-7xl overflow-x-auto mx-auto">
                <table class="min-w-full text-left text-sm font-light">
                    <thead class="font-medium dark:border-neutral-500">
                        <tr class="bg-green-700">
                            <th scope="col" class="px-6 py-3 bg-black text-white w-72 text-center">شماره فنی</th>
                            <th scope="col" class="px-6 py-3 text-white w-32">دلار پایه</th>
                            <th scope="col" class="px-6 py-3 text-white border-black border-r-2">+10%</th>
                            <th scope="col" class="px-6 py-3 text-white">50</th>
                            <th scope="col" class="px-6 py-3 text-white">51</th>
                            <th scope="col" class="px-6 py-3 text-white">52</th>
                            <th scope="col" class="px-6 py-3 text-white">53</th>
                            <th scope="col" class="px-6 py-3 text-white">54</th>
                            <th scope="col" class="px-6 py-3 text-white">55</th>
                            <th scope="col" class="px-6 py-3 text-white">56</th>
                            <th scope="col" class="px-6 py-3 text-white">57</th>
                            <th scope="col" class="px-6 py-3 text-white">60</th>
                            <th scope="col" class="px-6 py-3 text-white">عملیات</th>
                            <th scope="col" class="px-6 py-3 text-white">kg</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            class=" transition duration-300 ease-in-out hover:bg-neutral-200">
                            <td class="whitespace-nowrap px-6 py-3 font-medium">1</td>
                            <td class="whitespace-nowrap px-6 py-3">Mark</td>
                            <td class="whitespace-nowrap px-6 py-3">Otto</td>
                            <td class="whitespace-nowrap px-6 py-3">@mdo</td>
                            <td class="whitespace-nowrap px-6 py-3 font-medium">1</td>
                            <td class="whitespace-nowrap px-6 py-3">Mark</td>
                            <td class="whitespace-nowrap px-6 py-3">Otto</td>
                            <td class="whitespace-nowrap px-6 py-3">@mdo</td>
                            <td class="whitespace-nowrap px-6 py-3 font-medium">1</td>
                            <td class="whitespace-nowrap px-6 py-3">Mark</td>
                            <td class="whitespace-nowrap px-6 py-3">Otto</td>
                            <td class="whitespace-nowrap px-6 py-3">@mdo</td>
                            <td class="whitespace-nowrap px-6 py-3 font-medium">1</td>
                            <td class="whitespace-nowrap px-6 py-3">Mark</td>
                        </tr>
                        <tr
                            class=" transition duration-300 ease-in-out hover:bg-neutral-200">
                            <td class="whitespace-nowrap px-6 py-3 font-medium">1</td>
                            <td class="whitespace-nowrap px-6 py-3">Mark</td>
                            <td class="whitespace-nowrap px-6 py-3">Otto</td>
                            <td class="whitespace-nowrap px-6 py-3">@mdo</td>
                            <td class="whitespace-nowrap px-6 py-3 font-medium">1</td>
                            <td class="whitespace-nowrap px-6 py-3">Mark</td>
                            <td class="whitespace-nowrap px-6 py-3">Otto</td>
                            <td class="whitespace-nowrap px-6 py-3">@mdo</td>
                            <td class="whitespace-nowrap px-6 py-3 font-medium">1</td>
                            <td class="whitespace-nowrap px-6 py-3">Mark</td>
                            <td class="whitespace-nowrap px-6 py-3">Otto</td>
                            <td class="whitespace-nowrap px-6 py-3">@mdo</td>
                            <td class="whitespace-nowrap px-6 py-3 font-medium">1</td>
                            <td class="whitespace-nowrap px-6 py-3">Mark</td>
                        </tr>
                        <tr
                            class=" transition duration-300 ease-in-out hover:bg-neutral-200">
                            <td class="whitespace-nowrap px-6 py-3 font-medium">1</td>
                            <td class="whitespace-nowrap px-6 py-3">Mark</td>
                            <td class="whitespace-nowrap px-6 py-3">Otto</td>
                            <td class="whitespace-nowrap px-6 py-3">@mdo</td>
                            <td class="whitespace-nowrap px-6 py-3 font-medium">1</td>
                            <td class="whitespace-nowrap px-6 py-3">Mark</td>
                            <td class="whitespace-nowrap px-6 py-3">Otto</td>
                            <td class="whitespace-nowrap px-6 py-3">@mdo</td>
                            <td class="whitespace-nowrap px-6 py-3 font-medium">1</td>
                            <td class="whitespace-nowrap px-6 py-3">Mark</td>
                            <td class="whitespace-nowrap px-6 py-3">Otto</td>
                            <td class="whitespace-nowrap px-6 py-3">@mdo</td>
                            <td class="whitespace-nowrap px-6 py-3 font-medium">1</td>
                            <td class="whitespace-nowrap px-6 py-3">Mark</td>
                        </tr>
                        <tr
                            class=" transition duration-300 ease-in-out hover:bg-neutral-200">
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
