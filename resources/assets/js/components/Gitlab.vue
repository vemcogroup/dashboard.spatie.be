<template>
    <tile :position="position" modifiers="overflow">
        <section class="statistics">
            <h1>GitLab</h1>
            <ul>
                <li class="statistic">
                    <span class="statistic__label">Issues</span>
                    <span class="statistic__count">{{ formatNumber(issues) }}</span>
                </li>
                <li class="statistic">
                    <span class="statistic__label">Merge Requests</span>
                    <span class="statistic__count">{{ formatNumber(mergeRequests) }}</span>
                </li>
            </ul>
        </section>
    </tile>
</template>

<script>
import { formatNumber } from '../helpers';
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
            issues: 0,
            mergeRequests: 0,
        };
    },

    methods: {
        formatNumber,

        getEventHandlers() {
            return {
                'GitLab.TotalsFetched': response => {
                    this.issues = response.issues;
                    this.mergeRequests = response.mergeRequests;
                },
            };
        },

        getSaveStateConfig() {
            return {
                cacheKey: 'gitlab',
            };
        },
    },
};
</script>
