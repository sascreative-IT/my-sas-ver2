<template>
    <div v-if="hasErrors && !nestedFieldType">
        <div class="font-medium text-red-600">Please provide valid information</div>

        <ul class="mt-3 list-disc list-inside text-sm text-red-600">
            <li v-for="(error, key) in errors" :key="key">{{ error }}</li>
        </ul>
    </div>
    <div v-else-if="hasErrors && nestedFieldType">
        <div class="font-medium text-red-600">Please provide valid information</div>

        <ul class="mt-3 list-disc list-inside text-sm text-red-600">
            <li v-for="(error, key) in errors" :key="key"><b>{{ getErrorField(key) }}</b> - {{ error }}</li>
        </ul>
    </div>
</template>

<script>
    export default {
        props: {
            nestedFieldType: {
                required: false,
                type: Boolean,
                default: false
            },
            nestedFields: {
                required: false,
                type: Array
            },
        },
        methods: {
            getErrorField(key) {
                let fieldKey =  key.split(".")[0];
                let fieldName = key.split(".")[1];

                return this.nestedFields[fieldKey][fieldName];
            },
        },
        computed: {
            errors() {
                return this.$page.props.errors
            },

            hasErrors() {
                return Object.keys(this.errors).length > 0;
            },
        }
    }
</script>
