<template>
    <tile :position="position" modifiers="overflow">
        <section>
            <h1 :class="labelClasses" v-html="title"></h1>
            <ul>
                <li class="text-grey" v-if="! tasks.length">
                    No bugs reported
                </li>
                <li class="border-b-2 py-2 border-grey-darker" v-for="task in orderedTasks">
                    <div class="flex justify-between mb-1">
                        <span class="uppercase truncate">
                            <div v-if="task.milestoneColor" class="inline-block w-3 h-3" :style="'border-radius: 20px; background-color:' + task.milestoneColor"></div>
                            {{ task.title }}
                        </span>
                        <div class="pl-2 gold">#{{ task.id }}</div>
                    </div>
                    <div class="flex justify-between">
                        <div>
                            <div class="priority" v-if="task.priority">
                                {{ task.priority }}
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
                    <div v-if="task.hasTasks" class="h-1 mt-2 bg-green-dark" :style="'width: ' +  parseInt(task.tasksPercentage) +  '%'"></div>
                </li>
            </ul>
        </section>
    </tile>
</template>

<script>
import { emoji } from '../../helpers';
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
        title() {
          let label = this.label === 'Bug patrol' ? emoji('🐛') + ' '  + this.label : this.label;

            return label + ' (' + this.tasks.length + ')'
        },
        labelClasses() {
          return [
              this.label === 'Bug patrol' && this.tasks.length ? 'text-red' : ''
          ]
        },

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
