<template>
    <main class="container">
        <filter-form
            @onChangeForm="onChangeForm">
        </filter-form>

        <chart-hotel
            v-if="loaded"
            :labels="labels"
            :data="data"
            :reviewCount="reviewCount"
        >
        </chart-hotel>

    </main>
</template>

<script>
import FilterForm from '../components/FilterForm.vue'
import ChartHotel from '../components/ChartHotel.vue'
import Vue from "vue";

export default {
    name: "Home",
    components: { ChartHotel, FilterForm },
    data() {
        return {
            labels: [],
            data: [],
            reviewCount: [],

            loaded: false,
            error: null,
        }
    },
    methods: {
        onChangeForm(value) {
            this.loaded = false

            if (value.hotel === null || value.beginDate === null || value.endDate === null ) {
                return
            }

            Vue.apiService.getStatistic(value.hotel, value.beginDate, value.endDate)
                 .then(response => {
                     const { labels, data, reviewCount } = response

                     this.labels = labels
                     this.data = data
                     this.reviewCount = reviewCount

                     this.loaded = true
                 })
                 .catch(error => {
                     this.error = error
                 })
        }
    }
}
</script>
