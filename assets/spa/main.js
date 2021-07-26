import Vue from 'vue'
import App from './App.vue'
import apiService from "./services/apiService";

Vue.apiService = new apiService();

new Vue({
    components: { App },
    template: "<App/>"
}).$mount("#app");