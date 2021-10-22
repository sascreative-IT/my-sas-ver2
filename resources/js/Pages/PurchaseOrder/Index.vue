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
                        :items="purchase_orders.data"
                        :headers="[
                        {key: 'id', name: 'ID', width: '200px'},
                        {key: 'supplier.name', name: 'Supplier'},
                        {key: 'factory.name', name: 'Factory'},
                        {key: 'user.name', name: 'Approved By'},
                        {key: 'approved_at', name: 'Approved At'},
                      ]"
                    >
                        <el-table-column
                            fixed="right"
                            label="Operations"
                            width="120">
                            <template #default="scope">
                                <inertia-link
                                    class="text-blue-400"
                                    :href="route('invoices.create')"
                                >
                                    Create Invoice
                                </inertia-link>
                            </template>
                        </el-table-column>
                    </app-table>
                </div>

                <pagination class="mt-6" :links="purchase_orders.links" />
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
    }
}
</script>

<style scoped>

</style>
