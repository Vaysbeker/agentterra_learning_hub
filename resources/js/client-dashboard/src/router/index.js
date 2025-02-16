import { createRouter, createWebHistory } from 'vue-router';
import Dashboard from '../views/Dashboard.vue';
import Progress from '../views/Progress.vue';
import Support from '../views/Support.vue';

const routes = [
    { path: '/dashboard', component: Dashboard },
    { path: '/progress', component: Progress },
    { path: '/support', component: Support },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
