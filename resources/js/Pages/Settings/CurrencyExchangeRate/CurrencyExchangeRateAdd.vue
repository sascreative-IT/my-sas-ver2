<template>
    <settings-layout>
        <div class="">
            <h3 class="text-lg">Add Currency</h3>
            <div class="mt-5">
                <form @submit.prevent="addCurrencyExchangeRate">
                    <div class="shadow overflow-hidden sm:rounded-md">
                        <div class="px-4 py-5 bg-white sm:p-6">
                            <div class="grid grid-cols-3 gap-8">
                                <div>
                                    <label for="currencyExchangeRate_name" class="block text-sm font-medium text-gray-700">Currency Name</label>

                                    <select id="factory"
                                            v-model="currencyExchangeRate.name"
                                            name="status"
                                            autocomplete="status"
                                            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        <option v-for="currency in currencies" :value="currency.name">
                                            {{ currency.name }}
                                        </option>
                                    </select>
                                </div>

                                <div>
                                    <label for="currencyExchangeRate_rate" class="block text-sm font-medium text-gray-700">Currency Rate (1 USD)</label>
                                    <input v-model="currencyExchangeRate.currencyRate" type="text" name="rate" id="full_name" autocomplete="given-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>

                                <div>
                                    <label for="currencyExchangeRateRateOn" class="block text-sm font-medium text-gray-700">Rate On</label>

                                    <vc-date-picker
                                        color="white"
                                        v-model='currencyExchangeRate.currencyRateOn'
                                        :model-config="modelConfig"
                                    >
                                        <template v-slot="{ inputValue, inputEvents }">
                                            <input
                                                class="appearance-none border w-48 py-2 px-4 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                id="date"
                                                v-on="inputEvents"
                                                :value="inputValue"
                                            />
                                        </template>
                                    </vc-date-picker>
                                </div>

                            </div>
                        </div>
                        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                            <inertia-link :href="route('settings.currency-exchange-rates.index')" class="inline-flex justify-center text-sm font-medium rounded-md text-gray-900 mr-5">
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
    name: "CurrencyExchangeRateAdd",
    components: {SettingsLayout},
    props: {
        currencies: {
            required: true
        }
    },
    data() {
        return {
            currencyExchangeRate: {
                name: '',
                currencyRate: null,
                currencyRateOn: null
            },
            modelConfig: {
                type: 'string',
                mask: 'YYYY-MM-DD',
            },
            submitted: false,
        }
    },
    methods: {
        addCurrencyExchangeRate() {
            this.submitted = true;
            this.$inertia.post(route('settings.currency-exchange-rates.store'), this.currencyExchangeRate).then(function () {
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
