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

const fileInput = ref();
const user = usePage().props.auth.user;
const file = useForm({ image: null });
const form = useForm({ user: null });
const toast = useToast();
const { preview, updatePreview, clearPreview } = useImagePreview(fileInput);
const saved = ref(false);
const openDelete = ref(false);

form.user = user;

function updateImage(id) {
    if (fileInput.value) {
        file.image = fileInput.value.files ? fileInput.value.files[0] : null;
        file.post('/image/user/' + id);
    }
}

function destroy(id) {
    if (id) {
        router.delete('/user/' + id, {
            onSuccess: () => {
                router.post('/logout');
            },
        });
    } else {
        toast.error('Une erreur est survenue lors de la suppression de votre compte.');
    }
}

const submit = () => {
    form.put(`/user/${user.id}`);
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
                    <div
                        class="grid items-center justify-center grid-cols-2 gap-3 place-items-center">
                        <button
                            id="saveButton"
                            class="flex items-center justify-center transition-all rounded-full shadow-lg drop-shadow text-app disabled:bg-slate-200 disabled:text-gray-500 disabled:cursor-not-allowed disabled:opacity-60"
                            :class="[
                                saved ? 'bg-Valid w-5 p-8 hover:cursor-default' : 'w-full py-5',
                            ]"
                            :disabled="
                                !form.user.username ||
                                !form.user.firstname ||
                                !form.user.lastname ||
                                !form.user.birthdate
                            "
                            @click="saved = !saved">
                            <p v-if="!saved">Sauvegarder</p>
                            <CheckIcon v-else class="absolute z-10 text-white w-7" />
                        </button>
                        <Link
                            :href="'/user/' + user.id + '/change-password'"
                            class="flex items-center justify-center w-full py-5 transition-all rounded-full shadow-lg text-app drop-shadow">
                            <p>Changer de mot de passe</p>
                        </Link>
                    </div>
                    <button
                        @click="openDelete = true"
                        class="flex items-center justify-center w-full py-5 text-white transition-all rounded-full shadow-lg drop-shadow bg-Error hover:bg-red-600">
                        <p>Supprimer mon compte</p>
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div>
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
                                                Êtes-vous sûr de vouloir supprimer votre compte ?
                                            </DialogTitle>
                                            <div class="w-full mt-2 text-sm">
                                                Cette action est
                                                <strong>irréversible</strong>.<br />
                                                Une fois confirmé, votre compte sera supprimé et
                                                vous ne pourrez plus vous y connecter. <br />Vous
                                                perdrez également tous vos modèles, batteries,
                                                moteurs, etc...
                                                <strong
                                                    ><br />Merci de bien réfléchir avant de
                                                    confirmer.</strong
                                                >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="px-4 py-3 bg-gray-50 sm:flex sm:flex-row-reverse sm:px-6">
                                    <button
                                        type="button"
                                        class="inline-flex justify-center w-full px-3 py-2 text-sm font-semibold text-white rounded-md shadow-sm bg-Error hover:bg-red-600 sm:ml-3 sm:w-auto"
                                        @click="destroy(user.id)">
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
