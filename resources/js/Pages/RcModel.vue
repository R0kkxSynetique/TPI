<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import MoreIcon from '@/Components/icons/MoreIcon.vue';
import SideBarMenu from '@/Components/SideBarMenu.vue';
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue';
import moment from 'moment';

defineProps({
    rcModel: Object,
    flights: Object,
});

function destroy(id) {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce modèle ?')) {
        router.delete('/rc-models/' + id);
    }
}
</script>
<template>
    <Head :title="rcModel.name"></Head>

    <div
        class="h-[14rem] rounded-b-[4rem] bg-gradient-to-br from-gradientfrom to-gradientto text-white text-2xl w-full">
        <div>
            <div class="flex items-center justify-between px-8 pt-8">
                <SideBarMenu />
            </div>
            <div class="flex items-center justify-center w-full -mt-6">
                <img
                    class="aspect-square w-40 rounded-[2rem] overflow-hidden object-cover"
                    :src="`/image/rcModel/${rcModel.id}`"
                    :alt="rcModel.name" />
            </div>
        </div>
    </div>
    <div class="mx-5 mt-3 [&>div>h1]:text-xl [&>div>h1]:text-app [&>div]:pt-4 pb-5">
        <div>
            <h1 class="max-w-full truncate">{{ rcModel.name }}</h1>
            <p class="max-w-full truncate">
                <i v-if="rcModel.manufacturer"> {{ rcModel.manufacturer }} </i>
            </p>
        </div>
        <div v-if="rcModel.description">
            <h1>Descritpion</h1>
            <p>{{ rcModel.description }}</p>
        </div>
        <div>
            <h1>Caractéristiques</h1>
            <p>
                Envergure:
                {{ rcModel.wingSpan ? rcModel.wingSpan + ' mm' : '-' }}
            </p>
            <p>
                Poids:
                {{ rcModel.weight ? rcModel.weight / 1000 + ' Kg' : '-' }}
            </p>
            <p>Longueur: {{ rcModel.length ? rcModel.length + ' mm' : '-' }}</p>
            <p>Hauteur: {{ rcModel.height ? rcModel.height + ' mm' : '-' }}</p>
            <div v-if="rcModel.engines.length > 0">
                <div v-if="rcModel.engines.length > 1">
                    <p>Moteurs:</p>
                    <!-- todo: Do it as one line with a coma to separate the engines -->
                    <p v-for="engine in rcModel.engines">
                        {{ engine.pivot.quantity + 'x ' + engine.name + ' ' + engine.power }}
                    </p>
                </div>
                <div v-else-if="rcModel.engines[0].pivot.quantity > 1">
                    <p>
                        Moteurs:
                        {{
                            rcModel.engines[0].pivot.quantity +
                            'x ' +
                            rcModel.engines[0].name +
                            ' ' +
                            rcModel.engines[0].power
                        }}
                    </p>
                </div>
                <div v-else>
                    <p>
                        Moteur:
                        {{ rcModel.engines[0].name + ' ' + rcModel.engines[0].power }}
                    </p>
                </div>
                <div>
                    <p>Type: {{ rcModel.engines[0].type }}</p>
                    <!-- todo: select the type based on all the engines -->
                </div>
            </div>
            <div v-if="rcModel.propellers.length > 0">
                <div v-if="rcModel.propellers.length > 1">
                    <p>Helices:</p>
                    <p v-for="propeller in rcModel.propellers">
                        {{
                            propeller.pivot.quantity +
                            'x "' +
                            propeller.size +
                            '" ' +
                            propeller.type
                        }}
                    </p>
                </div>
                <div v-else-if="rcModel.propellers[0].pivot.quantity > 1">
                    <p>
                        Hélices:
                        {{
                            rcModel.propellers[0].pivot.quantity +
                            'x "' +
                            rcModel.propellers[0].size +
                            '" ' +
                            rcModel.propellers[0].type
                        }}
                    </p>
                </div>
                <div v-else>
                    <p>
                        Hélice:
                        {{ rcModel.propellers[0].size + ' ' + rcModel.propellers[0].type }}
                    </p>
                </div>
            </div>
            <div v-if="rcModel.batteries.length > 0">
                <div v-if="rcModel.batteries.length > 1">
                    <p>Batteries:</p>
                    <div v-for="battery in rcModel.batteries">
                        <p>
                            {{
                                battery.pivot.quantity +
                                'x ' +
                                battery.capacity +
                                'mAh ' +
                                battery.type
                            }}
                        </p>
                    </div>
                </div>
                <div v-else-if="rcModel.batteries[0].pivot.quantity > 1">
                    <p>
                        Batteries:
                        {{
                            rcModel.batteries[0].pivot.quantity +
                            'x ' +
                            rcModel.batteries[0].capacity +
                            'mAh ' +
                            rcModel.batteries[0].type
                        }}
                    </p>
                </div>
                <div v-else>
                    <p>
                        Batterie:
                        {{ rcModel.batteries[0].capacity + 'mAh ' + rcModel.batteries[0].type }}
                    </p>
                </div>
            </div>
        </div>
        <div v-if="rcModel.acquired_on || rcModel.finished_on || rcModel.first_flown_on">
            <h1>Historique</h1>
            <p v-if="rcModel.acquired_on">
                Acquis le : {{ moment(rcModel.acquired_on).format('DD.MM.yyyy') }}
            </p>
            <p v-if="rcModel.finished_on">
                Fini le: {{ moment(rcModel.finished_on).format('DD.MM.yyyy') }}
            </p>
            <p v-if="rcModel.first_flown_on">
                Mis en service le: {{ moment(rcModel.first_flown_on).format('DD.MM.yyyy') }}
            </p>
        </div>
        <div v-if="rcModel.transmitter">
            <h1>Radiocommande</h1>
            <p>
                {{ rcModel.transmitter.manufacturer + ' ' + rcModel.transmitter.name }}
            </p>
        </div>
        <div>
            <h1>Vols</h1>
            <p>Nombre de vols: {{ flights.quantity }}</p>
        </div>
    </div>
</template>
