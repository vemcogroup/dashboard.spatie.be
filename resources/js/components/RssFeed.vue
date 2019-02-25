<template>
    <tile :position="position" modifiers="overflow">
        <transition name="fade" tag="section" mode="out-in">
            <section class="flex h-full w-full justify-between items-center content-center" v-if="feeds.length" :key="feed.date">
                <div class="flex">
                    <div class="badge bg-blue-darker">{{ date(feed.date) }}</div>
                    <div class="badge uppercase bg-blue-darker">{{ feed.type }}</div>
                </div>
                <div class="flex-1 mr-2 truncate">{{ feed.title }}</div>
                <div>{{ current+1 }}/{{ orderedFeeds.length }}</div>
            </section>
        </transition>
    </tile>
</template>

<script>
import echo from '../mixins/echo';
import Tile from './atoms/Tile';
import moment from 'moment';
import saveState from 'vue-save-state';

export default {
    components: {
        Tile,
    },

    mixins: [echo, saveState],

    props: ['position'],

    data() {
        return {
            feeds: [],
            current: 0,
        };
    },
    created: function() {
        this.current = 0;
        setInterval(this.update, 15000);
    },
    methods: {
        update() {
            this.current++;
            if(!this.orderedFeeds[this.current]) {
                this.reset();
            }
        },
        reset() {
            this.current = 0;
        },
        getEventHandlers() {
            return {
                'Feeds.FeedsFetched': response => {
                    this.reset();
                    this.feeds = response.feeds;
                },
            };
        },

        getSaveStateConfig() {
            return {
                cacheKey: 'feeds',
            };
        },
        date(date) {
            return moment(date).fromNow();
        }
    },
    computed: {
        feed() {
            return this.orderedFeeds[this.current];
        },
        orderedFeeds() {
            return this.feeds.sort((a, b) => {
                if(a.date > b.date) return -1;
                if(a.date < b.date) return 1;

                return 0;
            });
        }
    },
};
</script>

<style scoped>
    .fade-enter-active, .fade-leave-active {
        transition: opacity 0.5s
    }
    .fade-enter, .fade-leave-to {
        opacity: 0
    }
</style>
