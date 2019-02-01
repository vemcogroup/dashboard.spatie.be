import './bootstrap.js';

import Echo from 'laravel-echo';
import Vue from 'vue';

import Dashboard from './components/Dashboard';
import Calendar from './components/Calendar';
import Github from './components/Github';
import GitlabTotals from './components/Gitlab/Totals';
import GitlabLabels from './components/Gitlab/ByLabel';
import GitlabMilestones from './components/Gitlab/Milestones';
import InternetConnection from './components/InternetConnection';
import Music from './components/Music';
import Npm from './components/Npm';
import Packagist from './components/Packagist';
import Tasks from './components/Tasks';
import TimeWeather from './components/TimeWeather';
import Twitter from './components/Twitter';
import Uptime from './components/Uptime';
import RssFeed from './components/RssFeed';
import ApiStatus from './components/ApiStatus';
import Stats from './components/Stats';

new Vue({
    el: '#dashboard',

    components: {
        Dashboard,
        Calendar,
        Github,
        GitlabTotals,
        GitlabLabels,
        GitlabMilestones,
        InternetConnection,
        Music,
        Npm,
        Packagist,
        Tasks,
        TimeWeather,
        Twitter,
        Uptime,
        ApiStatus,
        Stats,
        RssFeed,
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
