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
                                    <app-select
                                        :disabled="isItemReadOnly"
                                        class="w-48"
                                        placeholder="Select Supplier"
                                        option-label="name"
                                        option-value="id"
                                        :filterable="true"
                                        :options="suppliers"
                                        v-model="purchaseOrder.supplier"
                                        @input="setSupplierId"
                                    ></app-select>
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
                                    <app-select
                                        :disabled="isItemReadOnly"
                                        class="w-48"
                                        placeholder="Select Factory"
                                        option-label="name"
                                        option-value="id"
                                        :filterable="true"
                                        :options="factories"
                                        v-model="purchaseOrder.factory"
                                        @input="setFactoryId"
                                    ></app-select>
                                </div>
                            </div>

                            <div class="mb-1 md:mb-1 md:flex items-center">
                                <div class="flex items-center mt-4">
                                    <label
                                        class="w-32 text-gray-800 block font-bold text-xs uppercase tracking-wide">Currency</label>
                                    <span class="mr-4 inline-block hidden md:block">:</span>
                                </div>
                                <div class="flex-1 -mt-4">
                                    <app-select
                                        :disabled="isItemReadOnly"
                                        class="w-48"
                                        placeholder="Select Currency"
                                        option-label="name"
                                        option-value="id"
                                        :filterable="true"
                                        :options="currencies"
                                        v-model="selectedCurrency"
                                        @input="setSelectedCurrency"
                                    ></app-select>
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
                                                <app-select
                                                    placeholder="Select Material"
                                                    option-label="name"
                                                    option-value="id"
                                                    :filterable="true"
                                                    :options="materials"
                                                    v-model="material"
                                                    @input="setSelectedMaterial"
                                                ></app-select>
                                            </div>
                                        </div>
                                        <div class="w-48">
                                            <div class="">
                                                <label for="colour" class="block text-sm font-medium text-gray-700">
                                                    Colour</label>
                                                <app-select
                                                    placeholder="Select Colour"
                                                    option-label="name"
                                                    option-value="id"
                                                    :filterable="true"
                                                    :options="colours"
                                                    v-model="purchaseOrderItem.color"
                                                    @input="setSelectedColour"
                                                ></app-select>
                                            </div>
                                        </div>
                                        <div class="w-48">
                                            <div class="">
                                                <label for="unit_price-value"
                                                       class="block text-sm font-medium text-gray-700">
                                                    Unit Price
                                                    <template v-if="material">
                                                        ({{ material.unit.toUpperCase() }})
                                                    </template>
                                                </label>
                                                <div class="absolute">
                                                    <div class="flex flex-wrap items-stretch w-full mb-4 relative">
                                                        <div class="flex -mr-px">
                                                            <span
                                                                class="flex items-center leading-normal bg-grey-lighter rounded rounded-r-none border border-r-0 border-grey-light px-3 whitespace-no-wrap text-grey-dark text-sm">
                                                                {{ selectedCurrency.name }}
                                                            </span>
                                                        </div>
                                                        <input type="text"
                                                               class="flex-shrink flex-grow flex-auto leading-normal w-32 flex-1 h-10 border-gray-300 rounded-md rounded-l-none focus:ring-indigo-500 focus:border-indigo-500 px-3 relative"
                                                               placeholder="0.00"
                                                               id="sub_total-value"
                                                               v-model="purchaseOrderItem.unit_price"
                                                               v-on:change="fixUnitPrice">
                                                    </div>
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
                                                        class="text-right mb-1 focus:ring-indigo-500 focus:border-indigo-500 block shadow-sm sm:text-sm border-gray-300 rounded-md w-32"
                                                        id="quantity-value"
                                                        type="text"
                                                        v-on:change="calculateSubTotal">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="w-48">
                                            <div class="">
                                                <label for="sub_total-value"
                                                       class="block text-sm font-medium text-gray-700">
                                                    Sub Total</label>
                                                <div class="absolute">
                                                    <div class="flex flex-wrap items-stretch w-full mb-4 relative">
                                                        <div class="flex -mr-px">
                                                            <span
                                                                class="flex items-center leading-normal bg-grey-lighter rounded rounded-r-none border border-r-0 border-grey-light px-3 whitespace-no-wrap text-grey-dark text-sm">
                                                                {{ selectedCurrency.name }}
                                                            </span>
                                                        </div>
                                                        <input type="text"
                                                               class="flex-shrink flex-grow flex-auto leading-normal w-32 flex-1 h-10 border-gray-300 rounded-md rounded-l-none focus:ring-indigo-500 focus:border-indigo-500 px-3 relative"
                                                               placeholder="0.00"
                                                               id="sub_total-value"
                                                               v-model="purchaseOrderItem.sub_total">
                                                    </div>
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
                                        {{ item.currency }} {{ item.unit_price }} / {{ item.unit }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ item.quantity }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ item.currency }} {{ item.sub_total }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap flex flex-row">
                                    <div class="text-sm font-medium" v-on:click="deleteItemHandler(index)">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                             fill="currentColor">
                                            <path fill-rule="evenodd"
                                                  d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                  clip-rule="evenodd"/>
                                        </svg>
                                    </div>

                                    <div class="text-sm font-medium" v-on:click="editItemHandler(index)">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                             fill="currentColor">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                        </svg>
                                    </div>
                                </td>

                            </tr>

                            <tr v-if="this.purchaseOrder.items.length > 0">
                                <td class="px-6 py-4 font-bold whitespace-nowrap" colspan="3">
                                    Total
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                     {{total_qty}}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{selectedCurrency.name}} {{total_amount}}
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap flex flex-row">

                                </td>

                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <button v-if="!isSaving"
                        class="mt-10 ml-5 mb-5 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150"
                        @click="savePurchaseOrder">Save
                    </button>

                    <button v-if="isSaving"
                            class="mt-10 ml-5 mb-5 inline-flex items-center px-4 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:shadow-outline-gray transition ease-in-out duration-150">
                        Please wait...
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
    name: "Create",
    components: {
        DialogModal,
        FormButton,
        SelectOrCreateInput,
        SearchAndSelect,
        AppSelect,
    },
    props: {
        factories: {
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
        suppliers: {
            required: true,
            type: Array
        },
        units: {
            required: true,
            type: Object
        },
        currencies: {
            required: true,
            type: Array
        }
    },
    data() {
        return {
            factoryNames: [],
            selectedCurrency: '',
            material: '',
            purchaseOrder: {
                factory_id: '',
                factory: '',
                supplier_id: '',
                supplier: '',
                items: [],
            },
            purchaseOrderItem: {
                material: '',
                material_name_id: null,
                unit: 'm',
                material_name: '',
                material_variation_id: null,
                material_colour: '',
                color: '',
                unit_price: '',
                sub_total: '',
                quantity: '',
                currency: '',
            },
            purchaseOrderItems: [],
            resetSelectOptions: false,
            isItemReadOnly: false,
            isSaving: false,
            total_amount: 0,
            total_qty: 0
        }
    },
    mounted() {
        this.extractFactoryName(this.factories);
        this.selectedCurrency = this.currencies[Object.keys(this.currencies)[0]];
    },
    methods: {
        extractFactoryName(prop) {
            this.factoryNames = [];
            if (Array.isArray(prop)) {
                prop.forEach((val, index) => {
                    this.factoryNames.push(val.name);
                })
            }
        },
        setSupplierId(value) {
            this.purchaseOrder.supplier = value;
            this.purchaseOrder.supplier_id = value.id;
        },
        setFactoryId(value) {
            this.purchaseOrder.factory = value;
            this.purchaseOrder.factory_id = value.id;
        },
        setSelectedMaterial(value) {
            this.material = value;
            this.purchaseOrderItem.material_name_id = value.value;
            this.purchaseOrderItem.material_name = this.material.name;

            this.$inertia.visit(this.$inertia.page.url, {
                preserveState: true,
                preserveScroll: true,
                data: {
                    material_id: value.id
                }
            })
        },
        setSelectedColour(value) {
            this.purchaseOrderItem.color = value;
            this.purchaseOrderItem.material_variation_id = this.purchaseOrderItem.color.id;
            this.purchaseOrderItem.material_colour = this.purchaseOrderItem.color.name;

        },
        setSelectedUnit(value) {
            this.purchaseOrderItem.unit = value.text;
        },
        setSelectedCurrency(value) {
            this.selectedCurrency = value;
        },
        resetPurchaseOrder() {
            this.purchaseOrder = {
                factory_id: '',
                supplier_id: '',
                supplier: '',
                items: []
            }
        },
        resetPurchaseOrderItems() {
            this.purchaseOrderItem = {
                material_name_id: null,
                material: '',
                material_name: '',
                material_variation_id: null,
                material_colour: '',
                color: '',
                unit: 'm',
                unitValue: '',
                unit_price: '',
                sub_total: '',
                quantity: '',
                currency: this.selectedCurrency.name,
            };
            this.resetSelectOptions = true;
            this.material = '';
        },
        handleAddPurchaseOrderItems() {
            if (this.isValidPurchaseOrderItem()) {
                this.purchaseOrderItem.currency = this.selectedCurrency.name;
                this.purchaseOrderItem.unit = this.material.unit;
                this.purchaseOrderItem.material = this.material;
                this.purchaseOrder.items.push(this.purchaseOrderItem);
                this.calculateTotal();
                this.resetPurchaseOrderItems();
                this.setItemsReadOnly();
            }
        },
        savePurchaseOrder() {
            if (this.isValidPurchaseOrder()) {
                this.isSaving = true;
                this.$inertia.post(route('purchase.orders.store'), this.purchaseOrder)
            }
        },
        calculateSubTotal() {
            this.purchaseOrderItem.sub_total = (((this.purchaseOrderItem.unit_price * this.purchaseOrderItem.quantity) * 100) / 100).toFixed(2);
        },
        fixUnitPrice() {
            this.purchaseOrderItem.unit_price = ((this.purchaseOrderItem.unit_price * 100) / 100).toFixed(2);
            this.calculateSubTotal();
        },
        deleteItemHandler(index) {
            this.purchaseOrder.items.splice(index, 1);
            if (this.purchaseOrder.items.length == 0) {
                this.unSetItemsReadOnly();
                this.calculateTotal();
            }
        },

        editItemHandler(index) {
            this.purchaseOrderItem = this.purchaseOrder.items[index];
            this.material = this.purchaseOrderItem.material;
            this.$inertia.visit(this.$inertia.page.url, {
                preserveState: true,
                preserveScroll: true,
                data: {
                    material_id: this.purchaseOrderItem.material.id
                }
            })


            this.purchaseOrder.items.splice(index, 1);
            this.calculateTotal();
        },

        setItemsReadOnly() {
            this.isItemReadOnly = true;
        },
        unSetItemsReadOnly() {
            this.isItemReadOnly = false;
        },
        isValidPurchaseOrderItem() {
            if (this.purchaseOrder.supplier_id == '') {
                alert("Please choose the supplier");
                return false;
            }

            if (this.purchaseOrder.factory_id == '') {
                alert("Please choose the factory");
                return false;
            }

            if (this.selectedCurrency == '') {
                alert("Please choose the currency");
                return false;
            }

            if (this.purchaseOrderItem.material_name_id == '') {
                alert("Please choose the material name");
                return false;
            }

            if (this.purchaseOrderItem.color == '') {
                alert("Please choose the color");
                return false;
            }

            if (this.purchaseOrderItem.unit_price == '') {
                alert("Please enter the unit price");
                return false;
            }

            if (this.purchaseOrderItem.quantity == '') {
                alert("Please enter the quantity");
                return false;
            }

            return true;
        },
        isValidPurchaseOrder() {
            if (this.purchaseOrder.supplier_id == '') {
                alert("Please choose the supplier");
                return false;
            }

            if (this.purchaseOrder.factory_id == '') {
                alert("Please choose the factory");
                return false;
            }

            if (this.selectedCurrency == '') {
                alert("Please choose the currency");
                return false;
            }

            if (this.purchaseOrder.items.length == 0) {
                alert("Please add the items before save.");
                return false;
            }
            return true;
        },
        calculateTotal() {
            this.total_amount = 0;
            this.total_qty = 0;
            for(let item of this.purchaseOrder.items) {
                this.total_amount = (((parseFloat(this.total_amount) + parseFloat(item.sub_total)) * 100) / 100).toFixed(2);
                this.total_qty = parseFloat(this.total_qty) + parseFloat(item.quantity);
            }
        }

    }
}
</script>

<style scoped>

</style>
