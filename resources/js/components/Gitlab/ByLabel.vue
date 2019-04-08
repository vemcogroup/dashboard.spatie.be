<template>
    <tile :position="position" modifiers="overflow">
        <section>
            <h1>{{ label }} ({{ tasks.length }})</h1>
            <ul>
                <li class="border-b-2 py-3 border-grey-darker" v-for="task in orderedTasks">
                    <div class="flex justify-between mb-1">
                        <span class="uppercase">{{ task.title }}</span>
                        <div class="gold">#{{ task.id }}</div>
                    </div>
                    <div class="flex justify-between">
                        <div>
                            <div class="weight" v-if="task.weight">
                                {{ task.weight }}
                            </div>
                            <div class="badge" v-if="task.milestone && task.milestoneColor" :style="'background-color: ' + task.milestoneColor">
                                MS
                            </div>
                            <div class="badge" v-else-if="task.milestone">
                                {{ task.milestone }}
                            </div>
                            <div v-for="(type, index) in task.types" :key="index" class="badge bg-blue-dark">
                                {{ type }}
                            </div>
                            <div v-for="(tag, index) in task.tags" :key="index" class="badge bg-blue-dark">
                                {{ tag }}
                            </div>
                        </div>
                        <div v-if="showAssignees">
                            <div v-for="(member, index) in task.teamMember" :key="index"class="inline-block">
                                <img v-if="member.avatar"
                                     class="member"
                                     :src="member.avatar"
                                     :alt="member.username"
                                     :title="member.username"/>
                            </div>
                        </div>
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

<script>
import echo from '../../mixins/echo';
import Tile from '../atoms/Tile';
import saveState from 'vue-save-state';
import moment from 'moment';

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
                    this.tasks = response.tasks[this.label] ? response.tasks[this.label] : [];
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
        },
        date(date) {
            return moment(date).fromNow();
        },
    },
    computed: {
        orderedTasks() {
            if(this.orderBy === 'weight') {
                return this.tasks.sort((a, b) => {
                    if(a.weight > b.weight) return -1;
                    if(a.weight < b.weight) return 1;
                    if(a.id < b.id) return -1;
                    if(a.id > b.id) return 1;

                    return 0;
                });
            }

            return this.tasks;
        }
    }
};
</script>
