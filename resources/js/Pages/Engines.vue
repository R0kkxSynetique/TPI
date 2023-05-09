<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import Button from '@/Components/Button.vue';
import SideBarMenu from '@/Components/SideBarMenu.vue';
import TransmitterIcon from '@/Components/icons/TransmitterIcon.vue';
import { PlusCircleIcon, BoltIcon, ArrowPathIcon } from '@heroicons/vue/20/solid';
import GasIcon from '../Components/icons/GasIcon.vue';
import { computed } from 'vue';
import { useToast } from 'vue-toastification';

const user = usePage().props.auth.user;
const toast = useToast();

defineProps({
    engines: Object,
});

const message = computed(() => usePage().props.flash.message).value;
const type = computed(() => usePage().props.flash.type).value;

if (message){
    switch (type) {
        case 'success':
            toast.success(message);
            break;
        case 'error':
            toast.error(message);
            break;
        default:
            toast(message);
    }
}

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
                <h1 class="pt-10 pl-12">Mes<br/>moteurs</h1>

                <Link
                    v-if="engines.length > 0"
                    href="/engines/create"
                    class="flex items-center justify-center gap-2 mt-10 mr-8">
                    <PlusCircleIcon class="w-6 fill-white" />
                    <p>Créer</p>
                </Link>
            </div>
        </div>
        <div v-if="engines.length <= 0">
            <div class="flex items-center justify-center mt-5">
                <p>Vous n'avez pas encore de moteurs.<br />Créez-en un en cliquant ci-dessous</p>
            </div>

            <div class="flex items-center justify-center mt-5">
                <Link href="/engines/create">
                    <Button>
                        <PlusCircleIcon class="w-6 fill-white" />
                        <p>Céer</p>
                    </Button>
                </Link>
            </div>
        </div>
        <div v-for="engine in engines" class="py-10 px-5 shadow-lg h-56 rounded-[3rem] mx-2">
            <div class="flex justify-between py-2">
                <Link as="h1" :href="'/engines/' + engine.id" class="max-w-full text-xl truncate text-app">{{
                    engine.name
                }}</Link>
            </div>
            <Link as="div" :href="'/engines/' + engine.id" class="flex justify-between">
                <div class="aspect-square w-32 rounded-[2rem] overflow-hidden">
                    <img
                        :src="`/image/engine/${engine.id}`"
                        :alt="engine.name"
                        class="object-cover w-full h-full" />
                </div>
                <div class="flex flex-col justify-evenly">
                    <div class="flex items-center [&>*]:mx-1">
                        <BoltIcon class="w-5 fill-app" />
                        <p>
                            {{ engine.power }}
                        </p>
                    </div>
                    <div class="flex items-center [&>*]:mx-1">
                        <GasIcon class="w-5 fill-app" />
                        <p>
                            {{ engine.type }}
                        </p>
                    </div>
                    <div class="flex items-center [&>*]:mx-1">
                        <ArrowPathIcon class="w-5 fill-app" />
                        <p>
                            {{ engine.frequency }}
                        </p>
                    </div>
                </div>
            </Link>
        </div>
    </div>
</template>
