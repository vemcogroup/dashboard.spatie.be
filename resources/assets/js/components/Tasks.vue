<template>
    <tile :position="position" modifiers="overflow">
        <section class="github-file">
            <h1 class="github-file__title">{{ teamMember }}</h1>
            <div class="github-file__content" v-for="task in tasks">
                <ul>
                    <li class="statistic" style="justify-content: inherit;">
                        <span class="statistic__count" style="margin-right: 5px;">#{{ task.id }}</span>
                        <span class="statistic__label">{{ task.title }}</span>
                    </li>
                </ul>
            </div>
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

    props: ['teamMember', 'position'],

    data() {
        return {
            tasks: '',
        };
    },

    methods: {
        getEventHandlers() {
            return {
                'Tasks.TasksFetched': response => {
                    this.tasks = response.tasks[this.teamMember];
                },
            };
        },

        getSaveStateConfig() {
            return {
                cacheKey: `tasks-${this.teamMember}`,
            };
        },
    },
};
</script>
