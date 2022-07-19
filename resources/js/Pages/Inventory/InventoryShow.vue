<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Inventory: {{ inventory.variation.material.name }} - {{ inventory.variation.colour.name }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <div class="flex flex-row justify-between">
                    <div class="bg-white shadow-xl p-5 rounded-md">
                        <h4 class="text-xl text-blue-700">Total Quantity</h4>
                        <div class="text-gray-600">{{ inventory.available_quantity }} {{ inventory.unit }}</div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mt-5 p-5">
                    <el-tabs type="card">
                        <div class="px-6 flex justify-between">
                            <h3 class="text-lg">Inventory Log</h3>
                            <button
                                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150"
                                @click="showAdjustmentWindow = true"
                            >
                                Stock Adjustment
                            </button>
                        </div>

                        <table class="mt-5 min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date and Time
                                </th>

                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Unit
                                </th>

                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    In
                                </th>

                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Out
                                </th>

                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Balance
                                </th>

                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Other Reason
                                </th>

                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Unit Price
                                </th>

                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Total Price
                                </th>

                            </tr>
                            </thead>

                            <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="stock in stockIn.data">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ stock.created_at }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ stock.unit }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap flex flex-row items-center justify-between">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ stock.in }}
                                    </div>
                                    <div v-if="stock.invoice_item">
                                        <a class="cursor-pointer text-blue-500 text-sm" @click="showInvoice(stock.invoice_item.invoice.id)">
                                            #{{ stock.invoice_item.invoice.invoice_number }}
                                        </a>
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ stock.out }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ stock.balance }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ stock.reason }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ stock.in_unit_price }} {{ stock.in_unit_currency }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ stock.total_price }} {{ stock.in_unit_currency }}
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <paginator
                            :pagination="stockIn"
                        ></paginator>
                    </el-tabs>
                </div>
            </div>
        </div>
        <dialog-modal :show="showAdjustmentWindow">
            <template #title>
                Stock Adjustment
            </template>

            <template #content>
                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6 sm:col-span-3">
                        <label for="reason" class="block text-sm font-medium text-gray-700">Reason</label>
                        <input v-model="adjustment.reason" type="text" name="reason" id="reason"
                               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>

                    <div class="col-span-3 sm:col-span-2">
                        <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                        <el-tooltip content="Add '-' before qty to decrease stock" placement="top">
                            <input v-model.number="adjustment.quantity" type="text" name="quantity" id="quantity"
                               autocomplete="given-name"
                               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </el-tooltip>
                    </div>
                </div>
            </template>

            <template #footer>
                <jet-secondary-button @click.native="showAdjustmentWindow = false">
                    Nevermind
                </jet-secondary-button>

                <jet-button @click.native="adjust" class="ml-2">
                    Save
                </jet-button>
            </template>
        </dialog-modal>
        <main>
            <Notify :flash="$page.props.flash"></Notify>
            <slot></slot>
        </main>
    </app-layout>
</template>

<script>
import DialogModal from "@/Jetstream/DialogModal";
import Paginator from "@/UIElements/Paginator";
import Notify from "@/UIElements/Notify";

export default {
    name: "InventoryShow",
    props: {
        inventory: {
            type: Object,
            required: true
        },
        stockIn: {
            type: Object,
            required: true
        },
        stockReserv: {
            type: Object,
            required: true
        }
    },
    components: {
        DialogModal,
        Paginator,
        Notify
    },
    data() {
        return {
            showAdjustmentWindow: false,
            adjustment: {
                reason: '',
                quantity: null,
            }
        }
    },
    methods: {
        adjust() {
            this.$inertia.post(`/inventory/${this.inventory.id}/adjust`, this.adjustment).then(function ({data}) {
                this.showAdjustmentWindow = false
            }).catch(error => {
                this.showAdjustmentWindow = false
            })
        },
        showInvoice(id) {
            this.$inertia.visit('/invoices/'+id);
        }
    }
}
</script>

<style scoped>

</style>
