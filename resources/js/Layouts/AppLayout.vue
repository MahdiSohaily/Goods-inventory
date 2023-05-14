<script setup>
import { Head, router } from "@inertiajs/vue3";
import Banner from "@/Components/Banner.vue";
import NavLink from "@/Components/NavLink.vue";

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
            <nav id="nav" ref="nav" class="main-nav bg-white shadow-lg flex flex-col justify-between">
                <i id="close" @click="toggleNav()"
                    class="material-icons absolute m-3 right-0 hover:cursor-pointer">close</i>
                <ul class="flex flex-col pt-5">
                    <NavLink :href="route('dashboard')" :active="route().current('dashboard')">
                        Search
                    </NavLink>
                    <NavLink :href="route('goods')" :active="route().current('goods')">
                        Goods
                    </NavLink>
                    <NavLink :href="route('rates')" :active="route().current('rates')">
                        Rates
                    </NavLink>
                    <NavLink :href="route('relations')" :active="route().current('relations')">
                        Relations
                    </NavLink>
                    <NavLink :href="route('profile.show')" :active="route().current('profile')">
                        Profile
                    </NavLink>
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
                    <i class="p-2 material-icons hover:cursor-pointer fixed" @click="toggleNav">menu</i>
                </div>
                <slot />
            </main>
        </div>
    </div>
</template>
