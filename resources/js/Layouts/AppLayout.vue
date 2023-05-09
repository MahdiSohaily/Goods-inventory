<script setup>
import { Head, router } from "@inertiajs/vue3";
import Banner from "@/Components/Banner.vue";
import DropdownLink from "@/Components/DropdownLink.vue";

defineProps({
    title: String,
});


const toggleNav = () => {
    alert("clicked");
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
                class="main-nav bg-white shadow-lg flex flex-col justify-between"
            >
                <ul class="flex flex-col">
                    <li class="hover:bg-gray-100 flex">
                        <i class="pl-6 py-3 material-icons">search</i>
                        <a
                            class="pl-1 py-3 block"
                            :href="route('dashboard')"
                            :active="route().current('dashboard')"
                        >
                            Search
                        </a>
                    </li>
                    <li class="hover:bg-gray-100 flex">
                        <i class="pl-6 py-3 material-icons">local_mall</i>
                        <a
                            class="pl-1 py-3 block"
                            :href="route('goods')"
                            :active="route().current('goods')"
                        >
                            Goods
                        </a>
                    </li>
                    <li class="hover:bg-gray-100 flex">
                        <i class="pl-6 py-3 material-icons">insert_chart</i>

                        <a
                            class="pl-1 py-3 block"
                            :href="route('rates')"
                            :active="route().current('rates')"
                        >
                            Rates
                        </a>
                    </li>
                    <li class="hover:bg-gray-100 flex">
                        <i class="pl-6 py-3 material-icons">person</i>
                        <a
                            class="pl-1 py-3 block"
                            :href="route('profile.show')"
                            :active="route().current('profile.show')"
                        >
                            Profile
                        </a>
                    </li>
                </ul>
                <!-- Authentication -->
                <form @submit.prevent="logout">
                    <DropdownLink class="py-3 block" as="button">
                        Log Out
                    </DropdownLink>
                </form>
            </nav>
            <!-- Page Content -->
            <main>
                <div class="flex justify-between">
                    <i
                        class="p-2 material-icons hover:cursor-pointer"
                        @click="toggleNav"
                        >menu</i
                    >
                </div>
                <slot />
            </main>
        </div>
    </div>
</template>
