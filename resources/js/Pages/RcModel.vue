<script setup>
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import MoreIcon from '@/Components/icons/MoreIcon.vue';
import SideBarMenu from '@/Components/SideBarMenu.vue';
import {
    Menu,
    MenuButton,
    MenuItem,
    MenuItems,
    Dialog,
    DialogPanel,
    DialogTitle,
    TransitionChild,
    TransitionRoot,
} from '@headlessui/vue';
import moment from 'moment';
import { ref, computed, onMounted } from 'vue';
import { useToast } from 'vue-toastification';
import print from 'print-js';
import JoinAM from '@/Components/JoinAM.vue';

const message = computed(() => usePage().props.flash.message).value;
const type = computed(() => usePage().props.flash.type).value;

const openDelete = ref(false);

const toast = useToast();

const props = defineProps({
    rcModel: Object,
    flights: Object,
    guest: Boolean,
});

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

function joinAmToast() {
    if (props.guest){
        toast.info(JoinAM, {
            position: 'top-right',
            timeout: false,
            closeOnClick: false,
            pauseOnFocusLoss: true,
            pauseOnHover: false,
            draggable: true,
            draggablePercent: 0.6,
            showCloseButtonOnHover: false,
            hideProgressBar: false,
            closeButton: 'button',
            icon: true,
            rtl: false,
            id: 'join-am',
        });
    }
}

onMounted(() => {
    requestAnimationFrame(() => {
        joinAmToast()
    });
});

function destroy(id) {
    if (id) {
        router.delete('/rc-models/' + id);
    } else {
        toast.error('Une erreur est survenue lors de la suppression de votre modèle.');
    }
}

function printQr() {
    printJS('/qr-code/' + props.rcModel.id, 'image');
}
</script>
<template>
    <Head :title="rcModel.name ? rcModel.name : 'Modèle réduit'"></Head>

    <div
        class="h-[14rem] rounded-b-[4rem] bg-gradient-to-br from-gradientfrom to-gradientto text-white text-2xl w-full">
        <div>
            <div class="flex items-center justify-between px-8 pt-8">
                <SideBarMenu v-if="!props.guest" />
                <Menu as="div" class="relative inline-block text-left" v-if="!props.guest">
                    <div>
                        <MenuButton class="p-3">
                            <MoreIcon />
                        </MenuButton>
                    </div>

                    <transition
                        enter-active-class="transition duration-100 ease-out"
                        enter-from-class="transform scale-95 opacity-0"
                        enter-to-class="transform scale-100 opacity-100"
                        leave-active-class="transition duration-75 ease-in"
                        leave-from-class="transform scale-100 opacity-100"
                        leave-to-class="transform scale-95 opacity-0">
                        <MenuItems
                            class="absolute right-0 z-10 mt-2 origin-top-right bg-white rounded-md shadow-lg w-fit">
                            <div class="py-1 [&>*]:text-center">
                                <MenuItem v-slot="{ active }">
                                    <Link
                                        :href="'/rc-models/' + rcModel.id + '/edit'"
                                        :class="[
                                            active ? 'bg-gray-100 text-gray-900' : 'text-gray-700',
                                            'block px-4 py-2 text-sm',
                                        ]"
                                        >Modifier</Link
                                    >
                                </MenuItem>
                                <MenuItem v-slot="{ active }">
                                    <button
                                        @click="openDelete = true"
                                        :class="[
                                            active ? 'bg-gray-100 text-gray-900' : 'text-gray-700',
                                            'block px-4 py-2 text-sm',
                                        ]">
                                        Supprimer
                                    </button>
                                </MenuItem>
                                <MenuItem v-slot="{ active }">
                                    <button
                                        @click="printQr()"
                                        :class="[
                                            active ? 'bg-gray-100 text-gray-900' : 'text-gray-700',
                                            'block px-4 py-2 text-sm',
                                        ]">
                                        Imprimer QR
                                    </button>
                                </MenuItem>
                            </div>
                        </MenuItems>
                    </transition>
                </Menu>
            </div>
            <div class="flex items-center justify-center w-full -mt-6">
                <img
                    class="aspect-square w-40 rounded-[2rem] overflow-hidden object-cover"
                    :src="`/image/rcModel/${rcModel.id}`"
                    :alt="rcModel.name" />
            </div>
        </div>
    </div>
    <div>
        <TransitionRoot as="template" :show="openDelete">
            <Dialog as="div" class="relative z-10" @close="openDelete = false">
                <TransitionChild
                    as="template"
                    enter="ease-out duration-300"
                    enter-from="opacity-0"
                    enter-to="opacity-100"
                    leave="ease-in duration-200"
                    leave-from="opacity-100"
                    leave-to="opacity-0">
                    <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" />
                </TransitionChild>

                <div class="fixed inset-0 z-10 overflow-y-auto">
                    <div class="flex items-center justify-center min-h-full p-2 text-center">
                        <TransitionChild
                            as="template"
                            enter="ease-out duration-300"
                            enter-from="opacity-0 translate-y-0 scale-95"
                            enter-to="opacity-100 translate-y-0 scale-100"
                            leave="ease-in duration-200"
                            leave-from="opacity-100 translate-y-0 scale-100"
                            leave-to="opacity-0 translate-y-0 scale-95">
                            <DialogPanel
                                class="relative w-full text-left transition-all transform bg-white shadow-xl xl:max-w-2xl">
                                <div class="p-6 px-4 pt-5 pb-4 bg-white">
                                    <div>
                                        <div class="mt-0 text-center">
                                            <DialogTitle
                                                as="h3"
                                                class="text-base font-semibold leading-6 text-gray-900">
                                                Êtes-vous sûr de vouloir supprimer ce modèle ?
                                            </DialogTitle>
                                            <div class="w-full mt-2 text-sm">
                                                Cette action est
                                                <strong>irréversible</strong>.<br />
                                                Une fois confirmé, votre modèle sera supprimé de
                                                votre liste et ne pourra plus être consulté ni
                                                modifié.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="px-4 py-3 bg-gray-50 sm:flex sm:flex-row-reverse sm:px-6">
                                    <button
                                        type="button"
                                        class="inline-flex justify-center w-full px-3 py-2 text-sm font-semibold text-white rounded-md shadow-sm bg-Error hover:bg-red-600 sm:ml-3 sm:w-auto"
                                        @click="destroy(rcModel.id)">
                                        Supprimer
                                    </button>
                                    <button
                                        type="button"
                                        class="inline-flex justify-center w-full px-3 py-2 mt-3 text-sm font-semibold text-gray-900 bg-white rounded-md shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto"
                                        @click="openDelete = false">
                                        Annuler
                                    </button>
                                </div>
                            </DialogPanel>
                        </TransitionChild>
                    </div>
                </div>
            </Dialog>
        </TransitionRoot>
    </div>
    <div class="mx-5 mt-3 [&>div>h1]:text-xl [&>div>h1]:text-app [&>div]:pt-4 pb-5">
        <div>
            <h1 class="max-w-full break-words">
                {{ rcModel.name }}
            </h1>
            <p class="max-w-full break-words">
                <i v-if="rcModel.manufacturer">
                    {{ rcModel.manufacturer }}
                </i>
            </p>
        </div>
        <div v-if="rcModel.description">
            <h1>Descritpion</h1>
            <p class="max-w-full break-words">
                {{ rcModel.description }}
            </p>
        </div>
        <div>
            <h1>Caractéristiques</h1>
            <p>
                Envergure:
                {{ rcModel.wingSpan ? rcModel.wingSpan + ' mm' : '-' }}
            </p>
            <p>
                Poids:
                {{ rcModel.weight ? rcModel.weight / 1000 + ' Kg' : '-' }}
            </p>
            <p>
                Longueur:
                {{ rcModel.length ? rcModel.length + ' mm' : '-' }}
            </p>
            <p>
                Hauteur:
                {{ rcModel.height ? rcModel.height + ' mm' : '-' }}
            </p>
            <div v-if="rcModel.engines.length > 0">
                <div v-if="rcModel.engines.length > 1">
                    <p>Moteurs:</p>
                    <!-- //todo: Do it as one line with a coma to separate the engines -->
                    <p v-for="engine in rcModel.engines">
                        {{
                            engine.pivot.quantity + 'x ' + engine.name + ' ' + (engine.power || '')
                        }}
                    </p>
                </div>
                <div v-else-if="rcModel.engines[0].pivot.quantity > 1">
                    <p>
                        Moteurs:
                        {{
                            rcModel.engines[0].pivot.quantity +
                            'x ' +
                            rcModel.engines[0].name +
                            ' ' +
                            (rcModel.engines[0].power || '')
                        }}
                    </p>
                </div>
                <div v-else>
                    <p>
                        Moteur:
                        {{ rcModel.engines[0].name + ' ' + (rcModel.engines[0].power || '') }}
                    </p>
                </div>
                <div v-if="rcModel.engines[0].type">
                    <p>
                        Type:
                        {{ rcModel.engines[0].type }}
                    </p>
                    <!-- //todo: select the type based on all the engines -->
                </div>
            </div>
            <div v-if="rcModel.propellers.length > 0">
                <div v-if="rcModel.propellers.length > 1">
                    <p>Helices:</p>
                    <p v-for="propeller in rcModel.propellers">
                        {{
                            propeller.pivot.quantity +
                            'x "' +
                            propeller.size +
                            '" ' +
                            propeller.type
                        }}
                    </p>
                </div>
                <div v-else-if="rcModel.propellers[0].pivot.quantity > 1">
                    <p>
                        Hélices:
                        {{
                            rcModel.propellers[0].pivot.quantity +
                            'x "' +
                            rcModel.propellers[0].size +
                            '" ' +
                            rcModel.propellers[0].type
                        }}
                    </p>
                </div>
                <div v-else>
                    <p>
                        Hélice:
                        {{ rcModel.propellers[0].size + ' ' + rcModel.propellers[0].type }}
                    </p>
                </div>
            </div>
            <div v-if="rcModel.batteries.length > 0">
                <div v-if="rcModel.batteries.length > 1">
                    <p>Batteries:</p>
                    <div v-for="battery in rcModel.batteries">
                        <p>
                            {{
                                battery.pivot.quantity +
                                'x ' +
                                battery.capacity +
                                'mAh ' +
                                battery.type
                            }}
                        </p>
                    </div>
                </div>
                <div v-else-if="rcModel.batteries[0].pivot.quantity > 1">
                    <p>
                        Batteries:
                        {{
                            rcModel.batteries[0].pivot.quantity +
                            'x ' +
                            rcModel.batteries[0].capacity +
                            'mAh ' +
                            rcModel.batteries[0].type
                        }}
                    </p>
                </div>
                <div v-else>
                    <p>
                        Batterie:
                        {{ rcModel.batteries[0].capacity + 'mAh ' + rcModel.batteries[0].type }}
                    </p>
                </div>
            </div>
        </div>
        <div v-if="rcModel.acquired_on || rcModel.finished_on || rcModel.first_flown_on">
            <h1>Historique</h1>
            <p v-if="rcModel.acquired_on">
                Acquis le :
                {{ moment(rcModel.acquired_on).format('DD.MM.yyyy') }}
            </p>
            <p v-if="rcModel.finished_on">
                Fini le:
                {{ moment(rcModel.finished_on).format('DD.MM.yyyy') }}
            </p>
            <p v-if="rcModel.first_flown_on">
                Mis en service le:
                {{ moment(rcModel.first_flown_on).format('DD.MM.yyyy') }}
            </p>
        </div>
        <div v-if="rcModel.transmitter">
            <h1>Radiocommande</h1>
            <p>
                {{ rcModel.transmitter.manufacturer + ' ' + rcModel.transmitter.name }}
            </p>
        </div>
        <div>
            <h1>Vols</h1>
            <p>
                Nombre de vols:
                {{ flights.quantity }}
            </p>
        </div>
    </div>
</template>
