<script setup>
import { usePage } from '@inertiajs/vue3';
import SideBarMenu from '@/Components/SideBarMenu.vue';

const user = usePage().props.auth.user;
</script>

<template>
    <div
        class="h-[14rem] rounded-b-[4rem] bg-gradient-to-br from-gradientfrom to-gradientto text-white text-2xl">
        <div class="relative z-50 flex justify-between w-full px-8 pt-8">
            <SideBarMenu />
            <div class="w-12 h-12 md:w-24">
                <img
                    :src="`/image/user/${user.id}`"
                    class="object-cover w-20 overflow-hidden rounded-full aspect-square" />
            </div>
        </div>
        <div class="flex items-center justify-between">
            <h1 class="pt-10 pl-12 md:text-4xl">
                <slot name="title"></slot>
            </h1>
            <slot name="button"></slot>
        </div>
    </div>
</template>
