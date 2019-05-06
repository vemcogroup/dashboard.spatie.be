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
import Services from './components/Services';
import DevServices from './components/DevServices';
import GitlabTotals from './components/Gitlab/Totals';
import GitlabLabels from './components/Gitlab/ByLabel';
import SensorsOffline from './components/SensorsOffline';
import HelpdeskTickets from './components/Helpdesk/ByAgent';
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

        Services,
        DevServices,
        SensorsOffline,

        HelpdeskTickets,
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
