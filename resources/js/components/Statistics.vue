<template>
    <tile :position="position">
        <section>
            <h1>Packagist</h1>
            <ul class="align-self-center">
                <li class="flex justify-between border-b-2 py-1 border-grey-darker">
                    <span v-html="emoji('✨')"></span>
                    <span class="gold">{{ formatNumber(packagistStars) }}</span>
                </li>
                <li class="flex justify-between border-b-2 py-1 border-grey-darker">
                    <span>24 hours</span>
                    <span class="gold">{{ formatNumber(packagistDaily) }}</span>
                </li>
                <li class="flex justify-between border-b-2 py-1 border-grey-darker">
                    <span>30 days</span>
                    <span class="gold">{{ formatNumber(packagistMonthly) }}</span>
                </li>
                <li class="flex justify-between border-b-2 py-1 border-grey-darker">
                    <span>Total</span>
                    <span class="gold">{{ formatNumber(packagistTotal) }}</span>
                </li>
            </ul>

        </section>
    </tile>
</template>

<script>
import { emoji, formatNumber } from '../helpers';
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
            githubIssues: 0,
            githubPullRequests: 0,
            githubContributors: 0,

            packagistStars: 0,
            packagistTotal: 0,
            packagistDaily: 0,
            packagistMonthly: 0,
        };
    },

    methods: {
        emoji,
        formatNumber,

        getEventHandlers() {
            return {
                'Statistics.GitHubTotalsFetched': response => {
                    this.githubIssues = response.issues;
                    this.githubPullRequests = response.pullRequests;
                    this.githubContributors = response.contributors;
                },

                'Statistics.PackagistTotalsFetched': response => {
                    this.packagistStars = response.stars;
                    this.packagistTotal = response.total;
                    this.packagistDaily = response.daily;
                    this.packagistMonthly = response.monthly;
                },
            };
        },

        getSaveStateConfig() {
            return {
                cacheKey: 'statistics',
            };
        },
    },
};
</script>
