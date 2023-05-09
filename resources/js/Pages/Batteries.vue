<script setup>
import { Head, Link, usePage, useForm } from '@inertiajs/vue3';
import SideBarMenu from '@/Components/SideBarMenu.vue';
import {
    TagIcon,
    Battery100Icon,
    CircleStackIcon,
    BoltIcon,
    PlusIcon,
    CheckIcon,
    ChevronDownIcon,
} from '@heroicons/vue/20/solid';
import Button from '@/Components/Button.vue';
import { ref, computed } from 'vue';
import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel,
    DialogTitle,
    Listbox,
    ListboxButton,
    ListboxLabel,
    ListboxOption,
    ListboxOptions,
} from '@headlessui/vue';
import { useToast } from 'vue-toastification';

const user = usePage().props.auth.user;

const props = defineProps({
    batteries: Object,
});

const form = useForm({
    battery: {
        type: 'LiPo',
        capacity: null,
        cells: null,
        cRate: null,
        user_id: null,
    },
});

const openCreate = ref(false);

const batteryTypes = ['LiPo', 'LiFe', 'Li-Ion', 'NiMH', 'NiCd'];

const message = computed(() => usePage().props.flash.message).value;
const type = computed(() => usePage().props.flash.type).value;

const toast = useToast();

const submit = () => {
    form.post(`/batteries`, {
        onSuccess: () => {
            openCreate.value = false;
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
};
</script>

<template>
    <Head title="Accueil" />

    <div class="relative min-w-full min-h-screen">
        <div
            class="h-56 rounded-b-[4rem] bg-gradient-to-br from-gradientfrom to-gradientto text-white text-2xl">
            <div class="relative z-50 flex justify-between w-full px-8 pt-8">
                <SideBarMenu />
                <div class="w-12 h-12">
                    <img
                        :src="`/image/user/${user.id}`"
                        class="object-cover w-20 overflow-hidden rounded-full aspect-square" />
                </div>
            </div>
            <div class="flex items-center justify-between">
                <h1 class="pt-10 pl-12">Mes<br/>batteries</h1>
                <button
                    v-if="batteries.length > 0"
                    @click="openCreate = true"
                    class="flex items-center justify-center gap-2 mt-10 mr-8">
                    <PlusIcon class="w-5 fill-white" />
                    <p>Créer</p>
                </button>
            </div>
        </div>
        <div v-if="batteries.length <= 0">
            <div class="flex items-center justify-center mt-5">
                <p>Vous n'avez pas encore de batteries.<br />Créez-en une en cliquant ci-dessous</p>
            </div>

            <div class="flex items-center justify-center mt-5">
                <Button @click="openCreate = true" class="flex items-center justify-center">
                    <PlusIcon class="w-5 fill-white" />
                    <p>Céer</p>
                </Button>
            </div>
        </div>
        <div class="grid max-h-full grid-cols-2 mt-4 xl:grid-cols-8">
            <div v-for="battery in batteries" class="mx-2 shadow-lg rounded-[3rem] py-5 mb-4">
                <div class="flex justify-center [&>div]:px-2">
                    <div class="flex flex-col justify-center gap-1 text-center">
                        <TagIcon class="w-5 fill-app" />
                        <Battery100Icon class="w-5 fill-app" />
                        <CircleStackIcon class="w-5 fill-app" />
                        <BoltIcon class="w-5 fill-app" />
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
        <TransitionRoot as="template" :show="openCreate">
            <Dialog as="div" class="relative z-50" @close="openCreate = false">
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
                                <form @submit.prevent="submit">
                                    <div class="p-6 px-4 pt-5 pb-4 bg-white">
                                        <div>
                                            <div class="mt-0 text-center">
                                                <DialogTitle
                                                    as="h1"
                                                    class="text-base font-semibold leading-6 text-gray-900">
                                                    Création d'une batterie
                                                </DialogTitle>
                                                <div class="flex flex-wrap mt-4">
                                                    <div class="flex w-full gap-4">
                                                        <div class="w-1/3">
                                                            <div
                                                                class="relative flex items-center w-full border-b-2 border-b-app">
                                                                <input
                                                                    type="number"
                                                                    max="100000"
                                                                    v-model="form.battery.capacity"
                                                                    required
                                                                    placeholder="Capacité"
                                                                    class="w-full p-0 py-2 border-0 focus:ring-0" />
                                                                <div
                                                                    class="absolute hidden md:block right-5">
                                                                    mAh
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="w-1/3">
                                                            <div
                                                                class="relative flex items-center w-full border-b-2 border-b-app">
                                                                <input
                                                                    type="number"
                                                                    max="100"
                                                                    v-model="form.battery.cells"
                                                                    required
                                                                    placeholder="Cellules"
                                                                    class="w-full p-0 py-2 border-0 focus:ring-0" />
                                                            </div>
                                                        </div>
                                                        <div class="w-1/3">
                                                            <div
                                                                class="relative flex items-center w-full border-b-2 border-b-app">
                                                                <input
                                                                    type="number"
                                                                    max="500"
                                                                    v-model="form.battery.cRate"
                                                                    required
                                                                    placeholder="C-Rate"
                                                                    class="w-full p-0 py-2 border-0 focus:ring-0" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="w-full mt-5">
                                                        <Listbox
                                                            as="div"
                                                            v-model="form.battery.type">
                                                            <div class="relative mt-2">
                                                                <ListboxButton
                                                                    class="relative w-full rounded-md py-1.5 pl-3 pr-10 text-left text-gray-900 ring-1 ring-app">
                                                                    <span class="flex items-center">
                                                                        <span>{{
                                                                            form.battery.type
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
                                                                            v-for="batteryType in batteryTypes"
                                                                            :key="batteryType"
                                                                            :value="batteryType"
                                                                            v-slot="{
                                                                                active,
                                                                                selected,
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
                                                                                            selected
                                                                                                ? 'font-semibold'
                                                                                                : 'font-normal',
                                                                                            'ml-3 block truncate',
                                                                                        ]"
                                                                                        >{{
                                                                                            batteryType
                                                                                        }}</span
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
                                        </div>
                                    </div>
                                    <div
                                        class="px-4 py-3 bg-gray-50 sm:flex sm:flex-row-reverse sm:px-6">
                                        <button
                                            type="submit"
                                            class="inline-flex justify-center w-full px-3 py-2 text-sm font-semibold text-white rounded-md shadow-sm bg-Valid hover:bg-green-500 sm:ml-3 sm:w-auto">
                                            Créer
                                        </button>
                                        <button
                                            type="button"
                                            class="inline-flex justify-center w-full px-3 py-2 mt-3 text-sm font-semibold text-gray-900 bg-white rounded-md shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto"
                                            @click="openCreate = false">
                                            Annuler
                                        </button>
                                    </div>
                                </form>
                            </DialogPanel>
                        </TransitionChild>
                    </div>
                </div>
            </Dialog>
        </TransitionRoot>
    </div>
</template>
