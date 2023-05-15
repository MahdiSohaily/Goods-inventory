<script setup>
import { computed, useSlots } from 'vue';

defineEmits(['submitted']);

const hasActions = computed(() => !!useSlots().actions);
</script>

<template>
    <div class="">
        <form @submit.prevent="$emit('submitted')">
            <div class="px-4 py-5"
                :class="hasActions ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md'">
                <div class="">
                    <slot name="form" />
                </div>
            </div>

            <div v-if="hasActions"
                class="flex items-center justify-end px-4 py-3 text-right sm:px-6 sm:rounded-bl-md sm:rounded-br-md">
                <slot name="actions" />
            </div>
        </form>
    </div>
</template>
