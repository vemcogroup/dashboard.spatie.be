<template>
    <tile :position="position" modifiers="overflow">
        <section>
            <h1>Offline sensors ({{ count }})</h1>
            <table class="w-full text-lg">
                <tr>
                    <th class="py-3 text-left">Name</th>
                    <th class="text-right w-16">Amount</th>
                </tr>
                <tr class="border-b-2 py-3 border-grey-darker" v-for="sensor in orderedByAmount">
                    <td class="py-2">{{ sensor.name }}</td>
                    <td class="text-right gold">{{ sensor.amount }}</td>
                </tr>
            </table>
        </section>
    </tile>
</template>

<script>
import echo from '../mixins/echo';
import Tile from './atoms/Tile';
import saveState from 'vue-save-state';
import moment from 'moment';

export default {
    components: {
        Tile,
    },

    mixins: [echo, saveState],

    props: ['position'],

    data() {
        return {
            sensors: [],
        };
    },

    methods: {
        getEventHandlers() {
            return {
                'Stats.UpdateSensorsOffline': response => {
                    this.sensors = response.sensors ? response.sensors : [];
                },
            };
        },
        getSaveStateConfig() {
            return {
                cacheKey: `stats-sensors-offline`,
            };
        },
        toHours(seconds) {
            return seconds ? Math.round(seconds/60/60): 0;
        },
        date(date) {
            return moment(date).fromNow();
        },
    },
    computed: {
        orderedByAmount() {
            return this.sensors.sort((a, b) => {
                if (a.amount >= b.amount) return -1;
                if (a.amount < b.amount) return 1;
            })
        },
        count() {
            return this.sensors.reduce((prev, sensor) => prev + sensor.amount, 0);
        }
    }
};
</script>
