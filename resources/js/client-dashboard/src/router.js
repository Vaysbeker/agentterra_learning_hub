import { createRouter, createWebHistory } from 'vue-router';
import Home from '@/pages/Home.vue';
import Courses from '@/pages/Courses.vue';
import Purchases from '@/pages/Purchases.vue';
import Tests from '@/pages/Tests.vue';
import Profile from '@/views/Profile.vue';

const routes = [
    { path: '/', component: Home, meta: { title: 'Главная' } },
    { path: '/courses', component: Courses, meta: { title: 'Курсы' } },
    { path: '/purchases', component: Purchases, meta: { title: 'Мои покупки' } },
    { path: '/tests', component: Tests, meta: { title: 'Тестирование' } },
    { path: '/profile', component: Profile, meta: { title: 'Профиль' } },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
