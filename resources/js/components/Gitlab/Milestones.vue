<template>
    <tile :position="position" modifiers="overflow">
        <section>
            <h1>Releases</h1>
            <ul>
                <li class="border-b-2 py-3 border-grey-darker" v-for="milestone in orderedMilestones">
                    <div class="flex justify-between">
                        <div class="">
                            <div class="inline-block uppercase">
                                <div class="inline-block w-3 h-3" :style="'border-radius: 20px; background-color:' + milestone.color"></div>
                                {{ milestone.title }}
                            </div>
                            <div v-if="milestone.issues.bugs" class="badge pl-3 pr-3 text-xs bg-red-dark rounded-full">
                                {{ milestone.issues.bugs }}
                            </div>
                        </div>
                        <div>
                            <div class="gold">{{ milestone.issues.percent }}%</div>
                        </div>
                    </div>
                    <div class="flex text-xs">
                        <div class="w-2/3">{{ date(milestone.dueDate) }} - ({{ dateFormat(milestone.dueDate) }})</div>
                        <div class="w-1/3 text-right">Tasks: {{ milestone.issues.total }}</div>
                    </div>
                    <div class="h-1 bg-green-dark" :style="'width:' + milestone.issues.percent + '%'"></div>
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
    import moment from 'moment';

    export default {
    components: {
        Tile,
    },

    mixins: [echo, saveState],

    props: ['position'],

    data() {
        return {
            milestones: [],
        };
    },

    methods: {
        getEventHandlers() {
            return {
                'GitLab.MilestonesFetched': response => {
                    this.milestones = response.milestones;
                },
            };
        },

        getSaveStateConfig() {
            return {
                cacheKey: `gitlab-milestones`,
            };
        },
        toHours(seconds) {
            return seconds ? Math.round(seconds/60/60): 0;
        },
        date(date) {
            return moment(date).fromNow();
        },
        dateFormat(date) {
            return moment(date).format('D-M-Y')
        }
    },
    computed: {
        orderedMilestones() {
            return this.milestones.sort((a, b) => {

                let aDueDate = moment(a.dueDate);
                let bDueDate = moment(b.dueDate);

                if(aDueDate.isBefore(bDueDate)) return -1;
                if(aDueDate.isAfter(bDueDate)) return 1;

                return 0;
            });
        },
    }
};
</script>
