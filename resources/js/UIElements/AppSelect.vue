<template>
    <div>
        <el-select
            :disabled="disabled"
            class="w-full"
            @input="input"
            @remove-tag="cleared"
            :value="preparedValue"
            :filterable=filterable
            :multiple="multiple"
            :placeholder="placeholder"
            :no-data-text="noDataText"
            :no-match-text="noMatchText"
        >
            <el-option
                v-for="option in options"
                :key="option[optionValue]"
                :label="option[optionLabel]"
                :value="option[optionValue]">
            </el-option>
        </el-select>
    </div>
</template>

<script>
export default {
    name: "AppSelect",
    props: {
        value: {
            required: false,
            type: [Array, Object, String]
        },
        options: {
            required: true,
            type: Array
        },
        allRemovable: {
            required: false,
            default: true,
            type: Boolean,
        },
        filterable: {
            required: false,
            default: false,
            type: Boolean,
        },
        multiple: {
            required: false,
            default: false,
            type: Boolean,
        },
        placeholder: {
            required: false,
            default: null,
            type: String,
        },
        noDataText: {
            required: false,
            default: 'No Data',
            type: String,
        },
        noMatchText: {
            required: false,
            default: 'No Results found',
            type: String,
        },
        optionValue: {
            required: false,
            default: 'id',
            type: String,
        },
        optionLabel: {
            required: true,
            default: 'name',
            type: String,
        },
        disabled: {
            required: false,
            default: false,
            type: Boolean,
        }
    },
    data() {
        return {

        }
    },
    methods: {
        cleared(value){
            if (!this.allRemovable) {
                console.log('clicked clear'+value)
            }
        },
        getOptionObjectByID(selectedOptionId) {
            return this.options.filter((option) => {
                return option[this.optionValue] === selectedOptionId
            })
        },
        input(selectedOptions) {
            let objectifiedSelectedOptions = {}
            if (this.multiple) {
                objectifiedSelectedOptions = selectedOptions.map(option => {
                    return this.getOptionObjectByID(option)[0]
                })
            } else {
                objectifiedSelectedOptions = this.getOptionObjectByID(selectedOptions)[0]
            }


            this.$emit('input', objectifiedSelectedOptions)
            this.$emit('changed', objectifiedSelectedOptions)
        }
    },
    computed: {
        preparedValue() {
            if (Array.isArray(this.value)) {
                return this.value.map(v => {
                    return v[this.optionValue]
                })
            } else {
                return this.value == null ? null : this.value[this.optionValue]
            }
        }
    }
}
</script>

<style scoped>

</style>
