<script setup>
import { Head, Link, usePage, useForm } from '@inertiajs/vue3';
import SideBarMenu from '@/Components/SideBarMenu.vue';
import PlusIcon from '@/Components/icons/PlusIcon.vue';
import UserBackground from '@/Components/BackGrounds/UserBackground.vue';
import { useImagePreview } from '@/lib/image';
import { ref } from 'vue';
import { CheckIcon } from '@heroicons/vue/20/solid';

const fileInput = ref();
const user = usePage().props.auth.user;
const file = useForm({ image: null });
const form = useForm({ user: null });
const { preview, updatePreview, clearPreview } = useImagePreview(fileInput);
const saved = ref(false);

form.user = user;

function updateImage(id) {
    if (fileInput.value) {
        file.image = fileInput.value.files ? fileInput.value.files[0] : null;
        file.post('/image/user/' + id);
    }
}

const submit = () => {
    form.put(`/user/${user.id}/settings`);
};
</script>
<template>
    <Head title="Paramètres" />
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
                <div
                    v-if="preview"
                    class="w-20 overflow-hidden bg-center bg-cover rounded-full aspect-square"
                    @click="$refs.fileInput.click()"
                    :style="{
                        backgroundImage: `url('${preview}')`,
                    }" />
                <img
                    v-else
                    class="object-cover w-20 overflow-hidden rounded-full aspect-square"
                    :src="`/image/user/${user.id}`"
                    :alt="user.username"
                    @click="$refs.fileInput.click()" />
                <input
                    type="file"
                    ref="fileInput"
                    accept="image/*"
                    @change="updatePreview"
                    class="hidden" />
                <button @click="updateImage(user.id)">Appliquer</button>
            </div>
            <form @submit.prevent="submit">
                <div class="[&>div>p]:text-sm [&>div>input]:text-app flex flex-col gap-4">
                    <div>
                        <p>Nom d'utilisateur</p>
                        <input
                            type="text"
                            v-model="form.user.username"
                            placeholder=""
                            @keydown="saved = false"
                            required
                            class="w-full p-0 py-2 border-t-0 border-l-0 border-r-0 border-b-app focus:ring-0" />
                    </div>
                    <div>
                        <p>Prénom</p>
                        <input
                            type="text"
                            v-model="form.user.firstname"
                            placeholder=""
                            @keydown="saved = false"
                            required
                            class="w-full p-0 py-2 border-t-0 border-l-0 border-r-0 border-b-app focus:ring-0" />
                    </div>
                    <div>
                        <p>Nom</p>
                        <input
                            type="text"
                            v-model="form.user.lastname"
                            placeholder=""
                            @keydown="saved = false"
                            required
                            class="w-full p-0 py-2 border-t-0 border-l-0 border-r-0 border-b-app focus:ring-0" />
                    </div>
                    <div>
                        <p>Date de naissance</p>
                        <input
                            type="date" 
                            v-model="form.user.birthdate"
                            @change="saved = false"
                            required
                            class="w-full p-0 py-2 border-t-0 border-l-0 border-r-0 border-b-app focus:ring-0" />
                    </div>
                    <div class="flex items-center justify-center">
                        <button
                            id="saveButton"
                            class="flex items-center justify-center transition-all rounded-full shadow-lg drop-shadow text-app disabled:bg-slate-200 disabled:text-gray-500 disabled:cursor-not-allowed disabled:opacity-60"
                            :class="[saved ? 'bg-Valid w-5 p-8 hover:cursor-default' : 'w-full py-5']"
                            :disabled="!form.user.username || !form.user.firstname || !form.user.lastname || !form.user.birthdate"
                            @click="saved = !saved">
                            <p v-if="!saved">Sauvegarder</p>
                            <CheckIcon v-else class="absolute z-10 text-white w-7" />
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>
