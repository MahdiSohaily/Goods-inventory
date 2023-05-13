<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import List from "@/Pages/Rates/Partials/List.vue";
import Create from "@/Pages/Rates/Partials/Create.vue";
import SectionBorder from "@/Components/SectionBorder.vue";

defineProps({
    confirmsTwoFactorAuthentication: Boolean,
    sessions: Array,
});
</script>

<template>
    <AppLayout title="Profile">
        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <div v-if="$page.props.jetstream.canUpdateProfileInformation">
                    <Create />

                    <SectionBorder />
                </div>

                <div v-if="$page.props.jetstream.canUpdatePassword">
                    <List class="mt-10 sm:mt-0" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
