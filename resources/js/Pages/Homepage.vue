<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import Button from '@/Components/Button.vue';
import PlusIcon from '@/Components/icons/PlusIcon.vue';
import TransmitterIcon from '@/Components/icons/TransmitterIcon.vue';
import BatteryIcon from '@/Components/icons/BatteryIcon.vue';
import GasIcon from '@/Components/icons/GasIcon.vue';
import { computed } from 'vue';
import { useToast } from 'vue-toastification';
import PageHeader from '@/Components/PageHeader.vue';
import AddLink from '@/Components/AddLink.vue';

const user = usePage().props.auth.user;
const toast = useToast();

defineProps({
    rcModels: Object,
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
                ><p>Bonjour,<br />{{ user.username }}</p>
            </template>
            <template #button>
                <AddLink v-if="rcModels.length > 0" href="/rc-models/create">
                    <template #button-text>Créer</template>
                </AddLink>
            </template>
        </PageHeader>
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
        <div class="grid grid-cols-1 mb-4 md:grid-cols-3">
            <div
                v-for="rcModel in rcModels"
                class="py-10 px-5 mx-2 shadow-lg h-56 md:h-full md:py-5 rounded-[3rem]">
                <div class="flex justify-between py-2">
                    <Link
                        as="h1"
                        :href="'/rc-models/' + rcModel.id"
                        class="max-w-full text-xl truncate md:text-4xl text-app"
                        >{{ rcModel.name }}</Link
                    >
                </div>
                <Link as="div" :href="'/rc-models/' + rcModel.id" class="flex justify-between">
                    <div
                        class="aspect-square w-32 md:w-72 rounded-[2rem] md:rounded-[4rem] overflow-hidden">
                        <img
                            :src="`/image/rcModel/${rcModel.id}`"
                            :alt="rcModel.name"
                            class="object-cover w-full h-full" />
                    </div>
                    <div
                        class="flex flex-col justify-evenly md:[&>div>p]:text-3xl md:[&>div>div>p]:text-3xl">
                        <div class="flex items-center [&>*]:mx-1">
                            <TransmitterIcon class="w-7 md:w-10" />
                            <p>
                                {{
                                    rcModel.transmitter.manufacturer +
                                    ' ' +
                                    rcModel.transmitter.name
                                }}
                            </p>
                        </div>
                        <div
                            class="flex items-center [&>*]:mx-1"
                            v-if="rcModel.batteries.length > 0">
                            <BatteryIcon class="w-7 md:w-10" />
                            <div class="flex flex-col items-center justify-between">
                                <p v-for="battery in rcModel.batteries">
                                    {{ battery.pivot.quantity }} x {{ battery.capacity }}
                                    {{ battery.cells }}s
                                </p>
                            </div>
                        </div>
                        <div v-for="engine in rcModel.engines">
                            <div v-if="engine.fuel" class="flex items-center [&>*]:mx-1">
                                <GasIcon class="w-7 md:w-10" />
                                <p>{{ engine.fuel }}</p>
                            </div>
                        </div>
                    </div>
                </Link>
            </div>
        </div>
    </div>
</template>
