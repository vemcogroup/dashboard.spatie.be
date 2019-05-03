<template>
    <tile :position="position" modifiers="overflow">
        <section>
            <h1>Services</h1>

            <table class="w-full text-lg">
                <tr>
                    <th class="py-3 text-left">Name</th>
                    <th class="text-right w-24">Status</th>
                </tr>
                <tr class="border-b-2 py-3 border-grey-darker" v-for="service in services">
                    <td class="py-2">{{ service.name }}</td>
                    <td class="py-2 text-right gold">
                        <button v-if="! loading" @click="restart(service)" class="text-xs p-2 bg-blue text-white rounded ml-2">Restart</button>
                        <span v-else> wait </span>
                    </td>
                </tr>
            </table>

        </section>
    </tile>
</template>

<script>
import echo from '../mixins/echo';
import Tile from './atoms/Tile';
import saveState from 'vue-save-state';
import axios from 'axios';

import moment from 'moment';

export default {
    components: {
        Tile,
    },

    mixins: [echo, saveState],

    props: ['position'],

    data() {
        return {
            services: [],
            loading: false,
        };
    },

    methods: {
        getEventHandlers() {
            return {
                'Services.UpdateServices': response => {
                    this.services = response.services ? response.services : [];
                },
            };
        },
        getSaveStateConfig() {
            return {
                cacheKey: `services`,
            };
        },
        restart(service) {
            this.loading = true;
            axios.post('/services/restart', {
                'service': service.name,
            }).then((response) => {
                this.loading = false;
                console.log(response);
            }).catch((error) => {
                this.loading = false;
                console.log(error);
            });
        }
    },
};
</script>
