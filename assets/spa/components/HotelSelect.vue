<template>
    <select v-model="selected" @change="onChangeHotel()">
        <option value="" selected disabled>Please select hotel</option>
        <option v-for="item in items" :key="item.value" :value="item.value">
            {{ item.text }}
        </option>
    </select>
</template>

<script>
export default {
    name: "HotelSelect",
    data() {
        return {
            selected: null,
            items: [
                { value: 1, text: 'Hotel 001' },
                { value: 2, text: 'Hotel 002' },
                { value: 3, text: 'Hotel 003' },
                { value: 4, text: 'Hotel 004' },
                { value: 5, text: 'Hotel 005' },
                { value: 6, text: 'Hotel 006' },
                { value: 7, text: 'Hotel 007' },
                { value: 8, text: 'Hotel 008' },
                { value: 9, text: 'Hotel 009' },
                { value:10, text: 'Hotel 010' },
                { value:11, text: 'Hotel 011' }
            ]
        }
    },
    methods: {
        onChangeHotel() {
            this.$nextTick(() => {
                this.$emit('onChangeHotel', this.selected)
            })
        }
    }
}
</script>