<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import Button from '@/Components/Button.vue';
import SideBarMenu from '@/Components/SideBarMenu.vue';
import PlusIcon from '@/Components/icons/PlusIcon.vue';
import MoreIcon from '@/Components/icons/MoreIcon.vue';
import TransmitterIcon from '@/Components/icons/TransmitterIcon.vue';
import BatteryIcon from '@/Components/icons/BatteryIcon.vue';
import GasIcon from '@/Components/icons/GasIcon.vue';
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue';

const user = usePage().props.auth.user;

defineProps({
    rcModels: Object,
});
</script>

<template>
    <Head title="Accueil" />

    <div class="relative min-w-full min-h-screen">
        <div
            class="h-[14rem] rounded-b-[4rem] bg-gradient-to-br from-gradientfrom to-gradientto text-white text-2xl">
            <div class="relative z-50 flex justify-between w-full px-8 pt-8">
                <SideBarMenu />

                <div class="w-12 h-12">
                    <img
                        :src="`/image/user/${user.id}`"
                        class="object-cover w-20 overflow-hidden rounded-full aspect-square" />
                </div>
            </div>
            <div class="flex items-center justify-between">
                <h1 class="pt-10 pl-12">Bonjour,<br />{{ user.username }}</h1>

                <Link
                    v-if="rcModels.length > 0"
                    href="/rc-models/create"
                    class="flex items-center gap-2 mt-10 mr-8">
                    <PlusIcon />
                    <p>Créer</p>
                </Link>
            </div>
        </div>
        <div v-if="rcModels.length <= 0">
            <div class="flex items-center justify-center mt-5">
                <p>Vous n'avez pas encore de modèles.<br />Créez-en un en cliquant ci-dessous</p>
            </div>

            <div class="flex items-center justify-center mt-5">
                <Link href="/rc-models/create">
                    <Button>
                        <PlusIcon />
                        <p>Céer</p>
                    </Button>
                </Link>
            </div>
        </div>
        <div v-for="rcModel in rcModels" class="py-10 px-5 mx-2 shadow-lg h-[14rem] rounded-[3rem] last:mb-4">
            <div class="flex justify-between py-2">
                <Link as="h1" :href="'/rc-models/' + rcModel.id" class="max-w-full text-xl truncate text-app">{{
                    rcModel.name
                }}</Link>
            </div>
            <Link as="div" :href="'/rc-models/' + rcModel.id" class="flex justify-between">
                <div class="aspect-square w-32 rounded-[2rem] overflow-hidden">
                    <img
                        :src="`/image/rcModel/${rcModel.id}`"
                        :alt="rcModel.name"
                        class="object-cover w-full h-full" />
                </div>
                <div class="flex flex-col justify-evenly">
                    <div class="flex items-center [&>*]:mx-1">
                        <TransmitterIcon />
                        <p>
                            {{ rcModel.transmitter.manufacturer + ' ' + rcModel.transmitter.name }}
                        </p>
                    </div>
                    <div class="flex items-center [&>*]:mx-1" v-if="rcModel.batteries.length > 0">
                        <BatteryIcon />
                        <div class="flex flex-col items-center justify-between">
                            <p v-for="battery in rcModel.batteries">
                                {{ battery.pivot.quantity }} x {{ battery.capacity }}
                                {{ battery.cells }}s
                            </p>
                        </div>
                    </div>
                    <div>
                        <div v-for="engine in rcModel.engines" class="flex items-center [&>*]:mx-1">
                            <GasIcon />
                            <p>{{ engine.type }}</p>
                        </div>
                    </div>
                </div>
            </Link>
        </div>
    </div>
</template>
