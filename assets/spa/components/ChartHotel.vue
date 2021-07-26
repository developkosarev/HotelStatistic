<script>
import { Line } from 'vue-chartjs'

export default {
    name: 'ChartHotel',
    extends: Line,
    props: {
        labels: {
            type: Array,
            default: () => []
        },
        data: {
            type: Array,
            default: () => []
        },
        reviewCount: {
            type: Array,
            default: () => []
        }
    },
    data() {
        return {
            options: {
                responsive: true,
                lineTension: 1,
                maintainAspectRatio: false,
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data) {
                            let label = 'Review count: '
                            const reviewCount = data.datasets[tooltipItem.datasetIndex].reviewCount[tooltipItem.index]

                            label += Math.round(reviewCount * 100) / 100;

                            return label;
                        }
                    }
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            max: 6,
                            min: 0
                        }
                    }]
                }
            }
        }
    },
    computed: {
        chartData() {
            return {
                labels: this.labels,
                datasets: [
                    {
                        label: 'Hotel statistic',
                        borderColor: "#47b784",
                        data: this.data,
                        reviewCount: this.reviewCount
                    }
                ]
            };
        }
    },
    mounted () {
        this.renderChart(this.chartData, this.options)
    }
}
</script>