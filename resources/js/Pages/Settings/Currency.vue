<template>
    <settings-layout>
        <div class="flex justify-between">
            <h3 class="text-lg">Currencies</h3>

            <div class="flex flex-row-reverse">
                <inertia-link
                    class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150"
                    :href="route('settings.currencies.create')">Add Currency</inertia-link>
            </div>
        </div>
        <div class="">    
            <div class="mt-5">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Name
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Edit</span>
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="(currency,index) in currencies">
                        <td class="px-6 py-3 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ currency.name }}</div>
                        </td>
                        <td class="px-6 py-3 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                <span class="p-1" :class="currency.status === 'Disabled' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800'">
                                {{ currency.status }}
                                </span>
                            </div>
                        </td>

                        <td class="px-6 py-3 whitespace-nowrap text-right text-sm font-medium">
                            <inertia-link
                                class="inline-flex items-center px-4 py-1 border-gray-600 border hover:bg-gray-700 hover:border-transparent hover:text-white rounded-sm font-semibold text-xs text-black uppercase tracking-widest active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150"
                                :href="route('settings.currencies.edit', currency.id)"
                            >
                                Edit
                            </inertia-link>

                            <button class="inline-flex items-center px-4 py-1 border-red-600 border hover:bg-red-700 hover:border-transparent hover:text-white rounded-sm font-semibold text-xs text-red-700 uppercase tracking-widest active:bg-red-900 focus:outline-none focus:border-red-900 focus:shadow-outline-red transition ease-in-out duration-150" @click="deleteConfirmation(index)">
                                Delete
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <delete-confirmation-modal
            title="Delete Currency"
            :message='`Are you sure you want delete "${this.selectedCurrency.name}" currency ?`'
            :delete-url="'/settings/currencies/' + this.selectedCurrency.id"
            :show="confirmingUserDeletion"
            @close="confirmingUserDeletion = false"
        ></delete-confirmation-modal>
    </settings-layout>
</template>

<script>
import SettingsLayout from "@/Pages/Settings/SettingsLayout";
import JetConfirmationModal from '@/Jetstream/ConfirmationModal'
import DeleteConfirmationModal from "@/Pages/Common/DeleteConfirmationModal";

export default {
    name: "Currency",
    components: {DeleteConfirmationModal, SettingsLayout, JetConfirmationModal},
    props: {
        currencies: {
            required: false,
            type: Array
        }
    },
    data() {
        return {
            selectedCurrency: {},
            confirmingUserDeletion: false
        }
    },
    methods: {
        deleteConfirmation(index) {
            this.selectedCurrency = this.currencies[index]
            this.confirmingUserDeletion = true;
        },
    }
}
</script>

<style scoped>

</style>
