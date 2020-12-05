import Vue from 'vue'
import App from './Final.vue'
import './registerServiceWorker'


Vue.config.productionTip = false;

// Mount App
new Vue({
	render: h => h(App),
}).$mount('#app')