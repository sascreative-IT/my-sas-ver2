<template>
    <div>
        <div class="p-5">
            <form>
                <div class="shadow overflow-hidden sm:rounded-md">
                    <div class="px-4 py-5 bg-white sm:p-6">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6 sm:col-span-3">
                                <label for="address_line_1" class="block text-sm font-medium text-gray-700">
                                    Address Line 1</label>
                                <input v-model="address.line_1" type="text" name="address_line_1" id="address_line_1"
                                       autocomplete="given-address"
                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="address_line_2" class="block text-sm font-medium text-gray-700">
                                    Address Line 2</label>
                                <input v-model="address.line_2" type="text" name="address_line_2" id="address_line_2"
                                       autocomplete="given-address"
                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="address_line_3" class="block text-sm font-medium text-gray-700">
                                    Address Line 3</label>
                                <input v-model="address.line_3" type="text" name="address_line_3" id="address_line_3"
                                       autocomplete="given-address"
                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="address_type" class="block text-sm font-medium text-gray-700">
                                    Address type</label>
                                <select id="address_type"
                                        v-model="address.type"
                                        name="address_type"
                                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="primary">Primary</option>
                                    <option value="billing">Billing</option>
                                    <option value="shipping">Shipping</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>

                            <div class="col-span-3">
                                <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                                <input v-model="address.city" type="text" name="city"
                                       id="city"
                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div class="col-span-3">
                                <label for="postal_code" class="block text-sm font-medium text-gray-700">Postal
                                    code</label>
                                <input v-model="address.postal_code" type="text" name="postal_code"
                                       id="postal_code"
                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div class="col-span-3">
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
                            Address type
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
                                {{ address.type }}
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
        <delete-confirmation-modal
            title="Delete Address"
            :message='`Are you sure you want delete this address ?`'
            :delete-url="'/customers/addresses/' + this.selectedAddress.id"
            :show="confirmingUserDeletion"
            @close="confirmingUserDeletion = false"
        ></delete-confirmation-modal>
    </div>

</template>

<script>
import FormButton from "@/UIElements/FormButton";
import EditButton from "@/UIElements/EditButton";
import DeleteButton from "@/UIElements/DeleteButton";
import DeleteConfirmationModal from "@/Pages/Common/DeleteConfirmationModal";
import JetConfirmationModal from "@/Jetstream/ConfirmationModal";

export default {
    name: "CustomerContactsForm",
    components: {
        DeleteConfirmationModal,
        JetConfirmationModal,
        FormButton,
        EditButton,
        DeleteButton
    },
    props: {
        initCustomer: {
            required: true,
            type: Object
        },
        countries: {
            required: true,
            type: Array
        }
    },
    watch: {
        initCustomer: function(newVal, oldVal) {
            this.populateAddresses(newVal);
        }
    },
    data() {
        return {
            customer: {},
            addresses: [],
            address: {
                city: '',
                country_id: null,
                line_1: '',
                line_2: '',
                line_3: '',
                postal_code: '',
                type: '',
                customer_id: null
            },
            selectedAddress:{},
            confirmingUserDeletion: false
        }
    },
    mounted() {
        this.populateAddresses(this.initCustomer);
    },
    methods: {
        populateAddresses(updatedProp) {
            const customer_id = updatedProp.id;
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
                    "type": val.type,
                    "customer_id": customer_id,
                });
            })
        },

        resetAddressForm() {
            this.address = {
                city: '',
                country_id: null,
                line_1: '',
                line_2: '',
                line_3: '',
                postal_code: '',
                type: '',
                customer_id: null
            }
        },

        saveAddress(e) {
            e.preventDefault();
            if (this.address.id === undefined) {
                this.address.customer_id = this.initCustomer.id;

                this.$inertia.post('/customers/addresses', this.address, {
                    preserveScroll: true,
                    onSuccess:(response) => {
                        console.log(response);
                    },
                    onError: (error) => {
                        console.error(error);
                    },
                });
            } else {
                this.address.customer_id = this.initCustomer.id;
                console.log(this.address);
                this.$inertia.put('/customers/addresses/'+this.address.id, this.address,{
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

        editAddress(index) {
            this.address = this.addresses[index];
        },

        deleteAddress(index) {
            this.selectedAddress = this.addresses[index]
            this.confirmingUserDeletion = true;
        }

    }

}
</script>

<style scoped>

</style>
