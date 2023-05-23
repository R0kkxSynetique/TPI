<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import Button from '@/Components/Button.vue';
import { PlusCircleIcon, BoltIcon, ArrowPathIcon } from '@heroicons/vue/20/solid';
import GasIcon from '../Components/icons/GasIcon.vue';
import { computed } from 'vue';
import { useToast } from 'vue-toastification';
import PageHeader from '../Components/PageHeader.vue';
import AddLink from '../Components/AddLink.vue';

const toast = useToast();

defineProps({
    engines: Object,
});

const message = computed(() => usePage().props.flash.message).value;
const type = computed(() => usePage().props.flash.type).value;

if (message) {
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
        <PageHeader>
            <template #title
                ><p>Mes<br />moteurs</p>
            </template>
            <template #button>
                <AddLink v-if="engines.length > 0" href="/engines/create">
                    <template #button-text>Créer</template>
                </AddLink>
            </template>
        </PageHeader>
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
        <div class="grid grid-cols-1 gap-3 md:grid-cols-3">
            <div
                v-for="engine in engines"
                class="py-10 px-5 mx-2 shadow-lg h-56 md:h-full md:py-5 rounded-[3rem]">
                <div class="flex justify-between py-2">
                    <span as="h1" class="max-w-full text-xl truncate md:text-4xl text-app">{{
                        engine.name
                    }}</span>
                </div>
                <div class="grid justify-between grid-cols-2 md:gap-5">
                    <div
                        class="aspect-square w-32 md:w-72 rounded-[2rem] md:rounded-[4rem] overflow-hidden">
                        <img
                            :src="`/image/engine/${engine.id}`"
                            :alt="engine.name"
                            class="object-cover w-full h-full" />
                    </div>
                    <div
                        class="flex flex-col justify-evenly md:[&>div>p]:text-3xl md:[&>div>div>p]:text-3xl">
                        <div v-if="engine.power" class="flex items-center [&>*]:mx-1">
                            <BoltIcon class="w-5 fill-app md:w-10" />
                            <p>
                                {{ engine.power + 'cc' }}
                            </p>
                        </div>
                        <div v-if="engine.fuel" class="flex items-center [&>*]:mx-1">
                            <GasIcon class="w-5 mx-0 fill-app md:w-10" />
                            <p class="flex-1 truncate">
                                {{ engine.fuel }}
                            </p>
                        </div>
                        <div v-if="engine.frequency" class="flex items-center [&>*]:mx-1">
                            <ArrowPathIcon class="w-5 fill-app md:w-10" />
                            <p class="flex-1 truncate">
                                {{ engine.frequency }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
