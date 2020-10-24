import Vue from 'vue'
import App from './App.vue'
import logAction from './logger'
import './registerServiceWorker'


Vue.config.productionTip = false;

// Mount App
new Vue({
	render: h => h(App),
}).$mount('#app')

// Log Page View
logAction({
	action: 'home page view',
	category: 'page view'
});