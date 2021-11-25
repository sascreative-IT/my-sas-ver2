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
                                                v-model="invoice.po_number"
                                                class="appearance-none w-48 py-2 px-4 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                id="inline-full-name" type="text" placeholder="#PO-100001">
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
                                <div class="mb-1 md:mb-1 md:flex items-center">
                                    <label class="w-32 text-gray-800 block font-bold text-xs uppercase tracking-wide">Factory</label>
                                    <span class="mr-4 inline-block hidden md:block">:</span>
                                    <div class="flex-1">
<!--                                        <t-select-->
<!--                                                placeholder="Select an option"-->
<!--                                                :options="factoryNames"-->
<!--                                                v-model="invoice.factory_id"-->
<!--                                        ></t-select>-->

                                        <select v-model="invoice.factory_id">
                                            <option v-for="factory in factories" :value="factory.id"> {{factory.name}} </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-4 md:mb-4 md:flex items-center">
                                    <div class="flex items-center mt-4">
                                        <label
                                                class="w-32 text-gray-800 block font-bold text-xs uppercase tracking-wide">Supplier</label>
                                        <span class="mr-4 inline-block hidden md:block">:</span>
                                    </div>
                                    <div class="flex-1 -mt-4">
                                        <search-and-select
                                                :selection-options="suppliers"
                                                @change="setsupplier_id"
                                        ></search-and-select>
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
                                                <label for="price-value"
                                                       class="block text-sm font-medium text-gray-700">
                                                    Price</label>
                                                <div class="absolute">
                                                    <input
                                                            v-model="invoiceItem.price"
                                                            class="text-right mb-1 focus:ring-indigo-500 focus:border-indigo-500 block w-48 shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                            id="price-value"
                                                            placeholder="NZD"
                                                            type="text">
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
                                                            id="quantity-value" type="text">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
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
                                    Quantity
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-gray-800 uppercase tracking-wide text-xs font-bold">
                                    Price
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
                                        {{ item.quantity }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ item.price }}
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

                    <button class="mt-10 ml-5 mb-5 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150" @click="saveInvoice">Save</button>
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
    name: "InvoiceAdd",
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
        materialPurchaseOrder: {
            required: false
        }
    },
    data() {
        return {
            factoryNames: [],
            invoice: {
                number: '',
                po_number: '',
                invoiced_date: '',
                factory_id: '',
                supplier_id: '',
                items: [],
            },
            invoiceItem: {
                material_name_id: null,
                material_name: '',
                material_colour_id: null,
                material_colour: '',
                price: '',
                quantity: ''
            },
            invoiceItems: [],
            resetSelectOptions: false,
        }
    },
    mounted() {
        this.extractFactoryName(this.factories);
        this.copyMaterialPurchaseOrderToInvoice();
    },
    methods: {
        extractFactoryName(prop) {
            this.factoryNames = [];
            prop.forEach((val, index) => {
                this.factoryNames.push(val.name);
            })
        },
        setsupplier_id(value) {
            this.invoice.supplier_id = value;
        },
        setSelectedMaterial(value) {
            this.invoiceItem.material_name_id = value.value;
            this.invoiceItem.material_name = value.text;
        },
        setSelectedColour(value) {
            this.invoiceItem.material_colour_id = value.value;
            this.invoiceItem.material_colour = value.text;
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
                material_name: '',
                material_colour_id: null,
                material_colour: '',
                unit_id: null,
                unitValue: '',
                price: '',
                quantity: ''
            };
            this.resetSelectOptions = true;
        },
        handleAddInvoiceItems() {
            this.invoice.items.push(this.invoiceItem);
            this.resetInvoiceItems();
        },
        saveInvoice() {
            this.$inertia.post('/invoices', this.invoice)
        },
        getMaterialNameById(material_id) {
            return this.materials.[material_id];
        },
        getMaterialColorNameById(color_id) {
            return this.colours.[color_id];
        },
        copyMaterialPurchaseOrderToInvoice() {
            if (this.materialPurchaseOrder != null) {

                this.invoice.po_number = this.materialPurchaseOrder.id;
                this.invoice = {
                    po_number: this.materialPurchaseOrder.id,
                    factory_id: this.materialPurchaseOrder.factory_id,
                    supplier_id: this.materialPurchaseOrder.supplier_id,
                    items: [],
                }

                if (typeof this.materialPurchaseOrder.items != 'undefined') {
                    for(let item of this.materialPurchaseOrder.items) {
                        this.invoice.items.push({
                            material_name_id: item.variation.material_id,
                            material_name: this.getMaterialNameById(item.variation.material_id),
                            material_colour_id: item.variation.colour_id,
                            material_colour: this.getMaterialColorNameById(item.variation.colour_id),
                            unit_id: item.unit_id,
                            unitValue: item.unit,
                            price: item.price,
                            quantity: item.quantity
                        })
                    }
                }
            }
        }
    }
}
</script>

<style scoped>

</style>
