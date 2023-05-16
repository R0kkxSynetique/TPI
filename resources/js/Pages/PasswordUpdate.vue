<script setup>
import { Head, usePage, useForm } from '@inertiajs/vue3';
import SideBarMenu from '@/Components/SideBarMenu.vue';
import UserBackground from '@/Components/BackGrounds/UserBackground.vue';
import { ref } from 'vue';
import { useToast } from 'vue-toastification';
import { EyeIcon, EyeSlashIcon } from '@heroicons/vue/20/solid';

const user = usePage().props.auth.user;
const toast = useToast();
const saved = ref(false);
const form = useForm({
    user: null,
    current_password: null,
    password: null,
    confirm_password: null,
});

const showPassword = ref(false);
const showNewPassword = ref(false);
const showConfirmPassword = ref(false);

form.user = user;

const submit = () => {
    form.put('/user/password', {
        onError: (e) => {
            if (e.updatePassword) {
                for (const [key, value] of Object.entries(e.updatePassword)) {
                    toast.error(value, {
                        timeout: 10000,
                    });
                }
            }
        },
    });
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
                        <p>Mot de passe actuel</p>
                        <div class="flex items-center w-full">
                            <input
                                v-if="showPassword"
                                v-model="form.current_password"
                                type="text"
                                required
                                class="w-full p-0 py-2 border-t-0 border-l-0 border-r-0 text- border-b-app" />
                            <input
                                v-else
                                v-model="form.current_password"
                                type="password"
                                required
                                class="w-full p-0 py-2 border-t-0 border-l-0 border-r-0 text- border-b-app" />
                            <div
                                class="absolute px-8 py-5 right-5"
                                @click="showPassword = !showPassword">
                                <EyeIcon class="w-5" v-if="!showPassword" />
                                <EyeSlashIcon class="w-5" v-else />
                            </div>
                        </div>
                    </div>
                    <div>
                        <p>Nouveau mot de passe</p>
                        <div class="flex items-center w-full">
                            <input
                                v-if="showNewPassword"
                                v-model="form.password"
                                type="text"
                                required
                                class="w-full p-0 py-2 border-t-0 border-l-0 border-r-0 text- border-b-app" />
                            <input
                                v-else
                                v-model="form.password"
                                type="password"
                                required
                                class="w-full p-0 py-2 border-t-0 border-l-0 border-r-0 text- border-b-app" />
                            <div
                                class="absolute px-8 py-5 right-5"
                                @click="showNewPassword = !showNewPassword">
                                <EyeIcon class="w-5" v-if="!showNewPassword" />
                                <EyeSlashIcon class="w-5" v-else />
                            </div>
                        </div>
                    </div>
                    <div>
                        <p>Confirmation du nouveau mot de passe</p>
                        <div class="flex items-center w-full">
                            <input
                                v-if="showConfirmPassword"
                                v-model="form.confirm_password"
                                type="text"
                                required
                                class="w-full p-0 py-2 border-t-0 border-l-0 border-r-0 text- border-b-app" />
                            <input
                                v-else
                                v-model="form.confirm_password"
                                type="password"
                                required
                                class="w-full p-0 py-2 border-t-0 border-l-0 border-r-0 text- border-b-app" />
                            <div
                                class="absolute px-8 py-5 right-5"
                                @click="showConfirmPassword = !showConfirmPassword">
                                <EyeIcon class="w-5" v-if="!showConfirmPassword" />
                                <EyeSlashIcon class="w-5" v-else />
                            </div>
                        </div>
                    </div>
                    <div
                        class="grid items-center justify-center grid-cols-1 gap-3 md:grid-cols-2 place-items-center">
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
