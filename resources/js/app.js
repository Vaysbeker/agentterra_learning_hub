import './bootstrap';
import { createApp } from 'vue';
import App from './App.vue';
import ExampleComponent from './components/ExampleComponent.vue';

const app = createApp({});

createApp(App).mount('#app');

// Регистрируем компонент
app.component('example-component', ExampleComponent);

// Монтируем Vue в элемент с ID "app"
app.mount('#app');
