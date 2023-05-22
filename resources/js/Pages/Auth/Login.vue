<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthBackground from '@/Components/BackGrounds/AuthBackground.vue';
import Logo from '@/Components/icons/Logo.vue';
import EyeIcon from '@/Components/icons/EyeIcon.vue';
import HiddenEyeIcon from '@/Components/icons/HiddenEyeIcon.vue';
import Button from '@/Components/Button.vue';
import ButtonRightArrowIcon from '@/Components/icons/ButtonRightArrowIcon.vue';
import { ref } from 'vue';

const form = useForm({
    email: '',
    password: '',
});

const submit = () => {
    form.transform((data) => ({
        ...data,
    })).post('/login', {
        onFinish: () => form.reset('password'),
    });
};

const showPassword = ref(false)

function toggleShow() {
    this.showPassword = !this.showPassword;
}
</script>

<template>
    <Head title="Connexion" />
    <form class="w-full h-full" @submit.prevent="submit">
        <AuthBackground class="w-96 md:w-2/5"/>
        <Logo class="absolute top-8 left-10" />
        <p class="absolute text-3xl text-white top-24 md:top-52 left-8">Bienvenue</p>
        <p class="absolute text-2xl top-72 left-5">
            <b>Connexion</b>
        </p>
        <div class="absolute top-[21rem] w-full">
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
                    <div class="absolute right-0 px-8 py-5" @click="toggleShow()">
                        <EyeIcon v-if="!showPassword" />
                        <HiddenEyeIcon v-else />
                    </div>
                </div>
                <Link href="/register" class="mt-5 text-app">
                    <p>Pas encore de compte ?</p>
                </Link>
                <Button class="flex items-center justify-between w-full py-6 mt-6"
                    ><p>Se connecter</p>
                    <ButtonRightArrowIcon
                /></Button>
            </div>
        </div>
    </form>
</template>
