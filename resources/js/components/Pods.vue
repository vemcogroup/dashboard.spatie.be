<template>
    <tile :position="position" modifiers="overflow">
        <section>
            <h1>K8s</h1>
            <ul v-for="(group ,index) in stats" v-if="group.stats.length" :key="index">
                <li v-for="stat in group.stats" class="flex justify-between py-1 border-b-2 border-grey-darker">
                    {{ stat.name }}
                    <div class="gold">{{ stat.value }}</div>
                </li>
            </ul>
        </section>
    </tile>
</template>

<script>
import echo from '../mixins/echo';
import Tile from './atoms/Tile';
import saveState from 'vue-save-state';

export default {
    components: {
        Tile,
    },

    mixins: [echo, saveState],

    props: ['position'],

    data() {
        return {
            stats: [],
        };
    },

    methods: {
        getEventHandlers() {
            return {
                'Stats.PodsFetched': response => {
                    this.stats = response.stats;
                },
            };
        },

        getSaveStateConfig() {
            return {
                cacheKey: 'stats',
            };
        },
    },
};
</script>
