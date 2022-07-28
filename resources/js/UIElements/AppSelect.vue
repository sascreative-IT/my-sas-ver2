<template>
    <div>
        <el-select
            :clearable="clearable"
            :disabled="disabled"
            class="w-full"
            @input="input"
            @change="change"
            :value="preparedValue"
            :filterable=filterable
            :multiple="multiple"
            :multiple-limit="multipleLimit"
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
        <div v-if="errorMessage.show">
            <div class="text-xs text-red-500">{{errorMessage.message}}</div>
        </div>
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
        multipleLimit: {
            required: false,
            default: 0,
            type: Number,
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
        },
        clearable: {
            required: false,
            default: false,
            type: Boolean,
        }
    },
    data() {
        return {
            clearableState: false,
            errorMessage: {
                show: false,
                message:  ''
            }
        }
    },
    mounted() {
        this.clearableState = this.allRemovable;
    },
    methods: {
        // handleTagRemove(value){
        //     if (!this.clearableState) {
        //         if(this.preparedValue.length === 1) {
        //             this.input(this.preparedValue)
        //         }
        //     }
        // },
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
        },
        change(value){
            if (!this.allRemovable && value.length === 0) {
                this.errorMessage.show = true
                this.errorMessage.message = 'You must select at least one option'
            }
            if (!this.allRemovable && value.length > 0) {
                this.errorMessage.show = false
                this.errorMessage.message = ''
            }

            this.$emit('change', value)
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
