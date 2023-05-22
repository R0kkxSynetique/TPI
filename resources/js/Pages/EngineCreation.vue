<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import SideBarMenu from '@/Components/SideBarMenu.vue';
import Button from '@/Components/Button.vue';
import { ref } from 'vue';
import { PhotoIcon, CheckIcon, ChevronDownIcon } from '@heroicons/vue/20/solid';
import { Listbox, ListboxButton, ListboxOption, ListboxOptions } from '@headlessui/vue';
import { useImagePreview } from '../lib/image';
import { useToast } from 'vue-toastification';

const form = useForm({
    engine: {
        name: null,
        power: null,
        type: 'thermique',
        weight: null,
        frequency: null,
        fuel: null,
        user_id: null,
    },
    image: null,
});

const toast = useToast();

const engineTypes = ['thermique', 'électrique'];

const fileInput = ref();

const { preview, updatePreview } = useImagePreview(fileInput);

const submit = () => {
    if (fileInput.value) {
        form.image = fileInput.value.files ? fileInput.value.files[0] : null;
    }
    form.post(`/engines`, {
        onError: (e) => {
            toast.error(e.image);
        },
    });
};
</script>
<template>
    <Head title="Création"></Head>
    <div
        class="h-60 md:h-[24rem] rounded-b-[4rem] bg-gradient-to-br from-gradientfrom to-gradientto text-white text-2xl w-full">
        <div class="relative z-20">
            <div class="flex items-center justify-between px-8 pt-8">
                <SideBarMenu />
            </div>
            <div class="flex items-center justify-center w-full -mt-6">
                <div
                    v-if="preview"
                    class="aspect-square h-40 md:h-72 max-w-full rounded-[2rem] overflow-hidden bg-center bg-cover"
                    @click="$refs.fileInput.click()"
                    :style="{
                        backgroundImage: `url('${preview}')`,
                    }" />
                <PhotoIcon v-else class="w-32 md:w-52" @click="$refs.fileInput.click()" />
                <input
                    type="file"
                    ref="fileInput"
                    accept="image/*"
                    class="hidden"
                    required
                    @change="updatePreview" />
            </div>
        </div>
    </div>

    <div
        class="mx-5 mt-3 [&_h1]:text-xl [&_h1]:text-app [&_h1]:mt-5 [&_h1]:md:text-4xl [&>div]:pt-4 pb-5 mb-5 [&_p]:md:text-2xl [&_input]:md:text-2xl">
        <form @submit.prevent="submit">
            <div>
                <h1>Nom</h1>
                <input
                    type="text"
                    v-model="form.engine.name"
                    placeholder="Fiala b2"
                    required
                    maxlength="50"
                    class="w-full p-0 py-2 border-t-0 border-l-0 border-r-0 border-b-app focus:ring-0" />
            </div>
            <div>
                <h1>Caractéristiques</h1>
                <div>
                    <p>Type:</p>
                    <div>
                        <Listbox as="div" v-model="form.engine.type">
                            <div class="relative z-0 mt-2">
                                <ListboxButton
                                    class="relative w-full rounded-md py-1.5 pl-3 pr-10 text-left text-gray-900 ring-1 ring-app">
                                    <span class="flex items-center md:text-2xl"
                                        >{{ form.engine.type }}
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
                                            v-for="engineType in engineTypes"
                                            :key="engineType"
                                            :value="engineType"
                                            v-slot="{ active, selected }">
                                            <li
                                                :class="[
                                                    active ? 'bg-app text-white' : 'text-gray-900',
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
                    </div>
                </div>
                <div
                    class="grid gap-3 md:gap-5 md:grid-cols-2 [&>div>div>p]:py-2 [&>div>div>p]:border-b [&>div>div>p]:border-b-app [&>div>p]:md:mt-4">
                    <div v-if="form.engine.type == 'thermique'">
                        <p>Puissance:</p>
                        <div class="flex items-center w-full">
                            <input
                                type="number"
                                v-model="form.engine.power"
                                placeholder="120"
                                max="10000"
                                class="w-full p-0 py-2 border-t-0 border-l-0 border-r-0 border-b-app focus:ring-0" />
                            <p>cc</p>
                        </div>
                    </div>
                    <div>
                        <p>Fréquence:</p>
                        <div class="flex items-center w-full">
                            <input
                                :type="form.engine.type == 'thermique' ? 'text' : 'number'"
                                v-model="form.engine.frequency"
                                maxlength="25"
                                max="50000"
                                :placeholder="
                                    form.engine.type == 'thermique' ? '4 temps ou 4t' : '1140'
                                "
                                class="w-full p-0 py-2 border-t-0 border-l-0 border-r-0 border-b-app focus:ring-0" />
                            <p v-if="form.engine.type == 'électrique'">kV</p>
                        </div>
                    </div>
                    <div>
                        <p>{{ form.engine.type == 'thermique' ? 'Carburant' : 'Alimentation' }}</p>
                        <div class="flex items-center w-full">
                            <input
                                type="text"
                                v-model="form.engine.fuel"
                                maxlength="50"
                                :placeholder="
                                    form.engine.type == 'thermique' ? '95 SP 3.3%' : 'Lipo 4S'
                                "
                                class="w-full p-0 py-2 border-t-0 border-l-0 border-r-0 border-b-app focus:ring-0" />
                        </div>
                    </div>
                    <div>
                        <p>Poids:</p>
                        <div class="flex items-center w-full">
                            <input
                                type="number"
                                v-model="form.engine.weight"
                                placeholder="3450"
                                max="50000"
                                class="w-full p-0 py-2 border-t-0 border-l-0 border-r-0 border-b-app focus:ring-0" />
                            <p>g</p>
                        </div>
                    </div>
                </div>
                <div>
                    <Button class="z-0 mt-5">
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
