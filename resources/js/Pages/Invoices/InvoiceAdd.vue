<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create new Invoice
            </h2>
        </template>
        <div class="py-12 z-30">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mt-5">
                    <div class="p-5">
                        <div class="flex mb-8 justify-between">
                            <div class="w-2/4">

                                <div class="mb-4 md:mb-4 md:flex items-center">
                                    <label class="w-32 text-gray-800 block font-bold text-xs uppercase tracking-wide">Invoice
                                        No.</label>
                                    <span class="mr-4 inline-block hidden md:block">:</span>
                                    <div class="flex-1">
                                        <input
                                            v-model="invoice.number"
                                            class="appearance-none w-48 py-2 px-4 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm sm:text-sm border-gray-300 rounded-md"
                                            id="inline-full-name" type="text" placeholder="#INV-100001">
                                    </div>
                                </div>

                                <div class="mb-4 md:mb-4 md:flex items-center">
                                    <label class="w-32 text-gray-800 block font-bold text-xs uppercase tracking-wide">Purchase
                                        Order No.</label>
                                    <span class="mr-4 inline-block hidden md:block">:</span>
                                    <div class="flex-1">
                                        <input
                                            :disabled="isItemReadOnly"
                                            v-model="invoice.po_number"
                                            class="appearance-none w-48 py-2 px-4 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm sm:text-sm border-gray-300 rounded-md"
                                            id="inline-full-name" type="text" placeholder="#PO-100001">
                                    </div>
                                </div>


                                <div class="mb-2 md:mb-2 mt-10 md:flex items-center">
                                    <div class="flex items-center">
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
                                            v-model="defaultCurrency"
                                            @input="setSelectedCurrency"
                                        ></app-select>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <div class="mb-4 md:mb-4 md:flex items-center">
                                    <label class="w-32 text-gray-800 block font-bold text-xs uppercase tracking-wide">Invoice
                                        date</label>
                                    <span class="mr-4 inline-block hidden md:block">:</span>
                                    <div class="flex-1">
                                        <vc-date-picker
                                            color="white"
                                            v-model='invoice.invoiced_date'
                                        >
                                            <template v-slot="{ inputValue, inputEvents }">
                                                <input
                                                    class="appearance-none border w-48 py-2 px-4 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                    id="date"
                                                    v-on="inputEvents"
                                                    :value="inputValue"
                                                />
                                            </template>
                                        </vc-date-picker>
                                    </div>
                                </div>

                                <div class="mb-4 md:mb-4 md:flex items-center">
                                    <label class="w-32 text-gray-800 block font-bold text-xs uppercase tracking-wide">
                                        Factory
                                    </label>
                                    <span class="mr-4 inline-block hidden md:block">:</span>
                                    <div class="flex-1">
                                        <app-select
                                            :disabled="isItemReadOnly"
                                            class="w-48"
                                            placeholder="Select Factory"
                                            option-label="name"
                                            option-value="id"
                                            :filterable="true"
                                            :options="factories"
                                            v-model="invoice.factory"
                                            @input="setFactoryId"
                                        ></app-select>
                                    </div>
                                </div>

                                <div class="md:flex items-center">
                                    <label class="w-32 text-gray-800 block font-bold text-xs uppercase tracking-wide">
                                        Supplier
                                    </label>
                                    <span class="mr-4 inline-block hidden md:block">:</span>
                                    <div class="flex-1">
                                        <app-select
                                            :disabled="isItemReadOnly"
                                            class="w-48"
                                            placeholder="Select Supplier"
                                            option-label="name"
                                            option-value="id"
                                            :filterable="true"
                                            :options="suppliers"
                                            v-model="invoice.supplier"
                                            @input="setSupplierId"
                                        ></app-select>
                                    </div>
                                </div>


                            </div>

                        </div>
                    </div>
                </div>
                <div class="mt-5 bg-white overflow-hidden shadow-xl sm:rounded-lg mt-5">
                    <div class="bg-gray-500 pl-5 pt-2 pb-2 text-white">
                        <h4>Add invoice items</h4>
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
                                                    class="w-48"
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
                                                    v-model="invoiceItem.color"
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
                                                                {{ selectedCurrency }}
                                                            </span>
                                                        </div>
                                                        <input type="text"
                                                               class="flex-shrink flex-grow flex-auto leading-normal w-32 flex-1 h-10 border-gray-300 rounded-md rounded-l-none focus:ring-indigo-500 focus:border-indigo-500 px-3 relative"
                                                               placeholder="0.00"
                                                               id="sub_total-value"
                                                               v-model="invoiceItem.unit_price"
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
                                                        v-model="invoiceItem.quantity"
                                                        class="text-right mb-1 focus:ring-indigo-500 focus:border-indigo-500 block w-48 shadow-sm sm:text-sm border-gray-300 rounded-md"
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
                                                                {{ selectedCurrency }}
                                                            </span>
                                                        </div>
                                                        <input type="text"
                                                               class="flex-shrink flex-grow flex-auto leading-normal w-32 flex-1 h-10 border-gray-300 rounded-md rounded-l-none focus:ring-indigo-500 focus:border-indigo-500 px-3 relative"
                                                               placeholder="0.00"
                                                               id="sub_total-value"
                                                               v-model="invoiceItem.sub_total">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                    <div v-if="invoice_item_has_error" @click="handleCloseErrorMessage">
                                        {{error_message}}
                                    </div>
                                    <form-button type="button" @handle-on-click="handleAddInvoiceItems">
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
                            <tr v-for="(item, index) in invoice.items">

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

                            <tr v-if="this.invoice.items.length > 0">
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
                                        {{defaultCurrency.name}} {{total_amount}}
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap flex flex-row">

                                </td>

                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <button
                        class="mt-10 ml-5 mb-5 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150"
                        @click="saveInvoice">Save
                    </button>

                    <div v-if="invoice_has_error" @click="handleCloseErrorMessage">
                        {{error_message}}
                    </div>
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
    name: "InvoiceAdd",
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
        materialPurchaseOrder: {
            required: false
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
            defaultCurrency: {},
            material: '',
            invoice: {
                number: '',
                po_number: '',
                invoiced_date: '',
                factory_id: '',
                factory: '',
                supplier_id: '',
                items: [],
            },
            invoiceItem: {
                material_name_id: null,
                unit: 'm',
                material: '',
                material_name: '',
                material_colour_id: null,
                material_colour: '',
                unit_price: '',
                sub_total: '',
                quantity: '',
                currency: '',
                colour: ''
            },
            invoiceItems: [],
            resetSelectOptions: false,
            isItemReadOnly: false,
            isSaving: false,
            total_amount: 0,
            total_qty: 0,
            invoice_item_has_error: false,
            invoice_has_error: false,
            error_message: '',
        }
    },
    mounted() {
        this.extractFactoryName(this.factories);
        this.defaultCurrency = this.currencies[Object.keys(this.currencies)[0]];
        this.selectedCurrency = this.defaultCurrency.name;

        this.copyMaterialPurchaseOrderToInvoice();
        this.invoice.invoiced_date = new Date();
        if (this.materialPurchaseOrder) {
            this.isItemReadOnly = true;
        }
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
            this.invoice.supplier_id = value.id;
        },
        setSelectedMaterial(value) {
            this.material = value;
            this.invoiceItem.material_name_id = this.material.id;
            this.invoiceItem.material_name = this.material.name;

            this.$inertia.visit(this.$inertia.page.url, {
                preserveState: true,
                preserveScroll: true,
                data: {
                    material_id: this.material.id
                }
            })
        },
        setSelectedColour(value) {
            this.invoiceItem.colour = value;
            this.invoiceItem.material_colour_id = value.id;
            this.invoiceItem.material_colour = value.name;
        },
        setSelectedUnit(value) {
            this.invoiceItem.unit_id = value.value;
            this.invoiceItem.unitValue = value.text;
        },
        resetinvoice() {
            this.invoice = {
                number: '',
                po_number: '',
                invoiced_date: '',
                factory_id: '',
                supplier_id: '',
                items: []
            }
        },
        resetInvoiceItems() {
            this.invoiceItem = {
                material_name_id: null,
                material: '',
                material_name: '',
                material_colour_id: null,
                material_colour: '',
                unit_price: '',
                sub_total: '',
                quantity: '',
                currency: '',
            };
            this.resetSelectOptions = true;
            this.material = '';
        },
        handleAddInvoiceItems() {
            if (this.isValidInvoiceItem()) {
                this.invoiceItem.currency = this.selectedCurrency;
                this.invoiceItem.unit = this.material.unit;
                this.invoiceItem.material = this.material;

                this.invoice.items.push(this.invoiceItem);
                this.resetInvoiceItems();
            }
        },
        saveInvoice() {
            if (this.isValidInvoice()) {
                this.$inertia.post('/invoices', this.invoice)
            }
        },
        getMaterialById(material_id) {
            return this.materials.[material_id];
        },
        getMaterialColorById(color_id) {
            return this.colours.[color_id];
        },
        copyMaterialPurchaseOrderToInvoice() {
            if (this.materialPurchaseOrder != null) {

                this.invoice.po_number = this.materialPurchaseOrder.id;
                this.invoice = {
                    po_number: this.materialPurchaseOrder.id,
                    factory_id: this.materialPurchaseOrder.factory_id,
                    factory: this.materialPurchaseOrder.assigned_factory,
                    supplier_id: this.materialPurchaseOrder.supplier_id,
                    supplier: this.materialPurchaseOrder.supplier,
                    items: [],
                }

                if (typeof this.materialPurchaseOrder.items != 'undefined') {
                    for (let item of this.materialPurchaseOrder.items) {
                        let material = this.getMaterialById(item.variation.material_id);
                        let color = this.getMaterialColorById(item.variation.colour_id);

                        this.invoice.items.push({
                            material_name_id: item.variation.material_id,
                            material: material,
                            material_name: material.name,
                            material_colour_id: item.variation.colour_id,
                            material_colour: color.name,
                            colour: color,
                            unit: item.unit,
                            unit_price: item.unit_price,
                            quantity: item.quantity,
                            sub_total: item.sub_total,
                            currency: item.currency,
                        });
                        this.selectedCurrency = item.currency;
                    }
                }

                for (let currency of this.currencies) {
                    if (currency.name == this.selectedCurrency) {
                        this.defaultCurrency = currency;
                    }
                }
            }
            this.calculateTotal();
        },
        setFactoryId(value) {
            this.invoice.factory_id = value.id;
        },
        setSelectedCurrency(value) {
            this.selectedCurrency = value.name;
        },
        calculateSubTotal() {
            this.invoiceItem.sub_total = (((this.invoiceItem.unit_price * this.invoiceItem.quantity) * 100) / 100).toFixed(2);
        },
        fixUnitPrice() {
            this.invoiceItem.unit_price = ((this.invoiceItem.unit_price * 100) / 100).toFixed(2);
            this.calculateSubTotal();
        },
        deleteItemHandler(index) {
            this.invoice.items.splice(index, 1);
            if (this.invoice.items.length == 0) {
                this.unSetItemsReadOnly();
            }
        },
        editItemHandler(index) {
            this.invoiceItem = this.invoice.items[index];
            this.material = this.invoiceItem.material;

            this.$inertia.visit(this.$inertia.page.url, {
                preserveState: true,
                preserveScroll: true,
                data: {
                    material_id: this.material.id
                }
            })

            this.setSelectedColour(this.invoiceItem.colour);
            this.invoice.items.splice(index, 1);
            this.calculateTotal();
        },
        calculateTotal() {
            this.total_amount = 0;
            this.total_qty = 0;
            for(let item of this.invoice.items) {
                this.total_amount = (((parseFloat(this.total_amount) + parseFloat(item.sub_total)) * 100) / 100).toFixed(2);
                this.total_qty = parseFloat(this.total_qty) + parseFloat(item.quantity);
            }
        },
        setItemsReadOnly() {
            this.isItemReadOnly = true;
        },
        unSetItemsReadOnly() {
            this.isItemReadOnly = false;
        },
        isValidInvoiceItem() {
            if (typeof (this.invoice.number) == 'undefined' || this.invoice.number == '') {
                this.invoice_item_has_error = true;
                this.error_message = "The invoice number is required.";
                return false;
            }

            if (typeof (this.invoice.invoiced_date) == 'undefined' || this.invoice.invoiced_date == '') {
                this.invoice_item_has_error = true;
                this.error_message = "The invoice date is required.";
                return false;
            }

            if (typeof (this.invoice.factory_id) == 'undefined' || this.invoice.factory_id == '') {
                this.invoice_item_has_error = true;
                this.error_message = "The factory should be selected.";
                return false;
            }

            if (typeof (this.invoice.supplier_id) == 'undefined' || this.invoice.supplier_id == '') {
                this.invoice_item_has_error = true;
                this.error_message = "The supplier should be selected.";
                return false;
            }


            if (this.invoiceItem.material_name == '') {
                this.invoice_item_has_error = true;
                this.error_message = "The material should be selected.";
                return false;
            }

            if (this.invoiceItem.material_colour == '') {
                this.invoice_item_has_error = true;
                this.error_message = "The color should be selected.";
                return false;
            }

            if (this.invoiceItem.unit_price == '') {
                this.invoice_item_has_error = true;
                this.error_message = "The unit price is required.";
                return false;
            }


            if (this.invoiceItem.quantity == '') {
                this.invoice_item_has_error = true;
                this.error_message = "The quantity is required.";
                return false;
            }

            return true;
        },
        isValidInvoice() {

            if (typeof (this.invoice.number) == 'undefined' || this.invoice.number == '') {
                this.invoice_has_error = true;
                this.error_message = "The invoice number is required.";
                return false;
            }

            if (typeof (this.invoice.invoiced_date) == 'undefined' || this.invoice.invoiced_date == '') {
                this.invoice_has_error = true;
                this.error_message = "The invoice date is required.";
                return false;
            }

            if (typeof (this.invoice.factory_id) == 'undefined' || this.invoice.factory_id == '') {
                this.invoice_has_error = true;
                this.error_message = "The factory should be selected.";
                return false;
            }

            if (typeof (this.invoice.supplier_id) == 'undefined' || this.invoice.supplier_id == '') {
                this.invoice_has_error = true;
                this.error_message = "The supplier should be selected.";
                return false;
            }

            if (this.invoice.items.length == 0) {
                this.invoice_has_error = true;
                this.error_message = "Please add the items before save.";
                return false;
            }

            return true;
        },

        handleCloseErrorMessage() {
            this.invoice_item_has_error = false;
            this.invoice_has_error = false;
        }
    }
}
</script>

<style scoped>

</style>
