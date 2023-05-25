<script setup>
import { Head, Link, usePage, useForm, router } from '@inertiajs/vue3';
import Button from '@/Components/Button.vue';
import {
    PlusCircleIcon,
    BoltIcon,
    ArrowPathIcon,
    CheckIcon,
    ChevronDownIcon,
    EllipsisHorizontalIcon,
ScaleIcon,
} from '@heroicons/vue/20/solid';
import GasIcon from '../Components/icons/GasIcon.vue';
import { computed, ref } from 'vue';
import { useToast } from 'vue-toastification';
import PageHeader from '../Components/PageHeader.vue';
import AddLink from '../Components/AddLink.vue';
import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel,
    DialogTitle,
    Listbox,
    ListboxButton,
    ListboxOption,
    ListboxOptions,
    Menu,
    MenuButton,
    MenuItem,
    MenuItems,
} from '@headlessui/vue';

const toast = useToast();

defineProps({
    engines: Object,
});

const message = computed(() => usePage().props.flash.message).value;
const type = computed(() => usePage().props.flash.type).value;

const formEdit = useForm({
    engine: Object,
});

const openDelete = ref(false);
const openEdit = ref(false);
const engineToDelete = ref(0);
const engineTypes = ['thermique', 'électrique'];

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

function editEngine(engineId) {
    axios.get('/engines/' + engineId + '/edit').then((res) => {
        formEdit.engine = res.data.engine;
        openEdit.value = true;
    });
}

function openDeleteEngine(engineId) {
    engineToDelete.value = engineId;
    openDelete.value = true;
}

function updateEngine() {
    formEdit.put('/engines/' + formEdit.engine.id, {
        onSuccess: () => {
            openEdit.value = false;
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
        },
    });
}

function deleteEngine() {
    router.delete('/engines/' + engineToDelete.value, {
        onSuccess: () => {
            openDelete.value = false;
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
        },
    });
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
                <div class="flex justify-end mr-3">
                    <Menu as="div" class="relative inline-block text-left">
                        <div>
                            <MenuButton>
                                <EllipsisHorizontalIcon class="w-8 md:w-12" />
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
                                <div class="py-1 [&>*]:text-center [&_button]:md:text-2xl">
                                    <MenuItem v-slot="{ active }">
                                        <button
                                            @click="editEngine(engine.id)"
                                            :class="[
                                                active
                                                    ? 'bg-gray-100 text-gray-900'
                                                    : 'text-gray-700',
                                                'block px-4 py-2 text-sm w-full',
                                            ]">
                                            Modifier
                                        </button>
                                    </MenuItem>
                                    <MenuItem v-slot="{ active }">
                                        <button
                                            @click="openDeleteEngine(engine.id)"
                                            :class="[
                                                active
                                                    ? 'bg-gray-100 text-gray-900'
                                                    : 'text-gray-700',
                                                'block px-4 py-2 text-sm w-full',
                                            ]">
                                            Supprimer
                                        </button>
                                    </MenuItem>
                                </div>
                            </MenuItems>
                        </transition>
                    </Menu>
                </div>
                <div class="flex justify-between py-2 -mt-10">
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
                                {{ engine.type == 'électrique' ? ' kV' : '' }}
                            </p>
                        </div>
                        <div v-if="engine.weight" class="flex items-center [&>*]:mx-1">
                            <ScaleIcon class="w-5 fill-app md:w-10" />
                            <p class="flex-1 truncate">
                                {{
                                    engine.weight
                                        ? engine.weight / 1000 > 1
                                            ? engine.weight / 1000 + ' Kg'
                                            : engine.weight + ' g'
                                        : '-'
                                }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <TransitionRoot as="template" :show="openEdit">
            <Dialog as="div" class="relative z-50" @close="openEdit = false">
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

                <div
                    class="fixed inset-0 z-10 flex items-center justify-center min-h-full p-2 overflow-y-auto text-center">
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
                            <form @submit.prevent="updateEngine">
                                <div class="p-6 px-4 pt-5 pb-4 mt-0 text-center bg-white">
                                    <DialogTitle
                                        as="h1"
                                        class="text-base font-semibold leading-6 text-gray-900 md:text-4xl">
                                        Modification d'un moteur
                                    </DialogTitle>
                                    <div
                                        class="flex flex-wrap [&>div]:py-5 mt-4 [&_input]:md:text-2xl">
                                        <div class="flex w-full gap-4">
                                            <div
                                                class="border-b-2 border-b-app"
                                                :class="
                                                    formEdit.engine.type == 'thermique'
                                                        ? 'w-1/3'
                                                        : 'w-1/2'
                                                ">
                                                <input
                                                    type="text"
                                                    v-model="formEdit.engine.name"
                                                    maxlength="50"
                                                    required
                                                    placeholder="Fiala B2"
                                                    class="w-full p-0 py-2 border-0 focus:ring-0" />
                                            </div>
                                            <div
                                                class="w-1/3"
                                                v-if="formEdit.engine.type == 'thermique'">
                                                <div
                                                    class="relative flex items-center w-full border-b-2 border-b-app">
                                                    <input
                                                        type="number"
                                                        v-model="formEdit.engine.power"
                                                        required
                                                        max="10000"
                                                        placeholder="120"
                                                        class="w-full p-0 py-2 border-0 focus:ring-0" />
                                                    <p
                                                        class="absolute hidden md:text-2xl right-5 md:block">
                                                        cc
                                                    </p>
                                                </div>
                                            </div>
                                            <div
                                                :class="
                                                    formEdit.engine.type == 'thermique'
                                                        ? 'w-1/3'
                                                        : 'w-1/2'
                                                ">
                                                <div
                                                    class="relative flex items-center w-full border-b-2 border-b-app">
                                                    <input
                                                        type="text"
                                                        v-model="formEdit.engine.frequency"
                                                        required
                                                        max="50000"
                                                        :placeholder="
                                                            formEdit.engine.type == 'thermique'
                                                                ? '4 temps'
                                                                : '1100'
                                                        "
                                                        class="w-full p-0 py-2 border-0 focus:ring-0" />
                                                    <p
                                                        v-if="formEdit.engine.type == 'électrique'"
                                                        class="absolute hidden md:text-2xl right-5 md:block">
                                                        kV
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex w-full gap-4">
                                            <div class="items-center w-1/3 border-b-2 border-b-app">
                                                <input
                                                    type="text"
                                                    v-model="formEdit.engine.fuel"
                                                    maxlength="50"
                                                    required
                                                    placeholder="95 SP 3.3%"
                                                    class="w-full p-0 py-2 border-0 focus:ring-0" />
                                            </div>
                                            <div class="w-1/3">
                                                <div
                                                    class="relative flex items-center w-full border-b-2 border-b-app">
                                                    <input
                                                        type="text"
                                                        v-model="formEdit.engine.weight"
                                                        required
                                                        max="50000"
                                                        placeholder="3450"
                                                        class="w-full p-0 py-2 border-0 focus:ring-0" />
                                                    <p
                                                        class="absolute hidden md:text-2xl right-5 md:block">
                                                        g
                                                    </p>
                                                </div>
                                            </div>
                                            <Listbox
                                                as="div"
                                                v-model="formEdit.engine.type"
                                                class="w-1/3">
                                                <div class="relative z-0 mt-2">
                                                    <ListboxButton
                                                        class="relative w-full rounded-md py-1.5 pl-3 pr-10 text-left text-gray-900 ring-1 ring-app">
                                                        <span class="flex items-center md:text-2xl"
                                                            >{{ formEdit.engine.type }}
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
                                                            class="absolute z-10 py-1 mt-1 overflow-auto text-base bg-white rounded-md shadow-lg -ml-7 md:w-full md:ml-0 max-h-56 ring-1 ring-black ring-opacity-5 focus:outline-none">
                                                            <ListboxOption
                                                                v-for="engineType in engineTypes"
                                                                :key="engineType"
                                                                :value="engineType"
                                                                v-slot="{ active, selected }">
                                                                <li
                                                                    :class="[
                                                                        active
                                                                            ? 'bg-app text-white'
                                                                            : 'text-gray-900',
                                                                        'relative cursor-default select-none py-2 pl-3 pr-9 md:text-2xl',
                                                                    ]">
                                                                    <div class="flex items-center">
                                                                        <span
                                                                            :class="[
                                                                                selected
                                                                                    ? 'font-semibold'
                                                                                    : 'font-normal',
                                                                                'ml-3 block truncate',
                                                                            ]"
                                                                            >{{ engineType }}</span
                                                                        >
                                                                    </div>

                                                                    <span
                                                                        v-if="selected"
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
                                <div
                                    class="px-4 py-3 bg-gray-50 sm:flex sm:flex-row-reverse sm:px-6 [&>button]:md:text-2xl">
                                    <button
                                        type="submit"
                                        class="inline-flex justify-center w-full px-3 py-2 text-sm font-semibold text-white rounded-md shadow-sm bg-Valid hover:bg-green-500 sm:ml-3 sm:w-auto">
                                        Sauver
                                    </button>
                                    <button
                                        type="button"
                                        class="inline-flex justify-center w-full px-3 py-2 mt-3 text-sm font-semibold text-gray-900 bg-white rounded-md shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto"
                                        @click="openEdit = false">
                                        Annuler
                                    </button>
                                </div>
                            </form>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </Dialog>
        </TransitionRoot>
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
                                                Êtes-vous sûr de vouloir supprimer ce moteur ?
                                            </DialogTitle>
                                            <div class="w-full mt-2 text-sm">
                                                Cette action est
                                                <strong>irréversible</strong>.<br />
                                                Une fois confirmé, votre moteur sera supprimé de
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
                                        @click="deleteEngine()">
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
</template>
