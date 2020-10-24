import Vue from 'vue'
import App from './App.vue'
import Api from './api'
import './registerServiceWorker'


Vue.config.productionTip = false;

// Mount App
new Vue({
	render: h => h(App),
}).$mount('#app')

// Log Page View
Api('logger.php', 'POST', {
	action: 'home page view',
	category: 'page view'
});