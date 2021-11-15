<template>
    <settings-layout>
        <div class="">
            <h3 class="text-lg">Add Currency</h3>
            <div class="mt-5">
                <form @submit.prevent="addCurrency">
                    <div class="shadow overflow-hidden sm:rounded-md">
                        <div class="px-4 py-5 bg-white sm:p-6">
                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="currency_name" class="block text-sm font-medium text-gray-700">Currency Name</label>
                                    <input v-model="currency.name" type="text" name="full_name" id="full_name" autocomplete="given-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label for="currency_rate" class="block text-sm font-medium text-gray-700">Currency Rate</label>
                                    <input v-model="currency.rate" type="text" name="rate" id="full_name" autocomplete="given-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>


                            </div>
                        </div>
                        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                            <inertia-link :href="route('settings.currencies.index')" class="inline-flex justify-center text-sm font-medium rounded-md text-gray-900 mr-5">
                                Cancel
                            </inertia-link>

                            <button
                                type="submit"
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                :class="{'opacity-50': submitted}"
                            >
                                Add
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </settings-layout>
</template>

<script>
import SettingsLayout from "@/Pages/Settings/SettingsLayout";

export default {
    name: "CurrencyAdd",
    components: {SettingsLayout},
    data() {
        return {
            currency: {
                name: '',
                rate: null,
            },
            submitted: false,
        }
    },
    methods: {
        addCurrency() {
            this.submitted = true;
            this.$inertia.post(route('settings.currencies.store'), this.currency).then(function () {
                this.submitted = false;
            }).catch(error => {
                this.submitted = false;
            })
        }
    },
}
</script>

<style scoped>

</style>
