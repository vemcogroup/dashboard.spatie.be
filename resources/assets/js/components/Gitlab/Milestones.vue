<template>
    <tile :position="position" modifiers="overflow">
        <section class="gitlab">
            <h1 class="gitlab__title">Planned releases</h1>
            <ul>
                <li class="gitlab-issue__content" v-for="milestone in orderedMilestones">
                    <div class="statistic">
                        <div class="gitlab-milestone__title">
                            <div class="gitlab-milestone__text">
                                <div class="gitlab-milestone__color" :style="'background-color:' + milestone.color"></div>
                                {{ milestone.title }}
                            </div>
                            <div class="gitlab-issue__weight">{{ date(milestone.dueDate) }}</div>
                        </div>
                        <div>
                            <div class="statistic__count">{{ milestone.issues.percent }}%</div>
                        </div>
                    </div>
                    <div class="statistic">
                        <span></span>
                        <span class="gitlab-issue__sub_title">
                             Tasks: {{ milestone.issues.total }}
                        </span>
                    </div>
                    <div class="gitlab-milestone__progress" :style="'width:' + milestone.issues.percent + '%'"></div>
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
    },
    computed: {
        orderedMilestones() {
            return this.milestones.sort((a, b) => {

                let aDueDate = moment(a.dueDate);
                let bDueDate = moment(b.dueDate);
                console.log(aDueDate + ' / ' + bDueDate);
                console.log(aDueDate.isBefore(bDueDate) + ' / ' + aDueDate.isAfter(bDueDate));

                if(aDueDate.isBefore(bDueDate)) return -1;
                if(aDueDate.isAfter(bDueDate)) return 1;

                return 0;
            });
        },
    }
};
</script>
