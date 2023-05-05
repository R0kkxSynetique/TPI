<script setup>
import { Head, Link, useForm, router } from '@inertiajs/vue3';
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
import { useTextareaAutosize } from '@vueuse/core';
import CrossIcon from '../Components/icons/CrossIcon.vue';
import { ref } from 'vue';
import {
    CheckIcon,
    ChevronDownIcon,
    ExclamationTriangleIcon,
    PlusIcon,
} from '@heroicons/vue/20/solid';
import Button from '../Components/Button.vue';
import RightArrowIcon from '../Components/icons/RightArrowIcon.vue';
import {
    Listbox,
    ListboxButton,
    ListboxLabel,
    ListboxOption,
    ListboxOptions,
} from '@headlessui/vue';
import { useImagePreview } from '../lib/image';

const props = defineProps({
    rcModel: Object,
    transmitters: Object,
    engines: Object,
    propellers: Object,
    batteries: Object,
});

const fileInput = ref();
const openEngine = ref(false);
const openPropeller = ref(false);
const openBattery = ref(false);
const openDelete = ref(false)

const { preview, updatePreview, clearPreview } = useImagePreview(fileInput);

const { textarea, input } = useTextareaAutosize({ watch: props.rcModel });

const selectedTransmiter = ref(
    props.transmitters.find((transmitter) => transmitter.id == props.rcModel.transmitter_id)
);

const selectedEngine = props.engines['0'];
const selectedPropeller = props.propellers['0'];
const selectedBattery = props.batteries['0'];

function removeEngineFromRcModel(index) {
    if (props.rcModel.engines[index].pivot.quantity > 1) {
        props.rcModel.engines[index].pivot.quantity -= 1;
    } else {
        props.rcModel.engines.splice(index, 1);
    }
}

function removePropellerFromRcModel(index) {
    if (props.rcModel.propellers[index].pivot.quantity > 1) {
        props.rcModel.propellers[index].pivot.quantity -= 1;
    } else {
        props.rcModel.propellers.splice(index, 1);
    }
}

function removeBatteryFromRcModel(index) {
    if (props.rcModel.batteries[index].pivot.quantity > 1) {
        props.rcModel.batteries[index].pivot.quantity -= 1;
    } else {
        props.rcModel.batteries.splice(index, 1);
    }
}

function addEngine(engineId) {
    if (props.rcModel.engines.find((engine) => engine.id === engineId)) {
        props.rcModel.engines.find((engine) => engine.id === engineId).pivot.quantity += 1;
    } else {
        let engine = props.engines.find((engine) => engine.id === engineId);
        let pivot = {
            engine_id: engine.id,
            rc_model_id: props.rcModel.id,
            quantity: 1,
        };
        engine.pivot = pivot;
        props.rcModel.engines.push(engine);
    }
}

function addPropeller(propellerId) {
    if (props.rcModel.propellers.find((propeller) => propeller.id === propellerId)) {
        props.rcModel.propellers.find(
            (propeller) => propeller.id === propellerId
        ).pivot.quantity += 1;
    } else {
        let propeller = props.propellers.find((propeller) => propeller.id === propellerId);
        let pivot = {
            propeller_id: propeller.id,
            rc_model_id: props.rcModel.id,
            quantity: 1,
        };
        propeller.pivot = pivot;
        props.rcModel.propellers.push(propeller);
    }
}

function addBattery(batteryId) {
    if (props.rcModel.batteries.find((battery) => battery.id === batteryId)) {
        props.rcModel.batteries.find((battery) => battery.id === batteryId).pivot.quantity += 1;
    } else {
        let battery = props.batteries.find((battery) => battery.id === batteryId);
        let pivot = {
            battery_id: battery.id,
            rc_model_id: props.rcModel.id,
            quantity: 1,
        };
        battery.pivot = pivot;
        props.rcModel.batteries.push(battery);
    }
}

// const file = useForm({ image: null });

const form = useForm({
    rcModel: null,
    image: '',
    _method: 'put'
});

const submit = () => {
    props.rcModel.transmitter_id = selectedTransmiter.value.id;
    form.rcModel = props.rcModel;
    if (fileInput.value) {
        form.image = fileInput.value.files ? fileInput.value.files[0] : null;
    }
    form.post(`/rc-models/${props.rcModel.id}`);
};

function destroy(id) {
    if (id) {
        router.delete('/rc-models/' + id);
    } else {
        //? implement toasts
        alert('Une erreur est survenue lors de la suppression de votre modèle.');
    }
}

function updateImage(id) {
    if (fileInput.value) {
        file.image = fileInput.value.files ? fileInput.value.files[0] : null;
        file.post('/image/rcModel/' + id);
    }
}
</script>
<template>
    <Head :title="'Edition - ' + rcModel.name"></Head>

    <div
        class="h-[16rem] rounded-b-[4rem] bg-gradient-to-br from-gradientfrom to-gradientto text-white text-2xl w-full">
        <div>
            <div class="flex items-center justify-between px-8 pt-8">
                <SideBarMenu />
                <Menu as="div" class="relative inline-block text-left">
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
                            <div class="py-1">
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
                            </div>
                        </MenuItems>
                    </transition>
                </Menu>
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
                            <div
                                class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" />
                        </TransitionChild>

                        <div class="fixed inset-0 z-10 overflow-y-auto">
                            <div
                                class="flex items-center justify-center min-h-full p-2 text-center">
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
                                                        Êtes-vous sûr de vouloir supprimer ce modèle
                                                        ?
                                                    </DialogTitle>
                                                    <div class="w-full mt-2 text-sm">
                                                        Cette action est
                                                        <strong>irréversible</strong>.<br />
                                                        Une fois confirmé, votre modèle sera
                                                        supprimé de votre liste et ne pourra plus
                                                        être consulté ni modifié.
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
            <div>
                <div class="flex flex-col items-center justify-center w-full -mt-6">
                    <div
                        v-if="preview"
                        class="aspect-square w-40 rounded-[2rem] overflow-hidden bg-center bg-cover"
                        @click="$refs.fileInput.click()"
                        :style="{
                            backgroundImage: `url('${preview}')`,
                        }" />
                    <img
                        v-else
                        class="aspect-square w-40 rounded-[2rem] overflow-hidden object-cover"
                        :src="`/image/rcModel/${rcModel.id}`"
                        :alt="rcModel.name"
                        @click="$refs.fileInput.click()" />
                    <input
                        type="file"
                        ref="fileInput"
                        accept="image/*"
                        @change="updatePreview"
                        class="hidden" />
                    <button @click="updateImage(rcModel.id)">Appliquer</button>
                </div>
            </div>
        </div>
    </div>
    <div class="mx-5 mt-3 [&>div>h1]:text-xl [&>div>h1]:text-app [&>div]:pt-4 pb-5 mb-5">
        <form
            @submit.prevent="submit"
            class="[&>div>h1]:text-xl [&>div>h1]:text-app [&>div>h1]:mt-5">
            <div>
                <h1>Titre</h1>
                <input
                    type="text"
                    v-model="rcModel.name"
                    maxlength="50"
                    placeholder="Mitsubishi A6m zero"
                    class="w-full p-0 py-2 border-t-0 border-l-0 border-r-0 border-b-app focus:ring-0" />
                <input
                    type="text"
                    v-model="rcModel.manufacturer"
                    maxlength="50"
                    placeholder="Constructeur"
                    class="w-full p-0 py-2 border-t-0 border-l-0 border-r-0 border-b-app focus:ring-0" />
            </div>
            <div>
                <h1>Descritpion</h1>
                <textarea
                    type="text"
                    ref="textarea"
                    v-model="rcModel.description"
                    placeholder="Description"
                    maxlength="250"
                    class="w-full p-0 border-t-0 border-l-0 border-r-0 border-b-app focus:ring-0" />
            </div>
            <div>
                <h1>Caractéristiques</h1>
                <div>
                    <p>Envergure:</p>
                    <div class="flex items-center w-full">
                        <input
                            type="number"
                            v-model="rcModel.wingSpan"
                            max="100000"
                            class="w-full p-0 py-2 border-t-0 border-l-0 border-r-0 border-b-app focus:ring-0" />
                        <div class="absolute right-0 px-8 py-5">mm</div>
                    </div>
                </div>
                <div>
                    <p>Poids:</p>
                    <div class="flex items-center w-full">
                        <input
                            type="number"
                            v-model="rcModel.weight"
                            max="1000000"
                            class="w-full p-0 py-2 border-t-0 border-l-0 border-r-0 border-b-app focus:ring-0" />
                        <div class="absolute right-0 px-8 py-5">g</div>
                    </div>
                </div>
                <div>
                    <p>Longueur:</p>
                    <div class="flex items-center w-full">
                        <input
                            type="number"
                            v-model="rcModel.length"
                            max="100000"
                            class="w-full p-0 py-2 border-t-0 border-l-0 border-r-0 border-b-app focus:ring-0" />
                        <div class="absolute right-0 px-8 py-5">mm</div>
                    </div>
                </div>
                <div>
                    <p>Hauteur:</p>
                    <div class="flex items-center w-full">
                        <input
                            type="number"
                            v-model="rcModel.height"
                            max="10000"
                            class="w-full p-0 py-2 border-t-0 border-l-0 border-r-0 border-b-app focus:ring-0" />
                        <div class="absolute right-0 px-8 py-5">mm</div>
                    </div>
                </div>
                <div>
                    <p>Moteurs:</p>
                    <div
                        v-for="(engine, index) in rcModel.engines"
                        class="flex flex-wrap gap-2 my-2">
                        <div
                            class="flex items-center gap-1 px-2 py-1 rounded-full bg-app-secondary w-fit"
                            v-for="n in engine.pivot.quantity">
                            <p class="whitespace-nowrap">
                                {{ engine.name + ' ' + engine.power }}
                            </p>
                            <CrossIcon @click="removeEngineFromRcModel(index)" />
                        </div>
                    </div>
                    <div
                        class="flex items-center gap-1 px-2 py-1 rounded-full bg-app-secondary w-fit hover:cursor-pointer"
                        @click="openEngine = true">
                        <PlusIcon class="w-4" />
                    </div>
                    <div>
                        <TransitionRoot as="template" :show="openEngine">
                            <Dialog as="div" class="relative z-10" @close="openEngine = false">
                                <TransitionChild
                                    as="template"
                                    enter="ease-out duration-300"
                                    enter-from="opacity-0"
                                    enter-to="opacity-100"
                                    leave="ease-in duration-200"
                                    leave-from="opacity-100"
                                    leave-to="opacity-0">
                                    <div
                                        class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" />
                                </TransitionChild>

                                <div class="fixed inset-0 z-10 overflow-y-auto">
                                    <div
                                        class="flex items-center justify-center min-h-full p-2 text-center">
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
                                                                Ajouter un moteur</DialogTitle
                                                            >
                                                            <div class="w-full mt-2">
                                                                <Listbox
                                                                    as="div"
                                                                    v-model="selectedEngine">
                                                                    <div class="relative mt-2">
                                                                        <ListboxButton
                                                                            class="relative w-full rounded-md py-1.5 pl-3 pr-10 text-left text-gray-900 ring-1 ring-app">
                                                                            <span
                                                                                class="flex items-center">
                                                                                <span>{{
                                                                                    selectedEngine.name +
                                                                                    ' ' +
                                                                                    selectedEngine.power
                                                                                }}</span>
                                                                            </span>
                                                                            <span
                                                                                class="absolute inset-y-0 right-0 flex items-center pr-2 ml-3 pointer-events-none">
                                                                                <ChevronDownIcon
                                                                                    class="w-5 h-5 text-gray-400"
                                                                                    aria-hidden="true" />
                                                                            </span>
                                                                        </ListboxButton>

                                                                        <transition
                                                                            leave-active-class="transition duration-100 ease-in"
                                                                            leave-from-class="opacity-100"
                                                                            leave-to-class="opacity-0">
                                                                            <ListboxOptions
                                                                                class="absolute z-10 w-full py-1 mt-1 overflow-auto text-base bg-white rounded-md shadow-lg max-h-56 ring-1 ring-black ring-opacity-5 focus:outline-none">
                                                                                <ListboxOption
                                                                                    v-for="engine in engines"
                                                                                    :key="engine.id"
                                                                                    :value="engine"
                                                                                    v-slot="{
                                                                                        active: active2,
                                                                                        selected:
                                                                                            selectedEngine,
                                                                                    }">
                                                                                    <li
                                                                                        :class="[
                                                                                            active2
                                                                                                ? 'bg-app text-white'
                                                                                                : 'text-gray-900',
                                                                                            'relative cursor-default select-none py-2 pl-3 pr-9',
                                                                                        ]">
                                                                                        <div
                                                                                            class="flex items-center">
                                                                                            <span
                                                                                                :class="[
                                                                                                    selectedEngine
                                                                                                        ? 'font-semibold'
                                                                                                        : 'font-normal',
                                                                                                    'ml-3 block truncate',
                                                                                                ]"
                                                                                                >{{
                                                                                                    engine.name +
                                                                                                    ' ' +
                                                                                                    engine.power
                                                                                                }}</span
                                                                                            >
                                                                                        </div>

                                                                                        <span
                                                                                            v-if="
                                                                                                selectedEngine
                                                                                            "
                                                                                            :class="[
                                                                                                active2
                                                                                                    ? 'text-white'
                                                                                                    : 'text-app',
                                                                                                'absolute inset-y-0 right-0 flex items-center pr-4',
                                                                                            ]">
                                                                                            <CheckIcon
                                                                                                class="w-5 h-5"
                                                                                                aria-hidden="true" />
                                                                                        </span>
                                                                                    </li>
                                                                                </ListboxOption>
                                                                            </ListboxOptions>
                                                                        </transition>
                                                                    </div>
                                                                </Listbox>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div
                                                    class="px-4 py-3 bg-gray-50 sm:flex sm:flex-row-reverse sm:px-6">
                                                    <button
                                                        type="button"
                                                        class="inline-flex justify-center w-full px-3 py-2 text-sm font-semibold text-white rounded-md shadow-sm bg-Valid hover:bg-lime-400 sm:ml-3 sm:w-auto"
                                                        @click="
                                                            addEngine(selectedEngine.id);
                                                            openEngine = false;
                                                        ">
                                                        Ajouter
                                                    </button>
                                                    <button
                                                        type="button"
                                                        class="inline-flex justify-center w-full px-3 py-2 mt-3 text-sm font-semibold text-gray-900 bg-white rounded-md shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto"
                                                        @click="openEngine = false"
                                                        ref="cancelButtonRef">
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
                </div>
                <div>
                    <p>Hélices:</p>
                    <div
                        v-for="(propeller, index) in rcModel.propellers"
                        class="flex flex-wrap gap-2 my-2">
                        <div
                            class="flex items-center gap-1 px-2 py-1 rounded-full bg-app-secondary w-fit"
                            v-for="n in propeller.pivot.quantity">
                            <p class="whitespace-nowrap">
                                {{ propeller.size + ' ' + propeller.type }}
                            </p>
                            <CrossIcon @click="removePropellerFromRcModel(index)" />
                        </div>
                    </div>
                    <div
                        class="flex items-center gap-1 px-2 py-1 rounded-full bg-app-secondary w-fit hover:cursor-pointer"
                        @click="openPropeller = true">
                        <PlusIcon class="w-4" />
                    </div>
                    <div>
                        <TransitionRoot as="template" :show="openPropeller">
                            <Dialog as="div" class="relative z-10" @close="openPropeller = false">
                                <TransitionChild
                                    as="template"
                                    enter="ease-out duration-300"
                                    enter-from="opacity-0"
                                    enter-to="opacity-100"
                                    leave="ease-in duration-200"
                                    leave-from="opacity-100"
                                    leave-to="opacity-0">
                                    <div
                                        class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" />
                                </TransitionChild>

                                <div class="fixed inset-0 z-10 overflow-y-auto">
                                    <div
                                        class="flex items-center justify-center min-h-full p-2 text-center">
                                        <TransitionChild
                                            as="template"
                                            enter="ease-out duration-300"
                                            enter-from="opacity-0 translate-y-0 scale-95"
                                            enter-to="opacity-100 translate-y-0 scale-100"
                                            leave="ease-in duration-200"
                                            leave-from="opacity-100 translate-y-0 scale-100"
                                            leave-to="opacity-0 translate-y-0 scale-95">
                                            <DialogPanel
                                                class="relative w-full text-left transition-all transform bg-white shadow-xl">
                                                <div class="p-6 px-4 pt-5 pb-4 bg-white">
                                                    <div>
                                                        <div class="mt-0 text-center">
                                                            <DialogTitle
                                                                as="h3"
                                                                class="text-base font-semibold leading-6 text-gray-900">
                                                                Ajouter une hélice
                                                            </DialogTitle>
                                                            <div class="w-full mt-2">
                                                                <Listbox
                                                                    as="div"
                                                                    v-model="selectedPropeller">
                                                                    <div class="relative mt-2">
                                                                        <ListboxButton
                                                                            class="relative w-full rounded-md py-1.5 pl-3 pr-10 text-left text-gray-900 ring-1 ring-app">
                                                                            <span
                                                                                class="flex items-center">
                                                                                <span>{{
                                                                                    selectedPropeller.size +
                                                                                    ' ' +
                                                                                    selectedPropeller.type
                                                                                }}</span>
                                                                            </span>
                                                                            <span
                                                                                class="absolute inset-y-0 right-0 flex items-center pr-2 ml-3 pointer-events-none">
                                                                                <ChevronDownIcon
                                                                                    class="w-5 h-5 text-gray-400"
                                                                                    aria-hidden="true" />
                                                                            </span>
                                                                        </ListboxButton>

                                                                        <transition
                                                                            leave-active-class="transition duration-100 ease-in"
                                                                            leave-from-class="opacity-100"
                                                                            leave-to-class="opacity-0">
                                                                            <ListboxOptions
                                                                                class="absolute z-10 w-full py-1 mt-1 overflow-auto text-base bg-white rounded-md shadow-lg max-h-56 ring-1 ring-black ring-opacity-5 focus:outline-none">
                                                                                <ListboxOption
                                                                                    as="template"
                                                                                    v-for="propeller in propellers"
                                                                                    :key="
                                                                                        propeller.id
                                                                                    "
                                                                                    :value="
                                                                                        propeller
                                                                                    "
                                                                                    v-slot="{
                                                                                        active: active3,
                                                                                        selected:
                                                                                            selectedPropeller,
                                                                                    }">
                                                                                    <li
                                                                                        :class="[
                                                                                            active3
                                                                                                ? 'bg-app text-white'
                                                                                                : 'text-gray-900',
                                                                                            'relative cursor-default select-none py-2 pl-3 pr-9',
                                                                                        ]">
                                                                                        <div
                                                                                            class="flex items-center">
                                                                                            <span
                                                                                                :class="[
                                                                                                    selectedPropeller
                                                                                                        ? 'font-semibold'
                                                                                                        : 'font-normal',
                                                                                                    'ml-3 block truncate',
                                                                                                ]"
                                                                                                >{{
                                                                                                    propeller.size +
                                                                                                    ' ' +
                                                                                                    propeller.type
                                                                                                }}</span
                                                                                            >
                                                                                        </div>

                                                                                        <span
                                                                                            v-if="
                                                                                                selectedPropeller
                                                                                            "
                                                                                            :class="[
                                                                                                active3
                                                                                                    ? 'text-white'
                                                                                                    : 'text-app',
                                                                                                'absolute inset-y-0 right-0 flex items-center pr-4',
                                                                                            ]">
                                                                                            <CheckIcon
                                                                                                class="w-5 h-5"
                                                                                                aria-hidden="true" />
                                                                                        </span>
                                                                                    </li>
                                                                                </ListboxOption>
                                                                            </ListboxOptions>
                                                                        </transition>
                                                                    </div>
                                                                </Listbox>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div
                                                    class="px-4 py-3 bg-gray-50 sm:flex sm:flex-row-reverse sm:px-6">
                                                    <button
                                                        type="button"
                                                        class="inline-flex justify-center w-full px-3 py-2 text-sm font-semibold text-white rounded-md shadow-sm bg-Valid hover:bg-lime-400 sm:ml-3 sm:w-auto"
                                                        @click="
                                                            addPropeller(selectedPropeller.id);
                                                            openPropeller = false;
                                                        ">
                                                        Ajouter
                                                    </button>
                                                    <button
                                                        type="button"
                                                        class="inline-flex justify-center w-full px-3 py-2 mt-3 text-sm font-semibold text-gray-900 bg-white rounded-md shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto"
                                                        @click="openPropeller = false"
                                                        ref="cancelButtonRef">
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
                </div>
                <div>
                    <p>Batteries:</p>
                    <div
                        v-for="(battery, index) in rcModel.batteries"
                        class="flex flex-wrap gap-2 my-2">
                        <div
                            class="flex items-center gap-1 px-2 py-1 rounded-full bg-app-secondary w-fit"
                            v-for="n in battery.pivot.quantity">
                            <p class="whitespace-nowrap">
                                {{
                                    battery.cells +
                                    's ' +
                                    battery.capacity +
                                    'mAh ' +
                                    battery.cRate +
                                    'c ' +
                                    battery.type
                                }}
                            </p>
                            <CrossIcon @click="removeBatteryFromRcModel(index)" />
                        </div>
                    </div>
                    <div
                        class="flex items-center gap-1 px-2 py-1 rounded-full bg-app-secondary w-fit hover:cursor-pointer"
                        @click="openBattery = true">
                        <PlusIcon class="w-4" />
                    </div>
                    <div>
                        <TransitionRoot as="template" :show="openBattery">
                            <Dialog as="div" class="relative z-10" @close="openBattery = false">
                                <TransitionChild
                                    as="template"
                                    enter="ease-out duration-300"
                                    enter-from="opacity-0"
                                    enter-to="opacity-100"
                                    leave="ease-in duration-200"
                                    leave-from="opacity-100"
                                    leave-to="opacity-0">
                                    <div
                                        class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" />
                                </TransitionChild>

                                <div class="fixed inset-0 z-10 overflow-y-auto">
                                    <div
                                        class="flex items-center justify-center min-h-full p-2 text-center">
                                        <TransitionChild
                                            as="template"
                                            enter="ease-out duration-300"
                                            enter-from="opacity-0 translate-y-0 scale-95"
                                            enter-to="opacity-100 translate-y-0 scale-100"
                                            leave="ease-in duration-200"
                                            leave-from="opacity-100 translate-y-0 scale-100"
                                            leave-to="opacity-0 translate-y-0 scale-95">
                                            <DialogPanel
                                                class="relative w-full text-left transition-all transform bg-white shadow-xl">
                                                <div class="p-6 px-4 pt-5 pb-4 bg-white">
                                                    <div>
                                                        <div class="mt-0 text-center">
                                                            <DialogTitle
                                                                as="h3"
                                                                class="text-base font-semibold leading-6 text-gray-900">
                                                                Ajouter une batterie
                                                            </DialogTitle>
                                                            <div class="w-full mt-2">
                                                                <Listbox
                                                                    as="div"
                                                                    v-model="selectedBattery">
                                                                    <div class="relative mt-2">
                                                                        <ListboxButton
                                                                            class="relative w-full rounded-md py-1.5 pl-3 pr-10 text-left text-gray-900 ring-1 ring-app">
                                                                            <span
                                                                                class="flex items-center">
                                                                                <span>{{
                                                                                    selectedBattery.cells +
                                                                                    's ' +
                                                                                    selectedBattery.capacity +
                                                                                    'mAh ' +
                                                                                    selectedBattery.cRate +
                                                                                    'c ' +
                                                                                    selectedBattery.type
                                                                                }}</span>
                                                                            </span>
                                                                            <span
                                                                                class="absolute inset-y-0 right-0 flex items-center pr-2 ml-3 pointer-events-none">
                                                                                <ChevronDownIcon
                                                                                    class="w-5 h-5 text-gray-400"
                                                                                    aria-hidden="true" />
                                                                            </span>
                                                                        </ListboxButton>

                                                                        <transition
                                                                            leave-active-class="transition duration-100 ease-in"
                                                                            leave-from-class="opacity-100"
                                                                            leave-to-class="opacity-0">
                                                                            <ListboxOptions
                                                                                class="absolute z-10 w-full py-1 mt-1 overflow-auto text-base bg-white rounded-md shadow-lg max-h-56 ring-1 ring-black ring-opacity-5 focus:outline-none">
                                                                                <ListboxOption
                                                                                    as="template"
                                                                                    v-for="battery in batteries"
                                                                                    :key="
                                                                                        battery.id
                                                                                    "
                                                                                    :value="battery"
                                                                                    v-slot="{
                                                                                        active: active4,
                                                                                        selected:
                                                                                            selectedBattery,
                                                                                    }">
                                                                                    <li
                                                                                        :class="[
                                                                                            active4
                                                                                                ? 'bg-app text-white'
                                                                                                : 'text-gray-900',
                                                                                            'relative cursor-default select-none py-2 pl-3 pr-9',
                                                                                        ]">
                                                                                        <div
                                                                                            class="flex items-center">
                                                                                            <span
                                                                                                :class="[
                                                                                                    selectedBattery
                                                                                                        ? 'font-semibold'
                                                                                                        : 'font-normal',
                                                                                                    'ml-3 block truncate',
                                                                                                ]"
                                                                                                >{{
                                                                                                    battery.cells +
                                                                                                    's ' +
                                                                                                    battery.capacity +
                                                                                                    'mAh ' +
                                                                                                    battery.cRate +
                                                                                                    'c ' +
                                                                                                    battery.type
                                                                                                }}</span
                                                                                            >
                                                                                        </div>

                                                                                        <span
                                                                                            v-if="
                                                                                                selectedBattery
                                                                                            "
                                                                                            :class="[
                                                                                                active4
                                                                                                    ? 'text-white'
                                                                                                    : 'text-app',
                                                                                                'absolute inset-y-0 right-0 flex items-center pr-4',
                                                                                            ]">
                                                                                            <CheckIcon
                                                                                                class="w-5 h-5"
                                                                                                aria-hidden="true" />
                                                                                        </span>
                                                                                    </li>
                                                                                </ListboxOption>
                                                                            </ListboxOptions>
                                                                        </transition>
                                                                    </div>
                                                                </Listbox>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div
                                                    class="px-4 py-3 bg-gray-50 sm:flex sm:flex-row-reverse sm:px-6">
                                                    <button
                                                        type="button"
                                                        class="inline-flex justify-center w-full px-3 py-2 text-sm font-semibold text-white rounded-md shadow-sm bg-Valid hover:bg-lime-400 sm:ml-3 sm:w-auto"
                                                        @click="
                                                            addBattery(selectedBattery.id);
                                                            openBattery = false;
                                                        ">
                                                        Ajouter
                                                    </button>
                                                    <button
                                                        type="button"
                                                        class="inline-flex justify-center w-full px-3 py-2 mt-3 text-sm font-semibold text-gray-900 bg-white rounded-md shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto"
                                                        @click="openBattery = false"
                                                        ref="cancelButtonRef">
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
                </div>
            </div>
            <div>
                <h1>Historique</h1>
                <div>
                    <p>Acquis le :</p>
                    <input
                        type="date"
                        v-model="rcModel.acquired_on"
                        class="w-full p-0 py-2 border-t-0 border-l-0 border-r-0 border-b-app focus:ring-0" />
                </div>
                <div>
                    <p>Fini le:</p>
                    <input
                        type="date"
                        v-model="rcModel.finished_on"
                        class="w-full p-0 py-2 border-t-0 border-l-0 border-r-0 border-b-app focus:ring-0" />
                </div>
                <div>
                    <p>Mis en service le:</p>
                    <input
                        type="date"
                        v-model="rcModel.first_flown_on"
                        class="w-full p-0 py-2 border-t-0 border-l-0 border-r-0 border-b-app focus:ring-0" />
                </div>
            </div>

            <Listbox as="div" v-model="selectedTransmiter">
                <ListboxLabel as="h1">Radiocommande</ListboxLabel>
                <div class="relative mt-2">
                    <ListboxButton
                        class="relative w-full rounded-md py-1.5 pl-3 pr-10 text-left text-gray-900 ring-1 ring-app">
                        <span class="flex items-center">
                            <span>{{
                                selectedTransmiter.manufacturer + ' ' + selectedTransmiter.name
                            }}</span>
                        </span>
                        <span
                            class="absolute inset-y-0 right-0 flex items-center pr-2 ml-3 pointer-events-none">
                            <ChevronDownIcon class="w-5 h-5 text-gray-400" aria-hidden="true" />
                        </span>
                    </ListboxButton>

                    <transition
                        leave-active-class="transition duration-100 ease-in"
                        leave-from-class="opacity-100"
                        leave-to-class="opacity-0">
                        <ListboxOptions
                            class="absolute z-10 w-full py-1 mt-1 overflow-auto text-base bg-white rounded-md shadow-lg max-h-56 ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
                            <ListboxOption
                                v-for="transmitter in transmitters"
                                :key="transmitter.id"
                                :value="transmitter"
                                v-slot="{ active, selected }">
                                <li
                                    :class="[
                                        active ? 'bg-app text-white' : 'text-gray-900 bg-white',
                                        'relative cursor-default select-none py-2 pl-3 pr-9',
                                    ]">
                                    <div class="flex items-center">
                                        <span
                                            :class="[
                                                selected ? 'font-semibold' : 'font-normal',
                                                'ml-3 block truncate',
                                            ]"
                                            >{{
                                                transmitter.manufacturer + ' ' + transmitter.name
                                            }}</span
                                        >
                                    </div>

                                    <span
                                        v-show="selected"
                                        :class="[
                                            active ? 'text-white' : 'text-app',
                                            'absolute inset-y-0 right-0 flex items-center pr-4',
                                        ]">
                                        <CheckIcon class="w-5 h-5" aria-hidden="true" />
                                    </span>
                                </li>
                            </ListboxOption>
                        </ListboxOptions>
                    </transition>
                </div>
            </Listbox>

            <div>
                <h1>Vols</h1>
                <input
                    type="number"
                    v-model="rcModel.flights_offset"
                    class="w-full p-0 py-2 border-t-0 border-l-0 border-r-0 border-b-app focus:ring-0" />
            </div>

            <div>
                <Button class="mt-5">
                    <div class="flex items-center justify-between gap-2">
                        <p>Sauver</p>
                        <CheckIcon class="h-5" />
                    </div>
                </Button>
            </div>
        </form>
    </div>
</template>
