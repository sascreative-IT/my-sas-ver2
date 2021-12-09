<template>
    <app-layout>
        <Notify :flash="$page.props.flash"></Notify>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Purchase Orders
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-between">
                    <div class="" v-if="hasAnyRole(['Purchasing Officer','Administrator'])">
                        <inertia-link
                            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150"
                            :href="route('purchase.orders.create')">Add New Purchase Order
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
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mt-5 pl-2 pr-2">
                    <el-tabs @tab-click="handleClick">
                        <el-tab-pane label="Pending" key="Pending">

                            <app-table
                                emptyText="No purchase orders created"
                                :items="purchase_orders.data"
                                :headers="[
                        {key: 'id', name: 'ID', width: '80px'},
                        {key: 'supplier.name', name: 'Supplier'},
                        {key: 'assigned_factory.name', name: 'Factory'},
                        {key: 'user.name', name: 'Evaluated By'},
                        {key: 'evaluated_at', name: 'Evaluated On'},
                      ]"
                            >
                                <template
                                    v-if="hasAnyRole(['Production Manager','Administrator','Purchasing Officer'])">
                                    <el-table-column
                                        fixed="right"
                                        label="Operations"
                                        width="250">
                                        <template #default="scope">
                                            <inertia-link
                                                class="inline-flex items-center px-4 py-1 border-green-600 border hover:bg-green-700 hover:border-transparent hover:text-white rounded-sm font-semibold text-xs text-green-900 uppercase tracking-widest active:bg-green-900 focus:outline-none focus:border-green-900 focus:shadow-outline-green transition ease-in-out duration-150"
                                                :href="route('purchase.orders.show',{ purchase_order: scope.row.id })">
                                                View
                                            </inertia-link>

                                            <template v-if="hasAnyRole(['Purchasing Officer','Administrator'])">
                                                <inertia-link
                                                    class="inline-flex items-center px-4 py-1 border-green-600 border hover:bg-green-700 hover:border-transparent hover:text-white rounded-sm font-semibold text-xs text-green-900 uppercase tracking-widest active:bg-green-900 focus:outline-none focus:border-green-900 focus:shadow-outline-green transition ease-in-out duration-150"
                                                    v-if="scope.row.evaluation_status === 'Approved'"
                                                    :href="route('invoices.create',{ materialPurchaseOrder: scope.row.id })">
                                                    Create Invoice
                                                </inertia-link>
                                            </template>

                                            <template v-if="hasAnyRole(['Production Manager','Administrator'])">
                                                <template v-if="scope.row.evaluation_status === 'Pending'">
                                                    <button
                                                        class="inline-flex items-center px-4 py-1 border-green-600 border hover:bg-green-700 hover:border-transparent hover:text-white rounded-sm font-semibold text-xs text-green-900 uppercase tracking-widest active:bg-green-900 focus:outline-none focus:border-green-900 focus:shadow-outline-green transition ease-in-out duration-150"
                                                        @click="approvePurchaseOrder(scope.row.id)">Approve
                                                    </button>

                                                    <button
                                                        class="inline-flex items-center px-4 py-1 border-red-600 border hover:bg-red-700 hover:border-transparent hover:text-white rounded-sm font-semibold text-xs text-red-900 uppercase tracking-widest active:bg-red-900 focus:outline-none focus:border-red-900 focus:shadow-outline-red transition ease-in-out duration-150"
                                                        @click="rejectPurchaseOrder(scope.row.id)">
                                                        Reject
                                                    </button>
                                                </template>
                                            </template>

                                        </template>
                                    </el-table-column>
                                </template>
                            </app-table>

                        </el-tab-pane>
                        <el-tab-pane label="Approved" key="Approved">

                            <app-table
                                emptyText="No purchase orders created"
                                :items="purchase_orders.data"
                                :headers="[
                        {key: 'id', name: 'ID', width: '80px'},
                        {key: 'supplier.name', name: 'Supplier'},
                        {key: 'assigned_factory.name', name: 'Factory'},
                        {key: 'user.name', name: 'Evaluated By'},
                        {key: 'evaluated_at', name: 'Evaluated On'},
                      ]"
                            >
                                <el-table-column
                                    fixed="right"
                                    label="Operations"
                                    width="250">
                                    <template #default="scope">

                                        <inertia-link
                                            class="inline-flex items-center px-4 py-1 border-green-600 border hover:bg-green-700 hover:border-transparent hover:text-white rounded-sm font-semibold text-xs text-green-900 uppercase tracking-widest active:bg-green-900 focus:outline-none focus:border-green-900 focus:shadow-outline-green transition ease-in-out duration-150"
                                            :href="route('purchase.orders.show',{ purchase_order: scope.row.id })">
                                            View
                                        </inertia-link>

                                        <inertia-link
                                            class="inline-flex items-center px-4 py-1 border-green-600 border hover:bg-green-700 hover:border-transparent hover:text-white rounded-sm font-semibold text-xs text-green-900 uppercase tracking-widest active:bg-green-900 focus:outline-none focus:border-green-900 focus:shadow-outline-green transition ease-in-out duration-150"
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

                        </el-tab-pane>
                        <el-tab-pane label="Rejected" key="Rejected">

                            <app-table
                                emptyText="No purchase orders created"
                                :items="purchase_orders.data"
                                :headers="[
                        {key: 'id', name: 'ID', width: '80px'},
                        {key: 'supplier.name', name: 'Supplier'},
                        {key: 'assigned_factory.name', name: 'Factory'},
                        {key: 'user.name', name: 'Evaluated By'},
                        {key: 'evaluated_at', name: 'Evaluated On'},
                      ]"
                            >
                                <el-table-column
                                    fixed="right"
                                    label="Operations"
                                    width="250">
                                    <template #default="scope">

                                        <inertia-link
                                            class="inline-flex items-center px-4 py-1 border-green-600 border hover:bg-green-700 hover:border-transparent hover:text-white rounded-sm font-semibold text-xs text-green-900 uppercase tracking-widest active:bg-green-900 focus:outline-none focus:border-green-900 focus:shadow-outline-green transition ease-in-out duration-150"
                                            :href="route('purchase.orders.show',{ purchase_order: scope.row.id })">
                                            View
                                        </inertia-link>
                                    </template>
                                </el-table-column>
                            </app-table>

                        </el-tab-pane>
                    </el-tabs>

                </div>

                <paginator class="mt-2"
                           :pagination="purchase_orders"
                ></paginator>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppSelect from "@/UIElements/AppSelect";
import AppTable from "@/UIElements/AppTable";
import Paginator from "@/UIElements/Paginator";
import SelectMenu from "@/UIElements/SelectMenu";
import Notify from "@/UIElements/Notify";

export default {
    name: "Index",
    components: {AppTable, AppSelect, Paginator, SelectMenu, Notify},
    props: {
        purchase_orders: {
            required: true,
            type: Object
        },
        factories: {
            type: Array
        },
        status: {
            required: false,
        },
        factory: {
            required: false,
        },
        flash: Object
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
        approvePurchaseOrder(id) {
            this.$inertia.form({})
                .post(route('purchase.orders.approve', {materialPurchaseOrder: id}));
        },

        rejectPurchaseOrder(id) {
            this.$inertia.form({})
                .post(route('purchase.orders.reject', {materialPurchaseOrder: id}));
        },
        viewPurchaseOrder(id) {
            this.$inertia.form({})
                .get(route('purchase.orders.show', {purchase_order: id}));
        },
        setSelectedFactory(val) {
            this.$inertia.visit(this.$inertia.page.url, {
                preserveState: true,
                preserveScroll: true,
                data: {
                    factory: val.id,
                    status: this.status,
                    page: 1
                }
            })
        },

        handleClick(obj, e) {
            this.$inertia.visit(this.$inertia.page.url, {
                preserveState: true,
                preserveScroll: true,
                data: {
                    factory: this.factory,
                    status: obj.$vnode.key,
                    page: 1
                }
            })
        },

    }
}
</script>

<style scoped>

</style>
