<template>
    <tile :position="position" modifiers="overflow">
        <section class="calendar">
            <h1 class="calendar__title">APIs</h1>
            <ul class="calendar__events">
                <li v-for="api in status" class="statistic" v-show="api.value > 0">
                    <div class="statistic__label">
                        {{ api.name }}
                    </div>
                    <div class="statistic__count">
                        {{ api.value }}
                    </div>
                </li>
            </ul>
        </section>
    </tile>
</template>

<script>
import echo from '../mixins/echo';
import Tile from './atoms/Tile';
import saveState from 'vue-save-state';
import { relativeDate } from '../helpers';

export default {
    components: {
        Tile,
    },

    mixins: [echo, saveState],

    props: ['position'],

    data() {
        return {
            status: [],
        };
    },

    methods: {
        getEventHandlers() {
            return {
                'Apis.StatusFetched': response => {
                    this.status = response.status;
                },
            };
        },

        getSaveStateConfig() {
            return {
                cacheKey: 'apis',
            };
        },
    },
};
</script>
