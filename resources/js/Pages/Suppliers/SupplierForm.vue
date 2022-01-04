<template>
    <div>
        <!--    add form -->
        <form @submit.prevent="handleAdd" v-if="showCreateForm">
            <div class="bg-white shadow overflow-hidden shadow-xl sm:rounded-lg">
                <div class="px-4 py-5 bg-white sm:p-6">
                    <div class="grid lg:grid-cols-2 md:grid-cols-2 sm:grid-cols-1 gap-x-8 gap-y-4">
                        <div>
                            <div class="pt-2 pb-4">
                                <label for="full_name" class="block text-base font-medium text-gray-700">Full
                                    name</label>
                                <input v-model="supplier.name" type="text" name="full_name" id="full_name"
                                       autocomplete="given-name"
                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>
                            <div class="pt-2 pb-4">
                                <label for="email_address" class="block text-base font-medium text-gray-700">Email
                                    address</label>
                                <input v-model="supplier.email" type="email" name="email_address"
                                       id="email_address" autocomplete="email"
                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>
                            <div class="pt-2 pb-4">
                                <label for="email_address" class="block text-base font-medium text-gray-700">Currency</label>
                                <input type="text" name="currency"
                                       disabled
                                       placeholder="NZD"
                                       id="currency" autocomplete="currency"
                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>
                        </div>
                        <div>
                            <div class="pt-2 pb-4">
                                <label for="description"
                                       class="block text-base font-medium text-gray-700">Details</label>
                                <textarea v-model="supplier.description" type="text" name="description"
                                          id="description"
                                          class="mt-1 resize-none focus:ring-indigo-500 focus:border-indigo-500 block w-full h-28 shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            </textarea>
                            </div>
                            <div class="col-span-1 mt-4 float-right">
                                <div>
                                    <form-button>
                                        Save & Go To Next
                                    </form-button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!--    edit form -->
        <div v-else-if="showEditForm">
            <div class="mt-5 bg-white overflow-hidden shadow-xl rounded-md">
                <div class="p-5">
                    <form @submit.prevent="handleUpdate">
                        <div class="overflow-hidden sm:rounded-md">
                            <div class="bg-white px-4 py-5 sm:p-6">
                                <div class="grid lg:grid-cols-2 md:grid-cols-2 sm:grid-cols-1 gap-x-8 gap-y-4">
                                    <div>
                                        <div class="pt-2 pb-4">
                                            <label for="full_name" class="block text-base font-medium text-gray-700">Full
                                                name</label>
                                            <input v-model="supplier.name" type="text" name="full_name" id="full_name"
                                                   autocomplete="given-name"
                                                   class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        </div>
                                        <div class="pt-2 pb-4">
                                            <label for="email_address"
                                                   class="block text-base font-medium text-gray-700">Email
                                                address</label>
                                            <input v-model="supplier.email" type="email" name="email_address"
                                                   id="email_address" autocomplete="email"
                                                   class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        </div>
                                        <div class="pt-2 pb-4">
                                            <label for="email_address" class="block text-base font-medium text-gray-700">Currency</label>
                                            <input type="text" name="currency"
                                                   disabled
                                                   placeholder="NZD"
                                                   id="currency" autocomplete="currency"
                                                   class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        </div>
                                    </div>
                                    <div>
                                        <div class="pt-2 pb-4">
                                            <label for="description"
                                                   class="block text-base font-medium text-gray-700">Details</label>
                                            <textarea v-model="supplier.description" type="text" name="description"
                                                      id="description"
                                                      class="mt-1 resize-none focus:ring-indigo-500 focus:border-indigo-500 block w-full h-28 shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            </textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                <form-button>
                                    Save
                                </form-button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="mt-5 bg-white overflow-hidden shadow-xl rounded-md">
                <div class="bg-gray-500 pl-5 pt-2 pb-2 text-white">
                    <h4>Supplier Materials</h4>
                </div>

                <div class="p-5">
                    <form>

                        <div class="shadow overflow-hidden sm:rounded-md">
                            <div class="px-4 py-5 bg-white sm:p-6">
                                <div class="grid grid-cols-2 gap-6">
                                    <div class="sm:col-span-1">
                                        <label for="supplier_material" class="block text-sm font-medium text-gray-700">
                                            Material
                                        </label>
                                        <app-select
                                            placeholder="Select Material"
                                            option-label="name"
                                            option-value="id"
                                            :filterable="true"
                                            :options="materials"
                                            v-model="materialSupplier.material"
                                            @input="setSelectedMaterial"
                                        ></app-select>
                                    </div>
                                    <div class="sm:col-span-1">
                                        <label for="supplier_color" class="block text-sm font-medium text-gray-700">
                                            Color
                                        </label>
                                        <app-select
                                            placeholder="Select Color"
                                            option-label="name"
                                            option-value="id"
                                            :filterable="true"
                                            :options="colours"
                                            v-model="materialSupplier.color"
                                            @input="setSelectedColor"
                                        ></app-select>
                                    </div>
                                </div>
                            </div>
                            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                <form-button @handle-on-click="saveMaterialSupplier">
                                    Save
                                </form-button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="p-5">
                    <div class="shadow overflow-hidden sm:rounded-md">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-8 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Material
                                </th>
                                <th scope="col"
                                    class="px-8 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Color
                                </th>
                                <th scope="col" class="relative px-2 py-3 w-16">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="(materialSupplier, index) in materialSuppliers">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{materialSupplier.variation.material.name}}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{materialSupplier.variation.colour.name}}
                                    </div>
                                </td>

                                <td class="px-2 py-4 whitespace-nowrap">
                                    <edit-button @handle-on-click="editMaterialSupplier(index)">
                                        Edit
                                    </edit-button>

                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="mt-5 bg-white overflow-hidden shadow-xl rounded-md">
                <div class="bg-gray-500 pl-5 pt-2 pb-2 text-white">
                    <h4>Supplier Contacts</h4>
                </div>
                <div class="p-5">
                    <form>
                        <div class="shadow overflow-hidden sm:rounded-md">
                            <div class="px-4 py-5 bg-white sm:p-6">
                                <div class="grid grid-cols-2 gap-6">
                                    <div class="sm:col-span-1">
                                        <label for="first_name" class="block text-sm font-medium text-gray-700">
                                            First Name</label>
                                        <input v-model="contact.first_name" type="text" name="first_name"
                                               id="first_name"
                                               autocomplete="given-name"
                                               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    <div class="sm:col-span-1">
                                        <label for="last_name" class="block text-sm font-medium text-gray-700">
                                            Last Name</label>
                                        <input v-model="contact.last_name" type="text" name="last_name"
                                               id="last_name"
                                               autocomplete="given-name"
                                               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    <div class="sm:col-span-1">
                                        <label for="designation" class="block text-sm font-medium text-gray-700">Designation</label>
                                        <input v-model="contact.designation" type="text" name="designation"
                                               id="designation"
                                               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    <div class="sm:col-span-1">
                                        <label for="email_address" class="block text-sm font-medium text-gray-700">Email
                                            address</label>
                                        <input v-model="contact.email" type="email" name="email_address"
                                               id="email_address" autocomplete="email"
                                               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    <div class="sm:col-span-1">
                                        <label for="phone" class="block text-sm font-medium text-gray-700">Contact
                                            Number</label>
                                        <input v-model="contact.contact_number" type="text" name="phone" id="phone"
                                               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    <div class="sm:col-span-1">
                                        <label for="type" class="block text-sm font-medium text-gray-700">Contact
                                            type:</label>
                                        <select v-model="contact.type" id="type"
                                                name="type"
                                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                            <option value="Primary">Primary</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                <form-button @handle-on-click="saveContact">
                                    Save
                                </form-button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="p-5">
                    <div class="shadow overflow-hidden sm:rounded-md">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    First Name
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Last Name
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Designation
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Email Address
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Contact Number
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Contact Type
                                </th>
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="(contact, index) in contacts">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ contact.first_name }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ contact.last_name }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ contact.designation }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ contact.email }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ contact.contact_number }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ contact.type }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <edit-button @handle-on-click="editContact(index)">
                                        Edit
                                    </edit-button>
                                    <delete-button @handle-on-click="deleteContact(index)">
                                        Delete
                                    </delete-button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="mt-5 bg-white overflow-hidden shadow-xl rounded-md">
                <div class="bg-gray-500 pl-5 pt-2 pb-2 text-white">
                    <h4>Supplier Addresses</h4>
                </div>
                <div class="p-5">
                    <form>
                        <div class="shadow overflow-hidden sm:rounded-md">
                            <div class="px-4 py-5 bg-white sm:p-6">
                                <div class="grid grid-cols-2 gap-6">
                                    <div class="sm:col-span-1">
                                        <label for="address_line_1" class="block text-sm font-medium text-gray-700">
                                            Address Line 1</label>
                                        <input v-model="address.line_1" type="text" name="address_line_1" id="address_line_1"
                                               autocomplete="given-address"
                                               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>

                                    <div class="sm:col-span-1">
                                        <label for="address_line_2" class="block text-sm font-medium text-gray-700">
                                            Address Line 2</label>
                                        <input v-model="address.line_2" type="text" name="address_line_2" id="address_line_2"
                                               autocomplete="given-address"
                                               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>

                                    <div class="sm:col-span-1">
                                        <label for="address_line_3" class="block text-sm font-medium text-gray-700">
                                            Address Line 3</label>
                                        <input v-model="address.line_3" type="text" name="address_line_3" id="address_line_3"
                                               autocomplete="given-address"
                                               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>

                                    <div class="sm:col-span-1">
                                        <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                                        <input v-model="address.city" type="text" name="city"
                                               id="city"
                                               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>

                                    <div class="sm:col-span-1">
                                        <label for="postal_code" class="block text-sm font-medium text-gray-700">Postal
                                            code</label>
                                        <input v-model="address.postal_code" type="text" name="postal_code"
                                               id="postal_code"
                                               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>

                                    <div class="sm:col-span-1">
                                        <label for="country" class="block text-sm font-medium text-gray-700">Country</label>
                                        <select id="country"
                                                name="country"
                                                v-model="address.country_id"
                                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                            <option v-for="country in countries" :value="country.id"> {{
                                                    country.name
                                                }}
                                            </option>
                                        </select>
                                    </div>

                                </div>
                            </div>
                            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                <form-button @handle-on-click="saveAddress">
                                    save
                                </form-button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="p-5">
                    <div class="shadow overflow-hidden sm:rounded-md">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Address Line 1
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Address Line 2
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Address Line 3
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    City
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Postal code
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Country
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                            </thead>

                            <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="(address, index) in addresses">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ address.line_1 }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ address.line_2 }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ address.line_3 }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ address.city }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ address.postal_code }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ address.country_name }}
                                    </div>
                                </td>
                                <td>
                                    <edit-button @handle-on-click="editAddress(index)">
                                        Edit
                                    </edit-button>
                                    <delete-button @handle-on-click="deleteAddress(index)">
                                        Delete
                                    </delete-button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
        <div v-else>
            <div class="shadow overflow-hidden sm:rounded-md">
                <div class="px-4 py-5 bg-white sm:p-6">
                    <div class="grid lg:grid-cols-2 md:grid-cols-2 sm:grid-cols-1 gap-x-8 gap-y-4">
                        <div>
                            <div class="pt-2 pb-4">
                                <h3>Could not find this record.</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <delete-confirmation-modal
            title="Delete Contact"
            :message='`Are you sure you want delete "${this.selectedContact.first_name}" contact ?`'
            :delete-url="'/suppliers/contacts/' + this.selectedContact.id"
            :show="confirmingUserDeletion"
            @close="confirmingUserDeletion = false"
        ></delete-confirmation-modal>
        <delete-confirmation-modal
            title="Delete Address"
            :message='`Are you sure you want delete this address ?`'
            :delete-url="'/suppliers/addresses/' + this.selectedAddress.id"
            :show="confirmingUserDeletion"
            @close="confirmingUserDeletion = false"
        ></delete-confirmation-modal>
    </div>

</template>

<script>
import FormButton from "@/UIElements/FormButton";
import DeleteButton from "@/UIElements/DeleteButton";
import DeleteConfirmationModal from "@/Pages/Common/DeleteConfirmationModal";
import EditButton from "@/UIElements/EditButton";
import AppSelect from "@/UIElements/AppSelect";

export default {
    name: "SupplierForm",
    components: {
        FormButton,
        EditButton,
        DeleteButton,
        AppSelect,
        DeleteConfirmationModal
    },
    props: {
        crudAction: {
            required: true,
            type: String
        },
        initSupplier: {
            required: false,
            type: Object
        },
        contacts: {
            required: false,
            type: Array
        },
        countries: {
            required: false,
            type: Array
        },
        colours: {
            required: false,
            type: Array
        },
        materials: {
            required: false,
            type: Array
        },
        materialSuppliers: {
            required: false,
            type: Array
        },
    },
    methods: {
        showFormsLogic(action) {
            if (action === 'edit' && (this.initSupplier === null || this.contacts === null)) {
                console.log('error');
            }
            switch (action) {
                case 'create':
                    this.showEditForm = false;
                    this.showCreateForm = true;
                    break;
                case 'edit':
                    this.showEditForm = true;
                    this.showCreateForm = false;
                    break;
                default:
                    this.showEditForm = false;
                    this.showCreateForm = false;
            }
        },
        stateLogic(action) {
            if (action === 'edit' && this.initSupplier != null && this.contacts != null) {
                const editableSupplier = {
                    name: this.initSupplier.name,
                    email: this.initSupplier.email,
                    description: this.initSupplier.description,
                }
                const editableContact = {
                    first_name: '',
                    last_name: '',
                    designation: '',
                    email: '',
                    contact_number: '',
                    type: '',
                    supplier_id: this.initSupplier.id
                }
                const editableAddress = {
                    city: '',
                    country_id: null,
                    line_1: '',
                    line_2: '',
                    line_3: '',
                    postal_code: '',
                    supplier_id: null
                }
                this.supplier = editableSupplier;
                this.contact = editableContact;
                this.address = editableAddress;
            } else if (action === 'create') {
                this.supplier = {};
                this.contact = {};
                this.address = {};
            } else {
                console.log('error');
                this.showEditForm = false;
                this.showCreateForm = false;
            }
        },
        resetContact() {
            this.contact = {
                first_name: '',
                last_name: '',
                designation: '',
                email: '',
                contact_number: '',
                type: '',
                supplier_id: this.initSupplier.id
            }
        },
        resetAddressForm() {
            this.address = {
                city: '',
                country_id: null,
                line_1: '',
                line_2: '',
                line_3: '',
                postal_code: '',
                supplier_id: null
            }
        },
        handleAdd() {
            this.$emit('onCreate', this.supplier);
        },
        handleUpdate() {
            this.$emit('onUpdate', this.supplier);
        },
        saveContact(e) {
            e.preventDefault();
            if (this.contact.id === undefined) {
                this.$inertia.post('/suppliers/contacts', this.contact, {
                    preserveScroll: true,
                    onSuccess: (response) => {
                        console.log(response);
                    },
                    onError: (error) => {
                        console.error(error);
                    },
                });
            } else {
                this.$inertia.put('/suppliers/contacts/' + this.contact.id, this.contact).then(function ({data}) {
                    console.log(data);
                }).catch(error => {
                    console.log(error);
                })
            }
            this.resetContact();
        },
        saveAddress(e) {
            e.preventDefault();
            if (this.address.id === undefined) {
                this.address.supplier_id = this.initSupplier.id;

                this.$inertia.post('/suppliers/addresses', this.address, {
                    preserveScroll: true,
                    onSuccess:(response) => {
                        console.log(response);
                    },
                    onError: (error) => {
                        console.error(error);
                    },
                });
            } else {
                this.address.supplier_id = this.initSupplier.id;
                console.log(this.address);
                this.$inertia.put('/suppliers/addresses/'+this.address.id, this.address,{
                    preserveScroll: true,
                    onSuccess:(response) => {
                        console.log(response);
                    },
                    onError: (error) => {
                        console.error(error);
                    },
                })
            }
            this.resetAddressForm();
        },
        saveMaterialSupplier(e) {
            e.preventDefault();
            this.materialSupplier.supplier_id = this.initSupplier.id;
            if (this.materialSupplier.id === undefined) {
                this.$inertia.post('/suppliers/material-supplier', this.materialSupplier, {
                    preserveScroll: true,
                    onSuccess:(response) => {
                        console.log(response);
                    },
                    onError: (error) => {
                        console.error(error);
                    },
                });
            } else {
                this.$inertia.put('/suppliers/material-supplier/'+this.materialSupplier.id, this.materialSupplier, {
                    preserveScroll: true,
                    onSuccess:(response) => {
                        console.log(response);
                    },
                    onError: (error) => {
                        console.error(error);
                    },
                });
            }

            this.resetMaterialSupplierForm();
        },
        editContact(index) {
            this.contact = this.contacts[index];
        },
        editAddress(index) {
            this.address = this.addresses[index];
        },
        deleteContact(index) {
            this.selectedContact = this.contacts[index]
            this.confirmingUserDeletion = true;
        },
        deleteAddress(index) {
            this.selectedAddress = this.addresses[index]
            this.confirmingUserDeletion = true;
        },
        populateAddresses(updatedProp) {
            const supplier_id = updatedProp.id;
            this.addresses = [];
            updatedProp.addresses.forEach((val, index) => {
                this.addresses.push({
                    "id": val.address.id,
                    "city": val.address.city,
                    "country_id": val.address.country_id,
                    "country_name": val.address.country.name,
                    "line_1": val.address.line_1,
                    "line_2": val.address.line_2,
                    "line_3": val.address.line_3,
                    "postal_code": val.address.postal_code,
                    "supplier_id": supplier_id,
                });
            })
        },
        setSelectedMaterial(value) {
            this.materialSupplier.material = value;
        },

        setSelectedColor(value) {
            this.materialSupplier.color = value;
        },
        resetMaterialSupplierForm() {
            this.materialSupplier = {
                id: '',
                material: '',
                color: ''
            }
        },
        editMaterialSupplier(index) {
            const materialSupplier = this.materialSuppliers[index];
            this.materialSupplier = this.materialSuppliers[index];
            this.materialSupplier = {
                id: materialSupplier.id,
                variation: materialSupplier.variation.id,
                material: materialSupplier.variation.material,
                color: materialSupplier.variation.colour
            }
        },
    },
    mounted() {
        this.showFormsLogic(this.crudAction);
        this.stateLogic(this.crudAction);
        this.populateAddresses(this.initSupplier);
    },
    watch: {
        initSupplier: function(newVal, oldVal) {
            this.populateAddresses(newVal);
        }
    },
    data() {
        return {
            showEditForm: false,
            showCreateForm: false,
            supplier: {
                name: '',
                email: '',
                description: ''
            },
            contact: {},
            addresses: [],
            address: {},
            selectedContact: {},
            selectedAddress:{},
            confirmingUserDeletion: false,
            materialSupplier: {},
        }
    }

}
</script>

<style scoped>

</style>
