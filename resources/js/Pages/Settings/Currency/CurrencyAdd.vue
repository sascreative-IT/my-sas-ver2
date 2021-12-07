<template>
    <settings-layout>
        <div class="">
            <h3 class="text-lg">Add Currency</h3>
            <div class="mt-5">
                <form @submit.prevent="addCurrency">
                    <div class="shadow overflow-hidden sm:rounded-md">
                        <div class="px-4 py-5 bg-white sm:p-6">
                            <div class="grid grid-cols-3 gap-8">
                                <div>
                                    <label for="currency_name" class="block text-sm font-medium text-gray-700">Currency Name</label>
                                    <input v-model="currency.name" type="text" name="full_name" id="full_name" autocomplete="given-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>

                                <div>
                                    <label for="currency_status" class="block text-sm font-medium text-gray-700">Status</label>
                                    <select id="factory"
                                            v-model="currency.status"
                                            name="status"
                                            autocomplete="status"
                                            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        <option value="Enabled">Enabled</option>
                                        <option value="Disabled">Disabled</option>
                                    </select>
                                </div>



                            </div>
                        </div>
                        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                            <inertia-link :href="route('settings.currencies.index')" class="inline-flex justify-center text-sm font-medium rounded-md text-gray-900 mr-5">
                                Cancel
                            </inertia-link>

                            <button
                                type="submit"
                                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150"
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
                status: null
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
