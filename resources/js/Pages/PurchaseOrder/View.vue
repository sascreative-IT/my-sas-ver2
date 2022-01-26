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
                    <div class="p-5">
                        <div class="flex mb-8 justify-between">
                            <div>
                                <div class="mb-4 md:mb-4 md:flex items-center">
                                    <div class="mb-4 md:mb-4 md:flex items-center">
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
                                        ></app-select>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="mb-4 md:mb-4 md:flex items-center">
                                    <div class="mb-4 md:mb-4 md:flex items-center">
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
                                        ></app-select>
                                    </div>
                                </div>

                                <div class="md:flex items-center">
                                    <div class="mb-4 md:mb-4 md:flex items-center">
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
                                        ></app-select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-5 bg-white overflow-hidden shadow-xl sm:rounded-lg mt-5">
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


                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="(item, index) in purchaseOrderItems">
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



                            </tr>
                            </tbody>
                        </table>
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
import Notify from "@/UIElements/Notify";

export default {
    name: "Edit",
    components: {
        DialogModal,
        FormButton,
        SelectOrCreateInput,
        SearchAndSelect,
        AppSelect,
        Notify
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
        },
        purchaseOrder: {
            required: true,
            type: Object
        },
        flash: Object
    },
    data() {
        return {
            factoryNames: [],
            selectedCurrency: '',
            material: '',
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
            total_qty: 0,
            purchase_order_item_has_error: false,
            purchase_order_has_error: false,
            error_message: '',
        }
    },
    mounted() {

        this.selectedCurrency = this.currencies[Object.keys(this.currencies)[1]];
        if (this.purchaseOrder.items.length > 0) {
            let currencyName = this.purchaseOrder.items[0].currency;
            for(let currency of this.currencies) {
                if (currency.name == currencyName) {
                   this.selectedCurrency = currency;
                }
            }
        }
        this.purchaseOrder.factory = this.purchaseOrder.assigned_factory;

        this.total_amount = 0;
        this.total_qty = 0;
        for(let item of this.purchaseOrder.items) {
            this.purchaseOrderItem = item;
            this.purchaseOrderItem.material_colour = this.getColorNameById(item.variation.colour_id);
            this.purchaseOrderItem.material_name = this.getMaterialNameById(item.variation.material_id);
            this.purchaseOrderItems.push(this.purchaseOrderItem);
            this.total_amount = (((parseFloat(this.total_amount) + parseFloat(item.sub_total)) * 100) / 100).toFixed(2);
            this.total_qty = parseFloat(this.total_qty) + parseFloat(item.quantity);
        }
        this.isItemReadOnly = true;
    },
    methods: {
        /*
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
            this.purchase_order_item_has_error = false;
            if (this.purchaseOrder.supplier_id == '') {
                this.purchase_order_item_has_error = true;
                this.error_message = "The supplier should be selected.";
                return false;
            }

            if (this.purchaseOrder.factory_id == '') {
                this.purchase_order_item_has_error = true;
                this.error_message = "The factory should be selected.";
                return false;
            }

            if (this.selectedCurrency == '') {
                this.purchase_order_item_has_error = true;
                this.error_message = "The currency should be selected.";
                return false;
            }

            if (this.purchaseOrderItem.material_name_id == '') {
                this.purchase_order_item_has_error = true;
                this.error_message = "The material should be selected.";
                return false;
            }

            if (this.purchaseOrderItem.color == '') {
                this.purchase_order_item_has_error = true;
                this.error_message = "The color should be selected.";
                return false;
            }

            if (this.purchaseOrderItem.unit_price == '') {
                this.purchase_order_item_has_error = true;
                this.error_message = "The unit price is required.";
                return false;
            }

            if (this.purchaseOrderItem.quantity == '') {
                this.purchase_order_item_has_error = true;
                this.error_message = "The quantity is required.";
                return false;
            }

            if (this.purchaseOrderItem.sub_total == '') {
                this.purchase_order_item_has_error = true;
                this.error_message = "The sub total is required.";
                return false;
            }

            return true;
        },
        isValidPurchaseOrder() {
            if (this.purchaseOrder.supplier_id == '') {
                this.purchase_order_has_error = true;
                this.error_message = "The supplier should be selected.";
                return false;
            }

            if (this.purchaseOrder.factory_id == '') {
                this.purchase_order_has_error = true;
                this.error_message = "The factory should be selected.";
                return false;
            }

            if (this.selectedCurrency == '') {
                this.purchase_order_has_error = true;
                this.error_message = "The currency should be selected.";
                return false;
            }

            if (this.purchaseOrder.items.length == 0) {
                this.purchase_order_has_error = true;
                this.error_message = "Please add the items before save.";
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
        },
        handleCloseErrorMessage() {
            this.purchase_order_item_has_error = false;
            this.purchase_order_has_error = false;
        },

         */
        getMaterialNameById(material_id) {
            for (let material of this.materials) {
                if (material.id == material_id) {
                    return material.name;
                }
            }
            return null;
        },

        getColorNameById(color_id) {
            for (let color of this.colours) {
                if (color.id == color_id) {
                    return color.name;
                }
            }
            return null;
        },

    }
}
</script>

<style scoped>

</style>
