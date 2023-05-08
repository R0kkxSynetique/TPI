<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import SideBarMenu from '@/Components/SideBarMenu.vue';
import { TagIcon, Battery100Icon, CircleStackIcon, BoltIcon, PlusIcon } from '@heroicons/vue/20/solid';
import Button from '@/Components/Button.vue';

const user = usePage().props.auth.user;

const props = defineProps({
    batteries: Object,
});
</script>

<template>
    <Head title="Accueil" />

    <div class="relative min-w-full min-h-screen">
        <div
            class="h-36 rounded-b-[4rem] bg-gradient-to-br from-gradientfrom to-gradientto text-white text-2xl">
            <div class="relative z-50 flex justify-between w-full px-8 pt-8">
                <SideBarMenu />
                <div class="w-12 h-12">
                    <img
                        :src="`/image/user/${user.id}`"
                        class="object-cover w-20 overflow-hidden rounded-full aspect-square" />
                </div>
            </div>
        </div>
        <div v-if="batteries.length <= 0">
            <div class="flex items-center justify-center mt-5">
                <p>Vous n'avez pas encore de batteries.<br />Créez-en une en cliquant ci-dessous</p>
            </div>

            <div class="flex items-center justify-center mt-5">
                <Link href="/rc-models/create">
                    <Button>
                        <PlusIcon class="w-5 fill-white" />
                        <p>Céer</p>
                    </Button>
                </Link>
            </div>
        </div>
        <div class="grid max-h-full grid-cols-2 xl:grid-cols-8">
            <div v-for="battery in batteries" class="mx-2 shadow-lg rounded-[3rem] py-5">
                <div class="flex justify-center [&>div]:px-2">
                    <div class="flex flex-col justify-center text-center">
                        <TagIcon class="w-5 fill-app" />
                        <Battery100Icon class="w-5 fill-app"/>
                        <CircleStackIcon class="w-5 fill-app"/>
                        <BoltIcon class="w-5 fill-app"/>
                    </div>
                    <div class="flex flex-col justify-center text-left">
                        <p>{{ battery.type }}</p>
                        <p>{{ battery.capacity }} mAh</p>
                        <p>{{ battery.cells }}s</p>
                        <p>{{ battery.cRate }}C</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
