import './bootstrap.js';

import Echo from 'laravel-echo';
import Vue from 'vue';

import Twitter from './components/Twitter';
import TileTimer from './components/TileTimer';
import Dashboard from './components/Dashboard';
import Statistics from './components/Statistics';
import TimeWeather from './components/TimeWeather';
import InternetConnection from './components/InternetConnection';

import Stats from './components/Stats';
import RssFeed from './components/RssFeed';
import GitlabTotals from './components/Gitlab/Totals';
import GitlabLabels from './components/Gitlab/ByLabel';
import GitlabMilestones from './components/Gitlab/Milestones';

new Vue({
    el: '#dashboard',

    components: {
        Dashboard,
        Statistics,
        InternetConnection,
        TimeWeather,
        Twitter,
        TileTimer,

        Stats,
        RssFeed,
        GitlabLabels,
        GitlabMilestones,
        GitlabTotals,
    },

    created() {

        let options = {
            broadcaster: 'pusher',
            key: window.dashboard.socketAppKey,
            cluster: window.dashboard.socketCluster,
            encrypted: window.dashboard.socketEncrypted,
        };
        if(window.dashboard.socketHost) {
            options.cluster = '';
            options.encrypted = window.dashboard.socketEncrypted;
            options.disableStats = window.dashboard.socketDisableStats;
            options.wsHost = window.dashboard.socketHost;
            options.wsPort = window.dashboard.socketPort;
            options.wssPort = window.dashboard.socketSecurePort;
            options.disableStats = true;
        };

        this.echo = new Echo(options);
    },
});
