<template>
    <settings-layout>
        <div class="">
            <h3 class="text-lg">Currencies</h3>

            <div class="flex flex-row-reverse">
                <inertia-link
                    class="bg-green-500 w-30 h-8 text-center pt-1.5 pl-3 pr-2 text-white rounded text-sm"
                    :href="route('settings.currencies.create')"
                >
                    Add Currency
                </inertia-link>
            </div>
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
                            Rate
                        </th>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Edit</span>
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="(currency,index) in currencies">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ currency.name }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ currency.rate }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <inertia-link
                                class="text-indigo-600 hover:text-indigo-900"
                                :href="route('settings.currencies.edit', currency.id)"
                            >
                                Edit
                            </inertia-link>

                            <button class="ml-2 text-red-600" @click="deleteConfirmation(index)">
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
