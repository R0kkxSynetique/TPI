<script setup>
import { Head, Link, usePage, useForm, router } from '@inertiajs/vue3';
import SideBarMenu from '@/Components/SideBarMenu.vue';
import UserBackground from '@/Components/BackGrounds/UserBackground.vue';
import { useImagePreview } from '@/lib/image';
import { ref } from 'vue';
import { CheckIcon } from '@heroicons/vue/20/solid';
import { useToast } from 'vue-toastification';
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

const user = usePage().props.auth.user;
const form = useForm({ user: null });
const toast = useToast();
const saved = ref(false);

form.user = user;

const submit = () => {
    form.put('/user/password');
};
</script>
<template>
    <Head title="Changement de mot de passe" />
    <UserBackground />
    <div class="relative min-w-full min-h-screen mb-5">
        <div>
            <div class="relative z-50 flex justify-between w-full px-8 pt-8">
                <SideBarMenu menu-icon-class="text-app" />
            </div>
        </div>
        <div class="flex flex-col gap-4 mx-10 mt-3">
            <h1 class="text-4xl text-gray-700"><b>Profil</b></h1>
            <div class="flex flex-col items-center w-20">
                <img
                    class="object-cover w-20 overflow-hidden rounded-full aspect-square"
                    :src="`/image/user/${user.id}`"
                    :alt="user.username" />
            </div>
            <form @submit.prevent="submit">
                <div class="[&>div>p]:text-sm [&>div>input]:text-app flex flex-col gap-4">
                    <div>
                        <p>Ancien mot de passe</p>
                        <input
                            type="text"
                            v-model="form.oldPassword"
                            required
                            class="w-full p-0 py-2 border-t-0 border-l-0 border-r-0 border-b-app focus:ring-0" />
                    </div>
                    <div>
                        <p>Nouveau mot de passe</p>
                        <input
                            type="text"
                            v-model="form.newPassword"
                            required
                            class="w-full p-0 py-2 border-t-0 border-l-0 border-r-0 border-b-app focus:ring-0" />
                    </div>
                    <div>
                        <p>Confirmation du nouveau mot de passe</p>
                        <input
                            type="text"
                            v-model="form.confirmPassword"
                            required
                            class="w-full p-0 py-2 border-t-0 border-l-0 border-r-0 border-b-app focus:ring-0" />
                    </div>
                    <div class="grid items-center justify-center grid-cols-2 gap-3 place-items-center">
                        <button
                            id="saveButton"
                            class="flex items-center justify-center w-full py-5 transition-all rounded-full shadow-lg drop-shadow text-app">
                            <p>Sauvegarder</p>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>
