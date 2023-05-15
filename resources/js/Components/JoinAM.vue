<script setup>
import { Link } from '@inertiajs/vue3';
import { useToast } from 'vue-toastification';
const toast = useToast();
</script>

<template>
    <div class="flex flex-col items-center">
        <span>Rejoignez nous sur Aeromodel!</span>
        <Link
            class="text-lg underline"
            href="/register"
            @click="toast.dismiss('join-am')"
            target="_blank"
            >M'inscrire</Link
        >
    </div>
</template>
