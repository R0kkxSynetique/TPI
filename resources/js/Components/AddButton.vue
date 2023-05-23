<script setup>
import { PlusCircleIcon } from '@heroicons/vue/20/solid';
</script>
<template>
    <button
        class="flex items-center gap-2 mt-10 mr-8">
        <PlusCircleIcon class="w-5 md:w-10" />
        <p class="md:text-4xl">
            <slot name="button-text"></slot>
        </p>
    </button>
</template>
