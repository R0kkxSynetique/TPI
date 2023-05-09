<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import SideBarMenu from '@/Components/SideBarMenu.vue';
import Button from '@/Components/Button.vue';
import { useTextareaAutosize } from '@vueuse/core';
import CrossIcon from '@/Components/icons/CrossIcon.vue';
import { ref } from 'vue';
import { PhotoIcon, PlusIcon, CheckIcon, ChevronDownIcon, StarIcon } from '@heroicons/vue/20/solid';
import {
    Listbox,
    ListboxButton,
    ListboxLabel,
    ListboxOption,
    ListboxOptions,
} from '@headlessui/vue';
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue';
import { useImagePreview } from '../lib/image';

const props = defineProps({
    engines: Object,
    propellers: Object,
    batteries: Object,
    transmitters: Object,
});

const rcModel = {
    name: '',
    manufacturer: '',
    description: '',
    wingSpan: '',
    weight: '',
    length: '',
    height: '',
    engines: [],
    propellers: [],
    batteries: [],
    acquired_on: '',
    finished_on: '',
    first_flown_on: '',
    transmitter: [],
    transmitter_id: 0,
    flights_offset: 0,
    user_id: 0,
};

const form = useForm({
    rcModel: rcModel,
    image: null,
});

const fileInput = ref();
const openEngine = ref(false);
const openPropeller = ref(false);
const openBattery = ref(false);

const selectedEngine = ref(props.engines['0']);
const selectedPropeller = ref(props.propellers['0']);
const selectedBattery = ref(props.batteries['0']);
const selectedTransmiter = ref(props.transmitters['0']);

const { preview, updatePreview, clearPreview } = useImagePreview(fileInput);

function removeEngineFromRcModel(index) {
    if (form.rcModel.engines[index].pivot.quantity > 1) {
        form.rcModel.engines[index].pivot.quantity -= 1;
    } else {
        form.rcModel.engines.splice(index, 1);
    }
}

function removePropellerFromRcModel(index) {
    if (form.rcModel.propellers[index].pivot.quantity > 1) {
        form.rcModel.propellers[index].pivot.quantity -= 1;
    } else {
        form.rcModel.propellers.splice(index, 1);
    }
}

function removeBatteryFromRcModel(index) {
    if (form.rcModel.batteries[index].pivot.quantity > 1) {
        form.rcModel.batteries[index].pivot.quantity -= 1;
    } else {
        form.rcModel.batteries.splice(index, 1);
    }
}
function removeTransmitterFromRcModel(index) {
    if (form.rcModel.batteries[index].pivot.quantity > 1) {
        form.rcModel.batteries[index].pivot.quantity -= 1;
    } else {
        form.rcModel.batteries.splice(index, 1);
    }
}

function addEngine(engineId) {
    if (form.rcModel?.engines.find((engine) => engine.id === engineId)) {
        form.rcModel.engines.find((engine) => engine.id === engineId).pivot.quantity += 1;
    } else {
        let engine = props.engines.find((engine) => engine.id === engineId);
        let pivot = {
            engine_id: engine.id,
            rc_model_id: 0,
            quantity: 1,
        };
        engine.pivot = pivot;
        form.rcModel.engines.push(engine);
    }
}

function addPropeller(propellerId) {
    if (form.rcModel.propellers.find((propeller) => propeller.id === propellerId)) {
        form.rcModel.propellers.find(
            (propeller) => propeller.id === propellerId
        ).pivot.quantity += 1;
    } else {
        let propeller = props.propellers.find((propeller) => propeller.id === propellerId);
        let pivot = {
            propeller_id: propeller.id,
            rc_model_id: 0,
            quantity: 1,
        };
        propeller.pivot = pivot;
        form.rcModel.propellers.push(propeller);
    }
}

function addBattery(batteryId) {
    if (form.rcModel.batteries.find((battery) => battery.id === batteryId)) {
        form.rcModel.batteries.find((battery) => battery.id === batteryId).pivot.quantity += 1;
    } else {
        let battery = props.batteries.find((battery) => battery.id === batteryId);
        let pivot = {
            battery_id: battery.id,
            rc_model_id: 0,
            quantity: 1,
        };
        battery.pivot = pivot;
        form.rcModel.batteries.push(battery);
    }
}

const submit = () => {
    form.rcModel.transmitter_id = selectedTransmiter.id;
    if (fileInput.value) {
        form.image = fileInput.value.files ? fileInput.value.files[0] : null;
    }
    form.post(`/rc-models`);
};
</script>
<template>
    <Head title="Création"></Head>
    <div
        class="h-[14rem] rounded-b-[4rem] bg-gradient-to-br from-gradientfrom to-gradientto text-white text-2xl w-full">
        <div>
            <div class="flex items-center justify-between px-8 pt-8">
                <SideBarMenu />
            </div>
            <div class="flex items-center justify-center w-full -mt-6">
                <div
                    v-if="preview"
                    class="aspect-square w-40 rounded-[2rem] overflow-hidden bg-center bg-cover"
                    @click="$refs.fileInput.click()"
                    :style="{
                        backgroundImage: `url('${preview}')`,
                    }" />
                <PhotoIcon v-else class="w-32" @click="$refs.fileInput.click()" />
                <input
                    type="file"
                    ref="fileInput"
                    accept="image/*"
                    class="hidden"
                    @change="updatePreview" />
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
                    v-model="form.rcModel.name"
                    placeholder="Mitsubishi A6m zero"
                    required
                    maxlength="50"
                    class="w-full p-0 py-2 border-t-0 border-l-0 border-r-0 border-b-app focus:ring-0" />
                <input
                    type="text"
                    v-model="form.rcModel.manufacturer"
                    placeholder="Constructeur"
                    maxlength="50"
                    class="w-full p-0 py-2 border-t-0 border-l-0 border-r-0 border-b-app focus:ring-0" />
            </div>
            <div>
                <h1>Descritpion</h1>
                <textarea
                    type="text"
                    ref="textarea"
                    v-model="form.rcModel.description"
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
                            v-model="form.rcModel.wingSpan"
                            placeholder="2500"
                            class="w-full p-0 py-2 border-t-0 border-l-0 border-r-0 border-b-app focus:ring-0" />
                        <div class="absolute right-0 px-8 py-5">mm</div>
                    </div>
                </div>
                <div>
                    <p>Poids:</p>
                    <div class="flex items-center w-full">
                        <input
                            type="number"
                            v-model="form.rcModel.weight"
                            placeholder="16000"
                            class="w-full p-0 py-2 border-t-0 border-l-0 border-r-0 border-b-app focus:ring-0" />
                        <div class="absolute right-0 px-8 py-5">g</div>
                    </div>
                </div>
                <div>
                    <p>Longueur:</p>
                    <div class="flex items-center w-full">
                        <input
                            type="number"
                            v-model="form.rcModel.length"
                            placeholder="1700"
                            class="w-full p-0 py-2 border-t-0 border-l-0 border-r-0 border-b-app focus:ring-0" />
                        <div class="absolute right-0 px-8 py-5">mm</div>
                    </div>
                </div>
                <div>
                    <p>Hauteur:</p>
                    <div class="flex items-center w-full">
                        <input
                            type="number"
                            v-model="form.rcModel.height"
                            placeholder="800"
                            class="w-full p-0 py-2 border-t-0 border-l-0 border-r-0 border-b-app focus:ring-0" />
                        <div class="absolute right-0 px-8 py-5">mm</div>
                    </div>
                </div>
                <div>
                    <p>Moteurs:</p>
                    <div
                        v-for="(engine, index) in form.rcModel.engines"
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
                                                class="relative w-full text-left transition-all transform bg-white shadow-xl">
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
                                                                                    as="template"
                                                                                    v-for="engine in engines"
                                                                                    :key="engine.id"
                                                                                    :value="engine"
                                                                                    v-slot="{
                                                                                        active,
                                                                                        selected:
                                                                                            selectedEngine,
                                                                                    }">
                                                                                    <li
                                                                                        :class="[
                                                                                            active
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
                                                                                                    'ml-3 truncate flex gap-2',
                                                                                                ]"
                                                                                                ><StarIcon
                                                                                                    v-if="
                                                                                                        engine.user_id
                                                                                                    "
                                                                                                    class="w-4" />{{
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
                                                                                                active
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
                    <div>
                        <p>Hélices:</p>
                        <div
                            v-for="(propeller, index) in form.rcModel.propellers"
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
                                <Dialog
                                    as="div"
                                    class="relative z-10"
                                    @close="openPropeller = false">
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
                                                                                            active: active2,
                                                                                            selected:
                                                                                                selectedPropeller,
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
                            v-for="(battery, index) in form.rcModel.batteries"
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
                                                                                        :value="
                                                                                            battery
                                                                                        "
                                                                                        v-slot="{
                                                                                            active: active3,
                                                                                            selected:
                                                                                                selectedBattery,
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
                                                                                                        selectedBattery
                                                                                                            ? 'font-semibold'
                                                                                                            : 'font-normal',
                                                                                                        'ml-3 truncate flex gap-2',
                                                                                                    ]"
                                                                                                    ><StarIcon
                                                                                                        v-if="
                                                                                                            battery.user_id
                                                                                                        "
                                                                                                        class="w-4" />
                                                                                                    {{
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
                            v-model="form.rcModel.acquired_on"
                            class="w-full p-0 py-2 border-t-0 border-l-0 border-r-0 border-b-app focus:ring-0" />
                    </div>
                    <div>
                        <p>Fini le:</p>
                        <input
                            type="date"
                            v-model="form.rcModel.finished_on"
                            class="w-full p-0 py-2 border-t-0 border-l-0 border-r-0 border-b-app focus:ring-0" />
                    </div>
                    <div>
                        <p>Mis en service le:</p>
                        <input
                            type="date"
                            v-model="form.rcModel.first_flown_on"
                            class="w-full p-0 py-2 border-t-0 border-l-0 border-r-0 border-b-app focus:ring-0" />
                    </div>
                </div>
                <Listbox as="div" v-model="form.rcModel.transmitter">
                    <ListboxLabel as="h1">Radiocommande</ListboxLabel>
                    <div class="relative mt-2">
                        <ListboxButton
                            class="w-full rounded-md py-1.5 pl-3 pr-10 text-left text-gray-900 ring-1 ring-app">
                            <span class="flex items-center">
                                <span>{{
                                    form.rcModel.transmitter.id != null
                                        ? form.rcModel.transmitter.manufacturer +
                                          ' ' +
                                          form.rcModel.transmitter.name
                                        : 'Choisir une radiocommande'
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
                                    as="template"
                                    v-for="transmitter in transmitters"
                                    :key="transmitter.id"
                                    :value="transmitter"
                                    v-slot="{ active: active4, selected: selectedTransmiter }">
                                    <li
                                        :class="[
                                            active4 ? 'bg-app text-white' : 'text-gray-900',
                                            'relative cursor-default select-none py-2 pl-3 pr-9',
                                        ]">
                                        <div class="flex items-center">
                                            <span
                                                :class="[
                                                    selectedTransmiter
                                                        ? 'font-semibold'
                                                        : 'font-normal',
                                                    'ml-3 block truncate',
                                                ]"
                                                >{{
                                                    transmitter.manufacturer +
                                                    ' ' +
                                                    transmitter.name
                                                }}</span
                                            >
                                        </div>

                                        <span
                                            v-if="selectedTransmiter"
                                            :class="[
                                                active4 ? 'text-white' : 'text-app',
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
                        v-model="form.rcModel.flights_offset"
                        class="w-full p-0 py-2 border-t-0 border-l-0 border-r-0 border-b-app focus:ring-0" />
                </div>
                <div>
                    <Button class="mt-5">
                        <div class="flex items-center justify-between gap-2">
                            <p>Créer</p>
                            <CheckIcon class="h-5" />
                        </div>
                    </Button>
                </div>
            </div>
        </form>
    </div>
</template>
