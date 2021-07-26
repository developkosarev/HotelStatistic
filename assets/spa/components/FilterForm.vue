<template>
    <form class="filters">

        <hotel-select class="text-selector"
                      @onChangeHotel="onChangeHotel">
        </hotel-select>

        <div class="date">
            <label for="begin-date">FROM: </label>
            <input type="date" name="begin-date" required
                   v-model="form.beginDate"
                   @change="onChangeForm"
            >
        </div>

        <div class="date">
            <label for="end-date">TO: </label>
            <input type="date" name="end-date" required
                   v-model="form.endDate"
                   @change="onChangeForm"
            >
        </div>
    </form>
</template>

<script>
import HotelSelect from "./HotelSelect";

export default {
    name: "FilterForm",
    components: { HotelSelect },
    data() {
        return {
            form: {
                hotel: null,
                beginDate: null,
                endDate: null
            }
        }
    },
    methods: {
        onChangeHotel(value) {
            this.form.hotel = value;
            this.onChangeForm();
        },
        onChangeForm() {
            this.$nextTick(() => {
                this.$emit('onChangeForm', this.form)
            })
        }
    }
}
</script>
