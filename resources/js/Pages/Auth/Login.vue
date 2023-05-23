<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthBackground from '@/Components/BackGrounds/AuthBackground.vue';
import Button from '@/Components/Button.vue';
import { ref } from 'vue';
import { ArrowRightIcon, EyeIcon, EyeSlashIcon } from '@heroicons/vue/20/solid';
import { useToast } from 'vue-toastification';

const form = useForm({
    email: '',
    password: '',
});

const toast = useToast();

const submit = () => {
    form.transform((data) => ({
        ...data,
    })).post('/login', {
        onFinish: () => form.reset('password'),
        onError: (e) => {
            if (e.email) {
                toast.error(e.email, {
                    timeout: 10000,
                });
            }
        },
    });
};

const showPassword = ref(false);

function toggleShow() {
    this.showPassword = !this.showPassword;
}
</script>

<template>
    <Head title="Connexion" />
    <form class="w-full [&_input]:md:text-2xl" @submit.prevent="submit">
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
                <b>Connexion</b>
            </p>
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
            <div class="flex flex-col items-start mx-5 mt-3">
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
                    <div class="relative right-0 px-8 border-b border-b-app" @click="toggleShow()">
                        <EyeIcon class="w-4 py-3 md:py-2 md:w-8" v-if="!showPassword" />
                        <EyeSlashIcon class="w-4 py-3 md:py-2 md:w-8" v-else />
                    </div>
                </div>
                <Link href="/register" class="mt-5 text-app md:text-2xl">
                    <p>Pas encore de compte ?</p>
                </Link>
                <Button
                    class="flex items-center justify-between w-full py-6 mx-auto mt-12 md:w-1/2 md:text-2xl"
                    ><p>Se connecter</p>
                    <ArrowRightIcon class="w-5 md:w-8" />
                </Button>
            </div>
        </div>
    </form>
</template>
