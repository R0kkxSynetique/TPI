<script setup>
import { Head, useForm, Link } from '@inertiajs/vue3';
import AuthBackground from '@/Components/BackGrounds/AuthBackground.vue';
import Button from '@/Components/Button.vue';
import { ArrowRightIcon, EyeIcon, EyeSlashIcon } from '@heroicons/vue/20/solid';
import { useToast } from 'vue-toastification';

const toast = useToast();

const form = useForm({
    lastname: '',
    firstname: '',
    birthdate: '',
    email: '',
    username: '',
    password: '',
});

const submit = () => {
    form.post('/register', {
        onError: (e) => {
            console.log(e);
            if (e.createUser) {
                for (const [key, value] of Object.entries(e.createUser)) {
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
    <Head title="Création de compte" />
    <form class="w-full [&_input]:md:text-2xl [&_label]:md:text-2xl" @submit.prevent="submit">
        <AuthBackground>
            <template v-slot:logo>
                <img
                    src="../../../../storage/app/public/img/Logo.png"
                    alt="asd"
                    class="absolute w-20 top-2 left-8 md:w-40 md:left-10" />
            </template>
            <template v-slot:header>
                <p class="absolute text-3xl text-white top-28 md:top-52 md:text-6xl left-8">
                    Bienvenue
                </p>
            </template>
        </AuthBackground>
        <div class="w-full mx-auto mt-6 md:-mt-24 md:w-1/2">
            <p class="mb-4 ml-4 text-2xl md:text-4xl">
                <b>Création de compte</b>
            </p>
            <div class="grid md:grid-cols-2">
                <div class="flex flex-col items-start mx-5">
                    <label for="username-input" class="text-gray-400">Pseudo</label>
                    <input
                        id="username"
                        v-model="form.username"
                        type="text"
                        name="username-input"
                        required
                        placeholder="R0kkxSynetique"
                        class="w-full p-0 py-2 border-t-0 border-l-0 border-r-0 text- border-b-app" />
                </div>
                <div class="flex flex-col items-start mx-5">
                    <label for="name-input" class="text-gray-400">Nom de famille</label>
                    <input
                        id="name"
                        v-model="form.lastname"
                        type="text"
                        name="name-input"
                        required
                        placeholder="Fontana"
                        class="w-full p-0 py-2 border-t-0 border-l-0 border-r-0 text- border-b-app" />
                </div>
                <div class="flex flex-col items-start mx-5">
                    <label for="firstname-input" class="text-gray-400">Prénom</label>
                    <input
                        id="firstname"
                        v-model="form.firstname"
                        type="text"
                        name="firstname-input"
                        required
                        placeholder="Benjamin"
                        class="w-full p-0 py-2 border-t-0 border-l-0 border-r-0 text- border-b-app" />
                </div>
                <div class="flex flex-col items-start mx-5">
                    <label for="birthdate-input" class="text-gray-400">Date de naissance</label>
                    <input
                        id="birthdate"
                        v-model="form.birthdate"
                        type="date"
                        name="birthdate-input"
                        required
                        class="w-full p-0 py-2 border-t-0 border-l-0 border-r-0 text- border-b-app" />
                </div>
                <div class="flex flex-col items-start mx-5">
                    <label for="email-input" class="text-gray-400">Adresse email</label>
                    <input
                        id="email"
                        v-model="form.email"
                        type="email"
                        name="email-input"
                        required
                        placeholder="benjamin@r0kkxsynetique.ch"
                        class="w-full p-0 py-2 border-t-0 border-l-0 border-r-0 text- border-b-app" />
                </div>
                <div class="flex flex-col items-start mx-5">
                    <label for="email-input" class="text-gray-400">Mot de passe</label>
                    <div class="flex items-center w-full">
                        <input
                            v-if="showPassword"
                            id="password"
                            v-model="form.password"
                            type="text"
                            name="password-input"
                            required
                            class="w-full p-0 py-2 border-t-0 border-l-0 border-r-0 text- border-b-app" />
                        <input
                            v-else
                            id="password"
                            v-model="form.password"
                            type="password"
                            name="password-input"
                            required
                            class="w-full p-0 py-2 border-t-0 border-l-0 border-r-0 text- border-b-app" />
                        <div
                            class="relative right-0 px-8 border-b border-b-app"
                            @click="toggleShow()">
                            <EyeIcon class="w-4 py-3 md:py-2 md:w-8" v-if="!showPassword" />
                            <EyeSlashIcon class="w-4 py-3 md:py-2 md:w-8" v-else />
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-col items-start mx-5 mt-3">
                <Link href="/login" class="mt-5 text-app md:text-2xl">
                    <p>Déjà un compte ?</p>
                </Link>
                <Button class="flex items-center justify-between w-full py-6 mt-16">
                    <p class="md:text-2xl">Créer le compte</p>
                    <ArrowRightIcon class="w-4 md:w-8" />
                </Button>
            </div>
        </div>
    </form>
</template>

<script>
export default {
    data() {
        return {
            showPassword: false,
            password: null,
        };
    },
    methods: {
        toggleShow() {
            this.showPassword = !this.showPassword;
        },
    },
    components: { EyeSlashIcon, ArrowRightIcon },
};
</script>
