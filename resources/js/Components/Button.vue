<script setup>
import ButtonBackground from "./BackGrounds/ButtonBackground.vue";
import PlusIcon from "./icons/PlusIcon.vue";
</script>

<template>
    <button
        class="py-5 px-10 overflow-hidden flex gap-4 relative bg-gradient-to-br from-gradientfrom to-gradientto rounded-[1.2rem] text-white"
    >
        <ButtonBackground />
        <slot></slot>
    </button>
</template>
