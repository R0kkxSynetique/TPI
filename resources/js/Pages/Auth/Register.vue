<script setup>
import { Head, useForm, Link } from "@inertiajs/vue3";
import AuthBackground from "@/Components/BackGrounds/AuthBackground.vue";
import Logo from "@/Components/icons/Logo.vue";
import EyeIcon from "@/Components/icons/EyeIcon.vue";
import HiddenEyeIcon from "@/Components/icons/HiddenEyeIcon.vue";
import Button from "@/Components/Button.vue";
import ButtonRightArrowIcon from "@/Components/icons/ButtonRightArrowIcon.vue";

const form = useForm({
    lastname: "",
    firstname: "",
    birthdate: "",
    email: "",
    username: "",
    password: "",
});

const submit = () => {
    form.post("/register");
};
</script>

<template>
    <Head title="Création de compte" />
    <form class="w-full h-full" @submit.prevent="submit">
        <AuthBackground>
            <template v-slot:logo>
                <Logo class="absolute top-9 left-10" />
            </template>
            <template v-slot:header>
                <p class="absolute text-3xl text-white top-28 left-8">Bienvenue</p>
            </template>
        </AuthBackground>
        <p class="absolute text-2xl top-72 left-5">
            <b>Création de compte</b>
        </p>
        <div class="absolute top-[21rem] w-full [&>*]:my-5 ">
            <div class="flex flex-col items-start mx-5">
                <label for="username-input" class="text-gray-400"
                    >Nom d'utilisateur</label
                >
                <input
                    id="username"
                    v-model="form.username"
                    type="text"
                    name="username-input"
                    required
                    placeholder="R0kkxSynetique"
                    class="w-full p-0 py-2 border-t-0 border-l-0 border-r-0 text- border-b-app"
                />
            </div>
            <div class="flex flex-col items-start mx-5">
                <label for="name-input" class="text-gray-400"
                    >Nom de famille</label
                >
                <input
                    id="name"
                    v-model="form.lastname"
                    type="text"
                    name="name-input"
                    required
                    placeholder="Fontana"
                    class="w-full p-0 py-2 border-t-0 border-l-0 border-r-0 text- border-b-app"
                />
            </div>
            <div class="flex flex-col items-start mx-5">
                <label for="firstname-input" class="text-gray-400"
                    >Prénom</label
                >
                <input
                    id="firstname"
                    v-model="form.firstname"
                    type="text"
                    name="firstname-input"
                    required
                    placeholder="Benjamin"
                    class="w-full p-0 py-2 border-t-0 border-l-0 border-r-0 text- border-b-app"
                />
            </div>
            <div class="flex flex-col items-start mx-5">
                <label for="birthdate-input" class="text-gray-400"
                    >Date de naissance</label
                >
                <input
                    id="birthdate"
                    v-model="form.birthdate"
                    type="date"
                    name="birthdate-input"
                    required
                    class="w-full p-0 py-2 border-t-0 border-l-0 border-r-0 text- border-b-app"
                />
            </div>
            <div class="flex flex-col items-start mx-5">
                <label for="email-input" class="text-gray-400"
                    >Adresse email</label
                >
                <input
                    id="email"
                    v-model="form.email"
                    type="email"
                    name="email-input"
                    required
                    placeholder="benjamin@r0kkxsynetique.ch"
                    class="w-full p-0 py-2 border-t-0 border-l-0 border-r-0 text- border-b-app"
                />
            </div>
            <div class="flex flex-col items-start mx-5 mt-3">
                <label for="email-input" class="text-gray-400"
                    >Mot de passe</label
                >
                <div class="flex items-center w-full">
                    <input
                        v-if="showPassword"
                        id="password"
                        v-model="form.password"
                        type="text"
                        name="password-input"
                        required
                        class="w-full p-0 py-2 border-t-0 border-l-0 border-r-0 text- border-b-app"
                    />
                    <input
                        v-else
                        id="password"
                        v-model="form.password"
                        type="password"
                        name="password-input"
                        required
                        class="w-full p-0 py-2 border-t-0 border-l-0 border-r-0 text- border-b-app"
                    />
                    <div
                        class="absolute right-0 px-8 py-5"
                        @click="toggleShow()"
                    >
                        <EyeIcon v-if="!showPassword" />
                        <HiddenEyeIcon v-else />
                    </div>
                </div>
                <Link href="/login" class="mt-5 text-app">
                    <p>Déjà un compte ?</p>
                </Link>
                <Button
                    class="flex items-center justify-between w-full py-6 mt-16"
                    ><p>Créer le compte</p>
                    <ButtonRightArrowIcon
                /></Button>
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
};
</script>
