<template>
    <form @submit.prevent="onSubmit">
        <div class="shadow overflow-hidden sm:rounded-md">
            <div class="px-4 py-5 bg-white sm:p-6">
                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6 sm:col-span-3">
                        <label for="colour_name" class="block text-sm font-medium text-gray-700">Colour Name</label>
                        <input v-model="colour.name" type="text" name="colour_name" id="colour_name" autocomplete="given-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <label for="colour_type" class="block text-sm font-medium text-gray-700">Type</label>
                        <select v-model="colour.type" id="colour_type" name="colour_type" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option v-for="type in materialTypes" :value="type.type"> {{ type.name }}</option>
                        </select>
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <label for="colour_active" class="block text-sm font-medium text-gray-700">Active</label>
                        <select v-model="colour.is_active" id="colour_active" name="colour_active" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option :value="true"> Yes </option>
                            <option :value="false"> No </option>
                        </select>
                    </div>

                </div>
            </div>
            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                <inertia-link href="/settings/colours" class="inline-flex justify-center text-sm font-medium rounded-md text-gray-900 mr-5">
                    Cancel
                </inertia-link>

                <button
                    type="submit"
                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    :class="{'opacity-50': submitButtonDisable}"
                >
                    {{buttonText}}
                </button>
            </div>
        </div>
    </form>
</template>

<script>
export default {
    name: "ColourForm",
    props: {
        initColour: {
            required: false,
            type: Object
        },
        materialTypes: {
            required: true,
            type: Array
        },
        submitButtonDisable: {
            required: false,
            default: false,
            type: Boolean
        },
        buttonText: {
            required: false,
            default: 'Save',
            type: String
        }
    },
    data() {
        return {
            colour: {
                name: '',
                type: null,
                is_active: false
            }
        }
    },
    mounted() {
        (this.initColour != null) ? this.colour = this.initColour : this.colour = {};
    },
    methods: {
        onSubmit() {
            this.$emit('onSubmit', this.colour)
        }
    }
}
</script>

<style scoped>

</style>
