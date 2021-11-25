<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Material Inventory
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex flex-row-reverse">
                    <inertia-link
                        class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150"
                        href="/invoices/create">Add Invoice
                    </inertia-link>
                </div>

                <div class="flex flex-row-reverse">
                    <div class="w-80 pt-2">
                        <select-menu
                            placeholder="Select a factory"
                            label="name"
                            :options="factory_options"
                            :default-selected="true"
                            @selected="setSelectedFactory"
                        ></select-menu>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mt-5">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Material
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Color
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Supplier
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Available Quantity
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Allocated Quantity
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Usable Quantity
                            </th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">More</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="inventoryItem in inventory.data">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ inventoryItem.material_name }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ inventoryItem.color_name }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ inventoryItem.supplier_name }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ inventoryItem.available_quantity }} {{ inventoryItem.unit }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ inventoryItem.allocated_quantity }} {{ inventoryItem.unit }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ inventoryItem.usable_quantity }} {{ inventoryItem.unit }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <inertia-link
                                    class="inline-flex items-center px-4 py-2 border-gray-800 border hover:bg-gray-700 hover:border-transparent hover:text-white rounded-md font-semibold text-xs text-black uppercase tracking-widest active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150"
                                    :href="`/inventory/${inventoryItem.id}/details`"
                                >
                                    More
                                </inertia-link>
                            </td>
                        </tr>

                        <!-- More items... -->
                        </tbody>
                    </table>
                </div>
                <paginator
                    :pagination="inventory"
                ></paginator>
            </div>
        </div>

    </app-layout>
</template>

<script>
import Paginator from "@/UIElements/Paginator";
import SelectMenu from "@/UIElements/SelectMenu";

export default {
    name: "InventoryIndex",
    components: {
        Paginator,
        SelectMenu
    },
    props: {
        inventory: {
            required: false,
            type: Object
        },
        factories: {
            type: Array
        },
        pagination: {
            type: Object
        }
    },
    data() {
        return {
            factory_options: [],
            selected_factory: {}
        }
    },
    mounted() {
        for (let key in this.factories) {
            if (this.factories.hasOwnProperty(key)) {
                this.factory_options.push(this.factories[key]);
            }
        }
    },
    methods: {
        setSelectedFactory(val) {
            this.$inertia.visit('/inventory?factory=' + val.id ,{ preserveScroll: true, preserveState: true, only: ['inventory','pagination']})
        }
    }
}
</script>

<style>

</style>
