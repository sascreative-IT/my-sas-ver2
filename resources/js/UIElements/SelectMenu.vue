<template>
    <v-select class="select-menu" @input="setSelectedItem" v-model="selected_item" :label="label"
              :placeholder="placeholder" :options="options"></v-select>
</template>

<script>
export default {
    name: "SelectMenu",
    props: {
        options: {
            required: true,
            type: Array
        },
        placeholder: {
            required: false,
            type: String,
            default: 'Select an option'
        },
        label: {
            required: true,
            type: String
        },
        defaultSelected: {
            type: Boolean,
            required: false
        }
    },
    data () {
        return {
            selected_item: {},
        }
    },
    watch: {
        options: function (newVal, oldVal) {
            if (newVal.length > 0 && this.defaultSelected) {
                this.selected_item = newVal[0];
                this.setSelectedItem(this.selected_item);
            }
        }
    },
    methods: {
        setSelectedItem(value) {
            this.$emit('selected', value);
        }
    }
}
</script>

<style>
.select-menu .vs__search::placeholder,
.select-menu .vs__dropdown-toggle,
.select-menu .vs__dropdown-menu {
    background: #fff;
    border: none;
    color: #394066;
}

.select-menu .vs__clear,
.select-menu .vs__open-indicator {
    fill: #394066;
}
</style>
