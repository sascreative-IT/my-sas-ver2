<template>
    <t-rich-select
        v-model="selected"
        :options="options"
        v-on:change="selectedOption"
    >
        <template
            slot="dropdownDown"
            slot-scope="{ query, selectedOption, options }"
        >
            <div
                v-if="query"
                class="text-center"
            >
                <button
                    type="button"
                    class="block w-full p-3 text-white bg-blue-500 border hover:bg-blue-600"
                    @click="createOption(query)"
                >
                    Create {{ query }}
                </button>
            </div>
        </template>
    </t-rich-select>
</template>

<script>
export default {
    name: "SelectOrCreateInput",
    props: {
        selectionOptions: {
            required: true,
            type: Object
        },
        reset: {
            type: Boolean
        }
    },
    watch: {
        reset: function(newVal, oldVal) {
            if (newVal) {
                this.selected = null;
            }
        }
    },
    mounted() {
        this.options = this.selectionOptions;
    },
    data() {
        return {
            selected: null,
            selectedPair: {},
            options: {},
        }
    },
    methods: {
        createOption(text) {
            this.options.push(text)
            this.selected = text
        },
        selectedOption() {
            this.selectedPair['value'] = this.selected;
            this.selectedPair['text'] = this.options[this.selected];
            this.$emit('change', this.selectedPair)
        }
    }
}
</script>

<style scoped>

</style>
