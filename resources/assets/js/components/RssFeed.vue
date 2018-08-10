<template>
    <tile :position="position" modifiers="overflow">
        <section class="feeds" v-if="feeds.length">
            <transition name="fade" tag="div" mode="out-in">
                <div class="feed">
                    <span class="feed__date">{{ date(feed.date) }}</span>
                    <span class="feed__date">{{ feed.type }}</span>
                    <span class="feed__title">{{ feed.title }}</span>
                </div>
            </transition>
        </section>
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
        transition: opacity 1s
    }
    .fade-enter, .fade-leave-to {
        opacity: 0
    }
</style>
