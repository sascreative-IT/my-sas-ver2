<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Purchase Orders
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex flex-row-reverse">
                    <inertia-link
                        class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150"
                        :href="route('purchase.orders.create')">Add New Purchase Order
                    </inertia-link>
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mt-5">
                    <app-table
                        emptyText="No purchase orders created"
                        :items="purchase_orders.data"
                        :headers="[
                        {key: 'id', name: 'ID', width: '80px'},
                        {key: 'supplier.name', name: 'Supplier'},
                        {key: 'assigned_factory.name', name: 'Factory'},
                        {key: 'evaluation_status', name: 'Status'},
                        {key: 'user.name', name: 'Evaluated By'},
                        {key: 'evaluated_at', name: 'Evaluated On'},
                      ]"
                    >
                        <el-table-column
                            fixed="right"
                            label="Operations"
                            width="220">
                            <template #default="scope">
                                <inertia-link
                                    class="inline-flex items-center px-2 py-2 border-gray-800 border hover:bg-gray-700 hover:border-transparent hover:text-white rounded-md font-semibold text-xs text-black uppercase tracking-widest active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150"
                                    v-if="scope.row.evaluation_status === 'Approved'"
                                    :href="route('invoices.create',{ materialPurchaseOrder: scope.row.id })">
                                    Create Invoice
                                </inertia-link>

                                <template v-if="scope.row.evaluation_status === 'Pending'">
                                    <button
                                        class="inline-flex items-center px-2 py-2 border-gray-800 border hover:bg-gray-700 hover:border-transparent hover:text-white rounded-md font-semibold text-xs text-black uppercase tracking-widest active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150"
                                        @click="approvePurchaseOrder(scope.row.id)">
                                        Approve
                                    </button>

                                    <button
                                        class="inline-flex items-center px-2 py-2 border-gray-800 border hover:bg-gray-700 hover:border-transparent hover:text-white rounded-md font-semibold text-xs text-black uppercase tracking-widest active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150"
                                        @click="rejectPurchaseOrder(scope.row.id)">
                                        Reject
                                    </button>
                                </template>

                            </template>
                        </el-table-column>
                    </app-table>
                </div>

                <pagination class="mt-6" :links="purchase_orders.links"/>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppSelect from "@/UIElements/AppSelect";
import AppTable from "@/UIElements/AppTable";
import Pagination from '@/Components/Pagination'

export default {
    name: "Index",
    components: {AppTable, AppSelect, Pagination},
    props: {
        purchase_orders: {
            required: true,
            type: Object
        }
    },
    methods: {
        approvePurchaseOrder(id) {
            this.$inertia.form({})
                .post(route('purchase.orders.approve', {materialPurchaseOrder: id}));
        },

        rejectPurchaseOrder(id) {
            this.$inertia.form({})
                .post(route('purchase.orders.reject', {materialPurchaseOrder: id}));
        }
    }
}
</script>

<style scoped>

</style>
