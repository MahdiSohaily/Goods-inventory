<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";

defineProps({
    status: Object,
    cars: Object,
});

let result = null;

const search = (val, rates) => {
    let pattern = val;
    let superMode = 0;
    const resultBox = document.getElementById("search_result");

    if (
        (pattern.length > 4 && superMode == 1) ||
        (pattern.length > 6 && superMode == 0)
    ) {
        pattern = pattern.replace(/\s/g, "");
        pattern = pattern.replace(/-/g, "");
        pattern = pattern.replace(/_/g, "");

        resultBox.innerHTML = `<tr class=''>
                <div class='w-full h-96 flex justify-center items-center'> 
                    <img class=' block w-10 mx-auto h-auto' src='/img/loading.png' alt='google'>
                    </div>
            </tr>`;
        axios
            .post("/search", {
                pattern,
                superMode,
            })
            .then(function (response) {
                // resultBox.innerHTML = print(response.data);
            })
            .catch(function (error) {
                console.log(error);
            });
    } else {
        resultBox.innerHTML = "";
    }
};
</script>

<template>
    <AppLayout title="Profile">
        <div
            class="h-70S grid grid-cols-1 my-8 md:grid-cols-3 gap-6 lg:gap-8 p-6 lg:p-8"
        >
            <div class="bg-white rounded-md shadow-md p-3">
                <div class="">
                    <h2
                        class="ml-3 text-xl font-semibold text-gray-800 flex items-center gap-2"
                    >
                        <i class="material-icons text-blue-500">save</i>
                        Register Relation
                    </h2>
                </div>

                <p class="mt-4 text-gray-500 text-sm leading-relaxed">
                    Laravel has wonderful documentation covering every aspect of
                    the framework. Whether you're new to the framework or have
                    previous experience, we recommend reading all of the
                    documentation from beginning to end.
                </p>

                <p class="mt-4 text-sm">
                    <a
                        href="https://laravel.com/docs"
                        class="inline-flex items-center font-semibold text-indigo-700"
                    >
                        Explore the documentation

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                            class="ml-1 w-5 h-5 fill-indigo-500"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M5 10a.75.75 0 01.75-.75h6.638L10.23 7.29a.75.75 0 111.04-1.08l3.5 3.25a.75.75 0 010 1.08l-3.5 3.25a.75.75 0 11-1.04-1.08l2.158-1.96H5.75A.75.75 0 015 10z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </a>
                </p>
            </div>

            <div class="bg-white rounded-md shadow-md p-3">
                <div class="flex items-center justify-between">
                    <h2
                        class="ml-3 text-xl font-semibold text-gray-800 flex items-center gap-2"
                    >
                        <i class="material-icons text-green-600">beenhere</i>
                        Selected Items
                    </h2>
                    <button
                        class="border-none bg-red-500 hover:bg-red-600 text-white rounded-lg px-4 py-2 text-sm"
                    >
                        Clear All
                    </button>
                </div>

                <p class="mt-4 text-gray-500 text-sm leading-relaxed">
                    Laracasts offers thousands of video tutorials on Laravel,
                    PHP, and JavaScript development. Check them out, see for
                    yourself, and massively level up your development skills in
                    the process.
                </p>

                <p class="mt-4 text-sm">
                    <a
                        href="https://laracasts.com"
                        class="inline-flex items-center font-semibold text-indigo-700"
                    >
                        Start watching Laracasts

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                            class="ml-1 w-5 h-5 fill-indigo-500"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M5 10a.75.75 0 01.75-.75h6.638L10.23 7.29a.75.75 0 111.04-1.08l3.5 3.25a.75.75 0 010 1.08l-3.5 3.25a.75.75 0 11-1.04-1.08l2.158-1.96H5.75A.75.75 0 015 10z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </a>
                </p>
            </div>

            <div class="bg-white rounded-md shadow-md p-3">
                <div class="flex items-center justify-between">
                    <h2
                        class="ml-3 text-xl font-semibold text-gray-800 flex items-center gap-2"
                    >
                        <i class="material-icons text-orange-400">search</i>
                        Search Goods
                    </h2>
                </div>

                <div class="flex justify-center py-3">
                    <input
                        type="text"
                        name="serial"
                        id="serial"
                        class="rounded-md py-2 w-full border-1 text-sm border-gray-500 focus:outline-none text-gray-500"
                        min="0"
                        max="30"
                        @keyup="search($event.target.value, rates)"
                        placeholder="Part Number ..."
                    />
                </div>
                <div id="search_result">
                    <!-- Search Results are going to be appended here -->
                </div>
            </div>
        </div>
    </AppLayout>
</template>
