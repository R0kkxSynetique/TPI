<script setup>
import { Link, router, usePage } from '@inertiajs/vue3';
import MenuIcon from '../Components/icons/MenuIcon.vue';
import RightArrowIcon from '../Components/icons/RightArrowIcon.vue';
import LogoutIcon from '../Components/icons/LogoutIcon.vue';
import {Battery0Icon, Squares2X2Icon, Cog6ToothIcon} from '@heroicons/vue/20/solid';

const user = usePage().props.auth.user;

document.body.classList.remove('overflow-hidden');

function openMenu() {
    var sideMenu = document.getElementById('side-menu');
    var background = document.getElementById('menu-background');

    sideMenu.classList.remove('left-[-70%]');
    sideMenu.classList.add('left-0');
    background.classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
}

function closeMenu() {
    var sideMenu = document.getElementById('side-menu');
    var background = document.getElementById('menu-background');

    sideMenu.classList.remove('left-0');
    sideMenu.classList.add('left-[-70%]');
    background.classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
}

const logout = () => {
    router.post('/logout');
};

defineProps({
    menuIconClass: {
        type: String,
        default: 'text-white',
    },
});
</script>

<template>
    <button class="p-2" @click="openMenu()">
        <MenuIcon :class="menuIconClass" />
    </button>
    <div
        @click="closeMenu()"
        id="menu-background"
        class="fixed top-0 left-0 hidden w-full h-full bg-black opacity-30"></div>
    <div id="side-menu" class="fixed w-[70%] bg-white left-[-70%] top-0 h-full rounded-r-xl">
        <nav class="flex flex-col flex-grow w-full h-full text-sm text-app">
            <div class="flex items-center justify-center w-full gap-2 mt-14">
                <div class="w-12 h-12">
                    <img
                        :src="`/image/user/${user.id}`"
                        class="object-cover w-20 overflow-hidden rounded-full aspect-square" />
                </div>
                <div class="text-sm text-black">
                    <p class="">
                        <b>{{ user.firstname }}</b>
                    </p>
                    <p class="text-gray-500">@{{ user.username }}</p>
                </div>
            </div>
            <div class="flex flex-col mt-5 grow">
                <div class="grow">
                    <Link
                        class="flex items-center w-full hover:bg-slate-100"
                        :class="{ 'bg-slate-200': route().current('rc-models.*') }"
                        href="/">
                        <div class="flex items-center justify-center gap-2 py-3 ml-10">
                            <Squares2X2Icon class="h-5" />
                            <p>Mes modèles</p>
                        </div>
                        <div class="px-5 ml-auto">
                            <RightArrowIcon />
                        </div>
                    </Link>
                    <Link
                        class="flex items-center w-full hover:bg-slate-100"
                        :class="{ 'bg-slate-200': route().current('batteries.*') }"
                        href="/batteries">
                        <div class="flex items-center justify-center gap-2 py-3 ml-10">
                            <Battery0Icon class="h-5" />
                            <p>Mes batteries</p>
                        </div>
                        <div class="px-5 ml-auto">
                            <RightArrowIcon />
                        </div>
                    </Link>
                    <Link
                        class="flex items-center w-full hover:bg-slate-100"
                        :class="{ 'bg-slate-200': route().current('user.settings.*') }"
                        href="/user/settings">
                        <div class="flex items-center justify-center gap-2 py-3 ml-10">
                            <Cog6ToothIcon class="h-5" />
                            <p>Mes paramètres</p>
                        </div>
                        <div class="px-5 ml-auto">
                            <RightArrowIcon />
                        </div>
                    </Link>
                </div>
                <form method="post" @submit.prevent="logout" class="flex justify-center w-full">
                    <button
                        class="flex items-center w-full p-4 mx-5 mb-5 text-xl duration-200 border-2 transition-color hover:text-white justify-evenly rounded-3xl border-Error text-Error hover:bg-Error">
                        <div>
                            <p><b>Déconnexion</b></p>
                        </div>
                        <div>
                            <LogoutIcon />
                        </div>
                    </button>
                </form>
            </div>
        </nav>
    </div>
</template>
