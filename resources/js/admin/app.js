import Vue from 'vue'
import Buefy from 'buefy'
import router from './router'
import store from './store'
import './index'
import '../bootstrap'

Vue.use(Buefy)

new Vue({
    router,
    store
}).$mount('#app');

