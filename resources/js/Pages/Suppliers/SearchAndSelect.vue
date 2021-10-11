<template>
    <t-rich-select
        v-model="selected"
        :options="options"
        value-attribute="id"
        text-attribute="details.name"
        v-on:change="selectedOption"
    >
    </t-rich-select>
</template>

<script>
export default {
    name: "SearchAndSelect",
    props: {
        selectionOptions: {
            required: true,
            type: Object
        }
    },
    mounted() {
        this.options = this.selectionOptions;
    },
    data () {
        return {
            options: {},
            selected: null
        }
    },
    methods: {
        selectedOption() {
            this.$emit('change', this.selected)
        }
    }
}
</script>

<style scoped>

</style>
