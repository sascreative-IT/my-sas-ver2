<template>
    <app-layout>
        <Notify :flash="$page.props.flash"></Notify>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Update Customer - {{ initCustomer.name }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mt-5 p-5">
                <el-tabs type="card">
                    <el-tab-pane label="General information">
                        <div class="bg-white overflow-hidden shadow-xl border">
                                <customer-update-form
                                    :init-customer="initCustomer"
                                    :cs-agents="csAgents"
                                    :sales-agents="salesAgents"
                                    @onSubmit="onSubmit"
                                >
                                </customer-update-form>
                        </div>
                    </el-tab-pane>
                    <el-tab-pane label="Contacts">
                        <div class="bg-white overflow-hidden shadow-xl rounded-md border">
                            <div class="bg-gray-500 pl-5 pt-2 pb-2 text-white">
                                <h4>Customer Contacts</h4>
                            </div>
                            <div class="p-5">
                                <form>
                                    <div class="shadow overflow-hidden sm:rounded-md">
                                        <div class="px-4 py-5 bg-white sm:p-6">
                                            <div class="grid grid-cols-6 gap-6">
                                                <div class="col-span-6 sm:col-span-3">
                                                    <label for="first_name" class="block text-sm font-medium text-gray-700">
                                                        First Name</label>
                                                    <input v-model="contact.first_name" type="text" name="first_name"
                                                           id="first_name"
                                                           autocomplete="given-name"
                                                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                </div>

                                                <div class="col-span-6 sm:col-span-3">
                                                    <label for="last_name" class="block text-sm font-medium text-gray-700">
                                                        Last Name</label>
                                                    <input v-model="contact.last_name" type="text" name="last_name"
                                                           id="last_name"
                                                           autocomplete="given-name"
                                                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                </div>

                                                <div class="col-span-6 sm:col-span-3">
                                                    <label for="designation" class="block text-sm font-medium text-gray-700">Designation</label>
                                                    <input v-model="contact.designation" type="text" name="designation"
                                                           id="designation"
                                                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                </div>

                                                <div class="col-span-3">
                                                    <label for="email_address" class="block text-sm font-medium text-gray-700">Email
                                                        address</label>
                                                    <input v-model="contact.email" type="email" name="email_address"
                                                           id="email_address" autocomplete="email"
                                                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                </div>

                                                <div class="col-span-3">
                                                    <label for="phone" class="block text-sm font-medium text-gray-700">Contact
                                                        Number</label>
                                                    <input v-model="contact.contact_no" type="text" name="phone" id="phone"
                                                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                </div>

                                                <div class="col-span-3">
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
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Actions
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
                                                    {{ contact.contact_no }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ contact.type }}
                                                </div>
                                            </td>
                                            <td>
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
                    </el-tab-pane>
                    <el-tab-pane label="Addresses">
                        <div class="bg-white overflow-hidden shadow-xl rounded-md border">
                            <div class="bg-gray-500 pl-5 pt-2 pb-2 text-white">
                                <h4>Customer Addresses</h4>
                            </div>
                            <customer-addresses-form
                                :init-customer="initCustomer"
                                :countries="countries"
                            ></customer-addresses-form>
                        </div>
                    </el-tab-pane>
                </el-tabs>
                </div>
            </div>
        </div>

        <delete-confirmation-modal
            title="Delete Contact"
            :message='`Are you sure you want delete "${this.selectedContact.first_name}" contact ?`'
            :delete-url="'/customers/contacts/' + this.selectedContact.id"
            :show="confirmingUserDeletion"
            @close="confirmingUserDeletion = false"
        ></delete-confirmation-modal>
    </app-layout>
</template>

<script>

import CustomerUpdateForm from "@/Pages/Customers/Forms/CustomerUpdateForm";
import CustomerAddressesForm from "@/Pages/Customers/Forms/CustomerAddressesForm";
import DeleteConfirmationModal from "@/Pages/Common/DeleteConfirmationModal";
import JetConfirmationModal from "@/Jetstream/ConfirmationModal";
import FormButton from '@/UIElements/FormButton';
import EditButton from "@/UIElements/EditButton";
import DeleteButton from "@/UIElements/DeleteButton";
import Notify from "@/UIElements/Notify";

export default {
    name: "CustomerUpdate",
    components: {
        CustomerUpdateForm,
        CustomerAddressesForm,
        DeleteConfirmationModal,
        JetConfirmationModal,
        FormButton,
        EditButton,
        DeleteButton,
        Notify
    },
    props: {
        initCustomer: {
            required: true,
            type: Object
        },
        csAgents: {
            required: true,
            type: Array
        },
        salesAgents: {
            required: true,
            type: Array
        },
        contacts: {
            required: true,
            type: Array
        },
        countries: {
            required: true,
            type: Array
        },
        flash: Object
    },
    data() {
        return {
            contact: {
                first_name: '',
                last_name: '',
                designation: '',
                email: '',
                contact_no: '',
                type: '',
                customer_id: this.initCustomer.id
            },
            selectedContact: {},
            confirmingUserDeletion: false
        }
    },
    methods: {
        onSubmit(customer) {
            this.$inertia.put('/customers/' + this.initCustomer.id, customer).then(function ({data}) {
                console.log(data);
            }).catch(error => {
                console.log(error);
            })
        },
        resetContact() {
            this.contact = {
                first_name: '',
                last_name: '',
                designation: '',
                email: '',
                contact_no: '',
                type: '',
                customer_id: this.initCustomer.id
            }
        },
        editContact(index) {
            this.contact = this.contacts[index];
        },
        saveContact(e) {
            e.preventDefault()
            if (this.contact.id === undefined) {
                this.$inertia.post('/customers/contacts', this.contact, {
                    preserveScroll: true,
                    onSuccess: (response) => {
                        console.log(response);
                    },
                    onError: (error) => {
                        console.error(error);
                    },
                });
            } else {
                this.$inertia.put('/customers/contacts/' + this.contact.id, this.contact).then(function ({data}) {
                    console.log(data);
                }).catch(error => {
                    console.log(error);
                })
            }
            this.resetContact()
        },
        deleteContact(index) {
            this.selectedContact = this.contacts[index]
            this.confirmingUserDeletion = true;
        }
    },
}
</script>

<style scoped>

</style>
