<template>
    <tile :position="position" modifiers="overflow">
        <section>
            <ul class="stats__group" v-for="(group ,index) in stats" :key="index">
                <div class="stats__title" v-if="group.showTitle">{{ group.label }}</div>
                <li v-for="stat in group.stats" class="statistic" v-if="group.showEmpty || stat.value > 0">
                    <div class="stats__sub_title">
                        {{ stat.name }}
                    </div>
                    <div class="stats__count">
                        {{ stat.value }}
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
