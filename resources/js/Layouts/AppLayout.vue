<script setup>
import { Head, router } from "@inertiajs/vue3";
import Banner from "@/Components/Banner.vue";

defineProps({
    title: String,
});

const toggleNav = () => {
    const nav = document.getElementById("nav");
    if (nav.classList.contains("open")) {
        nav.classList.remove("open");
    } else {
        nav.classList.add("open");
    }
};

const logout = () => {
    router.post(route("logout"));
};
</script>

<template>
    <div>
        <Head :title="title" />

        <Banner />

        <div class="min-h-screen bg-gray-100">
            <nav
                id="nav"
                ref="nav"
                class="main-nav bg-white shadow-lg flex flex-col justify-between"
            >
                <i
                    id="close"
                    @click="toggleNav()"
                    class="material-icons absolute m-3 right-0 hover:cursor-pointer"
                    >close</i
                >
                <ul class="flex flex-col pt-5">
                    <li class="hover:bg-gray-100 flex">
                        <i class="pl-6 py-3 material-icons">search</i>
                        <a
                            class="pl-1 py-3 block"
                            :href="route('dashboard')"
                        >
                            Search
                        </a>
                    </li>
                    <li class="hover:bg-gray-100 flex">
                        <i class="pl-6 py-3 material-icons">local_mall</i>
                        <a
                            class="pl-1 py-3 block"
                            :href="route('goods')"
                        >
                            Goods
                        </a>
                    </li>
                    <li class="hover:bg-gray-100 flex">
                        <i class="pl-6 py-3 material-icons">insert_chart</i>

                        <a
                            class="pl-1 py-3 block"
                            :href="route('rates')"
                        >
                            Rates
                        </a>
                    </li>
                    <li class="hover:bg-gray-100 flex">
                        <i class="pl-6 py-3 material-icons">person</i>
                        <a
                            class="pl-1 py-3 block"
                            :href="route('profile.show')"
                        >
                            Profile
                        </a>
                    </li>
                </ul>
                <!-- Authentication -->
                <form @submit.prevent="logout">
                    <button type="submit" class="pl-6 py-3 hover:bg-gray-300 w-full flex justify-start">
                        <i class="material-icons mr-1">settings_power</i>
                        Log Out
                    </button>
                </form>
            </nav>
            <!-- Page Content -->
            <main>
                <div class="flex justify-between">
                    <i
                        class="p-2 material-icons hover:cursor-pointer fixed"
                        @click="toggleNav"
                        >menu</i
                    >
                </div>
                <slot />
            </main>
        </div>
    </div>
</template>
