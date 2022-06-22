<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create new Stock Out
            </h2>
        </template>
        <div class="py-12 z-30">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mt-5">
                    <div class="p-5">
                        <div class="flex mb-8 justify-between">
                            <div class="w-2/4">

                                <div class="mb-4 md:mb-4 md:flex items-center">
                                    <label class="w-32 text-gray-800 block font-bold text-xs uppercase tracking-wide">
                                        Order ID
                                    </label>
                                    <span class="mr-4 inline-block hidden md:block">:</span>
                                    <div class="flex-1">
                                        <input
                                            v-model="stockOut.order_public_id"
                                            class="appearance-none w-48 py-2 px-4 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm sm:text-sm border-gray-300 rounded-md"
                                            id="inline-full-name" type="text" placeholder="100001">
                                    </div>
                                </div>

                                <div class="mb-4 md:mb-4 md:flex items-center">
                                    <label class="w-32 text-gray-800 block font-bold text-xs uppercase tracking-wide">Customer
                                        ID.</label>
                                    <span class="mr-4 inline-block hidden md:block">:</span>
                                    <div class="flex-1">
                                        <app-select
                                            class="w-48"
                                            placeholder="Select Customer"
                                            option-label="name"
                                            option-value="id"
                                            :filterable="true"
                                            :options="customers"
                                            v-model="stockOut.customer"
                                            @input="setSelectedCustomer"
                                        ></app-select>
                                    </div>
                                </div>

                            </div>

                            <div>

                                <div class="mb-4 md:mb-4 md:flex items-center">
                                    <label class="w-32 text-gray-800 block font-bold text-xs uppercase tracking-wide">
                                        Factory ID
                                    </label>
                                    <span class="mr-4 inline-block hidden md:block">:</span>
                                    <div class="flex-1">
                                        <app-select
                                            class="w-48"
                                            placeholder="Select Factory"
                                            option-label="name"
                                            option-value="id"
                                            :filterable="true"
                                            :options="factories"
                                            v-model="stockOut.factory"
                                            @input="setFactoryId"
                                        ></app-select>
                                    </div>
                                </div>


                            </div>

                        </div>
                    </div>
                </div>
                <div class="mt-5 bg-white overflow-hidden shadow-xl sm:rounded-lg mt-5">
                    <div class="bg-gray-500 pl-5 pt-2 pb-2 text-white">
                        <h4>Add Items</h4>
                    </div>
                    <div class="p-5 h-64 relative">
                        <form class="">
                            <div class="shadow overflow-hidden sm:rounded-md">
                                <div class="px-4 py-5 bg-white sm:p-6 h-32">
                                    <div class="flex justify-evenly px-4">


                                        <div class="w-1/6 pr-5">
                                            <div class="">
                                                <label class="text-base font-medium text-gray-700">
                                                    Style code
                                                </label>
                                                <app-select
                                                    placeholder="Select Style code"
                                                    option-label="code"
                                                    option-value="id"
                                                    :filterable="true"
                                                    :options="styles"
                                                    v-model="stockOutItem.style"
                                                    @input="styleSelected"
                                                ></app-select>
                                            </div>
                                        </div>

                                        <div class="w-1/6 pr-5">
                                            <div class="">
                                                <label class="text-base font-medium text-gray-700">
                                                    Style Panel
                                                </label>
                                                <app-select
                                                    placeholder="Select Style code"
                                                    clearable
                                                    option-label="name"
                                                    option-value="id"
                                                    :filterable="true"
                                                    :options="style_panels"
                                                    v-model="stockOutItem.style_panel"
                                                    @input="stylePanelSelected"
                                                ></app-select>
                                            </div>
                                        </div>

                                        <div class="w-1/6 pr-5">
                                            <div class="">
                                                <label class="text-base font-medium text-gray-700">
                                                    Material
                                                </label>
                                                <app-select
                                                    placeholder="Select Material"
                                                    clearable
                                                    option-label="name"
                                                    option-value="id"
                                                    :filterable="true"
                                                    :options="materials"
                                                    v-model="stockOutItem.material"
                                                    @input="setSelectedMaterial"
                                                ></app-select>
                                            </div>
                                        </div>

                                        <div class="w-1/6 pr-5">
                                            <div class="">
                                                <label class="text-base font-medium text-gray-700">
                                                    Colour
                                                </label>
                                                <app-select
                                                    placeholder="Select Style code"
                                                    option-label="name"
                                                    option-value="id"
                                                    :filterable="true"
                                                    :options="colours"
                                                    v-model="stockOutItem.color"
                                                    @input="setSelectedColor"
                                                ></app-select>
                                            </div>
                                        </div>

                                        <div class="w-1/6 pr-5">
                                            <div class="">
                                                <label class="text-base font-medium text-gray-700">
                                                    Supplier
                                                </label>
                                                <app-select
                                                    placeholder="Select Supplier"
                                                    option-label="name"
                                                    option-value="id"
                                                    :filterable="true"
                                                    :options="suppliers"
                                                    v-model="stockOutItem.supplier"
                                                    @input="setSelectedSupplier"
                                                ></app-select>
                                            </div>
                                        </div>

                                        <div class="w-1/6 pr-5">
                                            <div class="">
                                                <label class="text-base font-medium text-gray-700">
                                                    No of pieces
                                                </label>
                                                <input
                                                    v-model="stockOutItem.pieces"
                                                    class="h-9 mt-1 focus:ring-indigo-500 focus:border-indigo-500 block shadow-sm sm:text-sm border-gray-300 rounded-md w-20"
                                                    type="text">
                                            </div>
                                        </div>

                                        <div class="w-1/6">
                                            <label class="text-base font-medium text-gray-700">
                                                Usage
                                                <template v-if="materialInventory">
                                                    (Avail. {{ materialInventory.available_quantity }})
                                                </template>
                                            </label>
                                            <div>
                                                <div class="flex flex-wrap items-stretch w-full mb-4 relative">
                                                    <div class="flex -mr-px">
                                                            <span
                                                                class="flex items-center leading-normal bg-grey-lighter rounded rounded-r-none border border-r-0 border-grey-light px-3 whitespace-no-wrap text-grey-dark text-sm">
                                                                <template v-if="selectedMaterial">
                                                                    {{ selectedMaterial.unit }}
                                                                </template>
                                                                <template v-else>
                                                                   m
                                                                </template>
                                                            </span>
                                                    </div>
                                                    <input type="text"
                                                           class="flex-shrink flex-grow flex-auto leading-normal w-20 flex-1 h-10 border-gray-300 rounded-md rounded-l-none focus:ring-indigo-500 focus:border-indigo-500 px-3 relative"
                                                           placeholder="0.00"
                                                           id="sub_total-value"
                                                           v-model="stockOutItem.usage">
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                    <form-button type="button" @handle-on-click="handleAddStockItems">
                                        Add item
                                    </form-button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="p-5">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-gray-800 uppercase tracking-wide text-xs font-bold">
                                    Style
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-gray-800 uppercase tracking-wide text-xs font-bold">
                                    Panel
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-gray-800 uppercase tracking-wide text-xs font-bold">
                                    Supplier
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-gray-800 uppercase tracking-wide text-xs font-bold">
                                    Material
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-gray-800 uppercase tracking-wide text-xs font-bold">
                                    Colour
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-gray-800 uppercase tracking-wide text-xs font-bold">
                                    Pieces
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-gray-800 uppercase tracking-wide text-xs font-bold">
                                    Usage
                                </th>
                                <th scope="col"
                                    class="px-1 w-20 text-center py-3 text-gray-800 uppercase tracking-wide text-xs font-bold">
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="(item, index) in stockOut.items">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ item.style.name }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ item.style_panel.name }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ item.supplier.name }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ item.material.name }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ item.color.name }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ item.pieces }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ item.usage }} {{ item.material.unit }}
                                    </div>
                                </td>

                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <button
                        class="mt-10 ml-5 mb-5 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150"
                        @click="handleSaveStockOut">Save
                    </button>
                </div>
            </div>
        </div>
    </app-layout>
</template>
<script>
import DialogModal from "@/Jetstream/DialogModal";
import FormButton from "@/UIElements/FormButton";
import SelectOrCreateInput from "@/Pages/Suppliers/SelectOrCreateInput";
import SearchAndSelect from "@/Pages/Suppliers/SearchAndSelect";
import AppSelect from "@/UIElements/AppSelect";

export default {
    name: "StockOutCreate",
    props: {
        factories: {
            required: true,
            type: Array
        },
        styles: {
            required: true,
            type: Array
        },
        style_type: {
            required: true,
            type: String
        },
        style_panels: {
            required: true,
            type: Array
        },
        materials: {
            required: true,
            type: Array
        },
        colours: {
            required: true,
            type: Array
        },
        customers: {
            required: true,
            type: Array
        },
        suppliers: {
            required: true,
            type: Array
        },
        selectedMaterial: {
            type: Object
        },
        materialInventory: {
            type: Object
        }
    },
    components: {
        DialogModal,
        AppSelect,
        FormButton,
        SelectOrCreateInput,
        SearchAndSelect
    },
    data() {
        return {
            stockOut: {
                order_public_id: null,
                factory: null,
                factory_id: null,
                customer_id: null,
                created_by_id: null,
                customer: null,
                items: [],
            },
            stockOutItem: {
                style: null,
                style_id: null,
                style_panel: null,
                style_panel_id: null,
                material: '',
                material_id: '',
                color: null,
                colour_id: null,
                supplier: null,
                supplier_id: null,
                pieces: '',
                usage: '',
                usageMeasurement: ''
            },
            stockOutItems: [],
            resetSelectOptions: false,
        }
    },
    mounted() {
        this.stockOutItem.usageMeasurement = this.stockOutItem.material.unit;
    },
    methods: {
        handleAddStockItems() {
            if (this.isValidItem()) {
                this.stockOut.items.push(this.stockOutItem);
                this.resetStockOutItem();
            }
        },
        handleSaveStockOut() {
            console.log(this.stockOut);
            this.$inertia.post(route('stock.out.store'), this.stockOut)
        },
        handleLoadOrderData() {
            this.$inertia.visit(this.$inertia.page.url, {
                preserveState: true,
                preserveScroll: true,
                data: {
                    order_id: this.stockOut.order_public_id
                }
            })
        },
        styleSelected() {
            this.stockOutItem.style_id = this.stockOutItem.style.id;
            this.$inertia.visit(this.$inertia.page.url, {
                preserveState: true,
                preserveScroll: true,
                data: {
                    style_id: this.stockOutItem.style.id
                }
            })
        },
        stylePanelSelected() {
            this.stockOutItem.style_panel_id = this.stockOutItem.style_panel.id;
            this.$inertia.visit(this.$inertia.page.url, {
                preserveState: true,
                preserveScroll: true,
                data: {
                    style_panel_id: this.stockOutItem.style_panel.id
                }
            })
        },
        setSelectedMaterial() {
            this.stockOutItem.material_id = this.stockOutItem.material.id;
            this.stockOutItem.usageMeasurement = this.stockOutItem.material.unit;
            this.$inertia.visit(this.$inertia.page.url, {
                preserveState: true,
                preserveScroll: true,
                data: {
                    material_id: this.stockOutItem.material_id
                }
            })
        },
        setSelectedColor(value) {
            this.stockOutItem.colour_id = value.id;
            this.stockOutItem.colour = value;
            this.$inertia.visit(this.$inertia.page.url, {
                preserveState: true,
                preserveScroll: true,
                data: {
                    colour_id: value.id
                }
            })
        },
        setSelectedCustomer() {
            this.stockOut.customer_id = this.stockOut.customer.id;
        },
        setFactoryId(value) {
            this.stockOut.factory = value;
            this.stockOut.factory_id = value.id;
            this.$inertia.visit(this.$inertia.page.url, {
                preserveState: true,
                preserveScroll: true,
                data: {
                    factory_id: value.id
                }
            })
        },
        setSelectedSupplier(value) {
            this.stockOut.supplier = value;
            this.stockOut.supplier_id = value.id;
            this.$inertia.visit(this.$inertia.page.url, {
                preserveState: true,
                preserveScroll: true,
                data: {
                    supplier_id: this.stockOut.supplier_id
                }
            })
        },
        resetStockOutItem() {
            this.stockOutItem = {
                style: null,
                style_id: null,
                style_panel: null,
                style_panel_id: null,
                material: '',
                material_id: '',
                supplier: null,
                supplier_id: null,
                color: null,
                colour_id: null,
                pieces: '',
                usage: ''
            };
        },
        resetStockOut() {
            this.resetStockOutItem();
            this.stockOut = {
                order_public_id: null,
                factory_id: null,
                customer_id: null,
                created_by_id: null,
                items: [],
            }
        },
        isValidItem() {
            return true;
            if (this.stockOutItem.usage > this.materialInventory.available_quantity) {
                alert("Invalid usage");
                return false;
            }
        }
    }
}
</script>

<style scoped>

</style>
