<template>
    <tile :position="position" modifiers="overflow">
        <section>
            <ul v-for="(group ,index) in stats" v-if="group.stats.length" :key="index">
                <div class="uppercase px-2 py-1 mt-1 bg-blue-darker" v-if="group.showTitle">{{ group.label }}</div>
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
                'Stats.StatsFetched': response => {
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
