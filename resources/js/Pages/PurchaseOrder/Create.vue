<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create new Purchase Order
            </h2>
        </template>
        <div class="py-12 z-30">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mt-5">
                    <div class="p-5 grid grid-cols-2">
                        <div>
                            <div class="mb-4 md:mb-4 md:flex items-center">
                                <div class="flex items-center mt-4">
                                    <label
                                        class="w-32 text-gray-800 block font-bold text-xs uppercase tracking-wide">Supplier</label>
                                    <span class="mr-4 inline-block hidden md:block">:</span>
                                </div>
                                <div class="flex-1 -mt-4">
                                    <search-and-select
                                        :selection-options="suppliers"
                                        @change="setSupplierId"
                                    ></search-and-select>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="mb-1 md:mb-1 md:flex items-center">
                                <div class="flex items-center mt-4">
                                    <label
                                        class="w-32 text-gray-800 block font-bold text-xs uppercase tracking-wide">Factory</label>
                                    <span class="mr-4 inline-block hidden md:block">:</span>
                                </div>
                                <div class="flex-1 -mt-4">
                                    <search-and-select
                                        :selection-options="factories"
                                        @change="setFactoryId"
                                    ></search-and-select>
                                </div>
                            </div>

                            <div class="mb-1 md:mb-1 md:flex items-center">
                                <div class="flex items-center mt-4">
                                    <label
                                        class="w-32 text-gray-800 block font-bold text-xs uppercase tracking-wide">Currency</label>
                                    <span class="mr-4 inline-block hidden md:block">:</span>
                                </div>
                                <div class="flex-1 -mt-4">
                                    <search-and-select
                                        :selection-options="currencies"
                                        @change="setSelectedCurrency"
                                    ></search-and-select>
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
                                        <div class="w-48">
                                            <div class="">
                                                <label for="material_name"
                                                       class="block text-sm font-medium text-gray-700">
                                                    Material Name</label>
                                                <select-or-create-input
                                                        :selection-options="materials"
                                                        @change="setSelectedMaterial"
                                                        :reset="resetSelectOptions"
                                                ></select-or-create-input>
                                            </div>
                                        </div>
                                        <div class="w-48">
                                            <div class="">
                                                <label for="colour" class="block text-sm font-medium text-gray-700">
                                                    Colour</label>
                                                <select-or-create-input
                                                        :selection-options="colours"
                                                        @change="setSelectedColour"
                                                        :reset="resetSelectOptions"
                                                ></select-or-create-input>
                                            </div>
                                        </div>
                                        <div class="w-48">
                                            <div class="">
                                                <label for="unit_price-value"
                                                       class="block text-sm font-medium text-gray-700">
                                                    Unit Price</label>
                                                <div class="absolute">
                                                    <input
                                                            v-model="purchaseOrderItem.unit_price"
                                                            class="text-right mb-1 focus:ring-indigo-500 focus:border-indigo-500 block w-48 shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                            id="unit_price-value"
                                                            placeholder="NZD"
                                                            type="text" v-on:change="calculateSubTotal">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="w-48">
                                            <div class="">
                                                <label for="quantity-value"
                                                       class="block text-sm font-medium text-gray-700">
                                                    Quantity</label>
                                                <div class="absolute">
                                                    <input
                                                            v-model="purchaseOrderItem.quantity"
                                                            class="text-right mb-1 focus:ring-indigo-500 focus:border-indigo-500 block w-48 shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                            id="quantity-value" type="text" v-on:change="calculateSubTotal">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="w-48">
                                            <div class="">
                                                <label for="sub_total-value"
                                                       class="block text-sm font-medium text-gray-700">
                                                    Sub Total</label>
                                                <div class="absolute">
                                                    <input
                                                        v-model="purchaseOrderItem.sub_total"
                                                        class="text-right mb-1 focus:ring-indigo-500 focus:border-indigo-500 block w-48 shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                        id="sub_total-value"
                                                        placeholder="NZD"
                                                        type="text">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                    <form-button type="button" @handle-on-click="handleAddPurchaseOrderItems">
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
                                    Material Name
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-gray-800 uppercase tracking-wide text-xs font-bold">
                                    Colour
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-gray-800 uppercase tracking-wide text-xs font-bold">
                                    Unit Price
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-gray-800 uppercase tracking-wide text-xs font-bold">
                                    Quantity
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-gray-800 uppercase tracking-wide text-xs font-bold">
                                    Sub Total
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-gray-800 uppercase tracking-wide text-xs font-bold">
                                    Currency
                                </th>
                                <th scope="col"
                                    class="px-1 w-20 text-center py-3 text-gray-800 uppercase tracking-wide text-xs font-bold">
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="(item, index) in purchaseOrder.items">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ item.material_name }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ item.material_colour }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ item.unit_price }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ item.quantity }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ item.sub_total }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        NZD
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <button class="mt-10 ml-5 mb-5 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150" @click="savePurchaseOrder">Save</button>
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

export default {
    name: "Create",
    components: {
        DialogModal,
        FormButton,
        SelectOrCreateInput,
        SearchAndSelect
    },
    props: {
        factories: {
            required: true,
            type: Array
        },
        materials: {
            required: true,
            type: Object
        },
        colours: {
            required: true,
            type: Object
        },
        suppliers: {
            required: true,
            type: Object
        },
        units: {
            required: true,
            type: Object
        },
        currencies: {
            required: true,
            type: Object
        }
    },
    data() {
        return {
            factoryNames: [],
            purchaseOrder: {
                factory_id: '',
                supplier_id: '',
                items: [],
            },
            purchaseOrderItem: {
                material_name_id: null,
                unit : 'm',
                material_name: '',
                material_variation_id: null,
                material_colour: '',
                unit_price: '',
                sub_total: '',
                quantity: '',
                currency: '',
            },
            purchaseOrderItems: [],
            resetSelectOptions: false,
        }
    },
    mounted() {
        this.extractFactoryName(this.factories);
    },
    methods: {
        extractFactoryName(prop) {
            this.factoryNames = [];
            prop.forEach((val, index) => {
                this.factoryNames.push(val.name);
            })
        },
        setSupplierId(value) {
            this.purchaseOrder.supplier_id = value;
        },
        setFactoryId(value) {
            this.purchaseOrder.factory_id = value;
        },
        setSelectedMaterial(value) {
            this.purchaseOrderItem.material_name_id = value.value;
            this.purchaseOrderItem.material_name = value.text;
        },
        setSelectedColour(value) {
            this.purchaseOrderItem.material_variation_id = value.value;
            this.purchaseOrderItem.material_colour = value.text;
        },
        setSelectedUnit(value) {
            this.purchaseOrderItem.unit = value.text;
        },
        setSelectedCurrency(value) {

        },
        resetPurchaseOrder() {
            this.purchaseOrder = {
                factory_id: '',
                supplier_id: '',
                items: []
            }
        },
        resetPurchaseOrderItems() {
            this.purchaseOrderItem = {
                material_name_id: null,
                material_name: '',
                material_variation_id: null,
                material_colour: '',
                unit: 'm',
                unitValue: '',
                unit_price: '',
                sub_total: '',
                quantity: '',
                currency: '',
            };
            this.resetSelectOptions = true;
        },
        handleAddPurchaseOrderItems() {
            this.purchaseOrder.items.push(this.purchaseOrderItem);
            this.resetPurchaseOrderItems();
        },
        savePurchaseOrder() {
            this.$inertia.post(route('purchase.orders.store'), this.purchaseOrder)
        },
        calculateSubTotal() {
            this.purchaseOrderItem.sub_total = this.purchaseOrderItem.unit_price * this.purchaseOrderItem.quantity;
        }

    }
}
</script>

<style scoped>

</style>
