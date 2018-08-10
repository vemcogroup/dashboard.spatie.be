<template>
    <tile :position="position" modifiers="overflow">
        <section class="gitlab">
            <h1 class="gitlab__title">{{ label }} ({{ tasks.length }})</h1>
            <ul>
                <li class="gitlab-issue__content" v-for="task in orderedTasks">
                    <div class="statistic">
                        <span class="gitlab-issue__title">{{ task.title }}</span>
                        <div>
                            <div class="statistic__count">#{{ task.id }}</div>
                        </div>
                    </div>
                    <div class="statistic">
                        <span>
                            <span class="gitlab-issue__weight" v-if="task.weight">
                                {{ task.weight }}
                            </span>
                            <span class="gitlab-issue__milestone" v-if="task.milestone">
                                {{ task.milestone }}
                            </span>
                            <span v-for="(type, index) in task.types" :key="index"class="gitlab-issue__type">
                                {{ type }}
                            </span>
                            <span v-for="(tag, index) in task.tags" :key="index"class="gitlab-issue__tag">
                                {{ tag }}
                            </span>
                        </span>
                        <span v-if="showAssignees" class="gitlab-issue__sub_title">
                            <span v-for="(member, index) in task.teamMember" :key="index"class="gitlab-issue__assigned">
                                <img v-if="member.avatar"
                                     class="gitlab-issue__assigned__avatar"
                                     :src="member.avatar"
                                     :title="member.username">
                            </span>
                        </span>
                    </div>
                    <div v-if="showTime" class="statistic">
                        <span class=""></span>
                        <span v-if="task.time.estimated" class="gitlab-issue__sub_title">
                            {{ toHours(task.time.spend) }} /
                            {{ toHours(task.time.estimated) }}h
                        </span>
                    </div>
                </li>
            </ul>
        </section>
    </tile>
</template>
w
<script>
import echo from '../../mixins/echo';
import Tile from '../atoms/Tile';
import saveState from 'vue-save-state';

export default {
    components: {
        Tile,
    },

    mixins: [echo, saveState],

    props: ['label', 'position', 'showAssignees', 'showTime', 'orderBy'],

    data() {
        return {
            tasks: [],
        };
    },

    methods: {
        getEventHandlers() {
            return {
                'GitLab.LabelsFetched': response => {
                    this.tasks = response.tasks[this.label];
                },
            };
        },

        getSaveStateConfig() {
            return {
                cacheKey: `gitlab-labels-${this.label}`,
            };
        },
        toHours(seconds) {
            return seconds ? Math.round(seconds/60/60): 0;
        }
    },
    computed: {
        orderedTasks() {
            if(this.orderBy === 'weight') {
                return this.tasks.sort((a, b) => {
                    if(a.weight > b.weight) return -1;
                    if(a.weight < b.weight) return 1;
                    if(a.id < b.id) return -1;
                    if(a.id > b./**/id) return 1;

                    return 0;
                });
            }

            return this.tasks;
        }
    }
};
</script>
