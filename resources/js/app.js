import VueTheMask from 'vue-the-mask';
import VueRouter from "vue-router";
window.axios = require('axios');

window.Vue = require('vue');

window.Vue.use(VueRouter);
window.Vue.use(VueTheMask);

const home = require('./components/home.vue').default;
const editBot = require('./components/editBot').default;

const settings = require('./components/settings.vue').default;
const settingsNotifications = require('./components/settingsNotifications.vue').default;
const settingsIntegration = require('./components/settingsIntegration.vue').default;
const settingsPolitics = require('./components/settingsPolitics.vue').default;
const settingsAdditional = require('./components/settingsAdditional.vue').default;

const chat = require('./components/chat.vue').default;

const autofunnels = require('./components/autofunnels.vue').default;
const autofunnelsList = require('./components/autofunnelsList.vue').default;

const list = require('./components/list.vue').default;
const listConstants = require('./components/listConstants.vue').default;

const statistics = require('./components/statistics.vue').default;
const statisticsDevices = require('./components/statisticsDevices.vue').default;
const statisticsPhrases = require('./components/statisticsPhrases').default;
const statisticsPopular = require('./components/statisticsPopular').default;
const statisticsLinks = require('./components/statisticsLinks').default;

const analyze = require('./components/analyze.vue').default;



const routes = [
    {
        path: '/home',
        name: 'home',
        component: home
    },
    {
        path: '/edit/bot/:id',
        name: 'editBot',
        component: editBot
    },
    {
        path: '/chat',
        name: 'chat',
        component: chat
    },
    {
        path: '/autofunnels',
        name: 'autofunnels',
        component: autofunnels
    },
    {
        path: '/autofunnels/list',
        name: 'autofunnelsList',
        component: autofunnelsList
    },
    {
        path: '/settings',
        name: 'settings',
        component: settings
    },
    {
        path: '/settings/notifications',
        name: 'settingsNotifications',
        component: settingsNotifications
    },
    {
        path: '/settings/integration',
        name: 'settingsIntegration',
        component: settingsIntegration
    },
    {
        path: '/settings/politics',
        name: 'settingsPolitics',
        component: settingsPolitics
    },
    {
        path: '/settings/additional',
        name: 'settingsAdditional',
        component: settingsAdditional
    },
    {
        path: '/list',
        name: 'list',
        component: list
    },
    {
        path: '/list/constants',
        name: 'listConstants',
        component: listConstants
    },
    {
        path: '/statistics',
        name: 'statistics',
        component: statistics
    },
    {
        path: '/statistics/devices',
        name: 'statisticsDevices',
        component: statisticsDevices
    },
    {
        path: '/statistics/phrases',
        name: 'statisticsPhrases',
        component: statisticsPhrases
    },
    {
        path: '/statistics/popular',
        name: 'statisticsPopular',
        component: statisticsPopular
    },
    {
        path: '/statistics/links',
        name: 'statisticsLinks',
        component: statisticsLinks
    },
    {
        path: '/analyze',
        name: 'analyze',
        component: analyze
    },

];

const router = new VueRouter({
    mode: 'history',
    routes
});

const app = new Vue({
    el: '#app',
    router
});
