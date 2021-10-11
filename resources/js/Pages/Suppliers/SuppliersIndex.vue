<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Suppliers
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex flex-row-reverse">
                    <inertia-link
                        class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150"
                        href="/suppliers/create">Add New Supplier
                    </inertia-link>
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mt-5">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Name
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    email
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    currency
                                </th>
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">Edit</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="(supplier,index) in suppliers.data">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ supplier.name }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ supplier.email }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ supplier.currency.toUpperCase() }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <inertia-link
                                    class="inline-flex items-center px-4 py-2 border-gray-800 border hover:bg-gray-700 hover:border-transparent hover:text-white rounded-md font-semibold text-xs text-black uppercase tracking-widest active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150"
                                    :href="'/suppliers/' + supplier.id +'/edit'"
                                >
                                    Edit
                                </inertia-link>
                                <delete-button @handle-on-click="deleteContact(supplier)">
                                    Delete
                                </delete-button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <paginator
                        :pagination="suppliers"
                    ></paginator>
                </div>
            </div>
        </div>
        <delete-confirmation-modal
            title="Delete Contact"
            :message='`Are you sure you want delete "${this.selectedSupplier.first_name}" contact ?`'
            :delete-url="'/suppliers/' + this.selectedSupplier.id"
            :show="confirmingUserDeletion"
            @close="confirmingUserDeletion = false"
        ></delete-confirmation-modal>

    </app-layout>
</template>

<script>
import Notify from "@/UIElements/Notify";
import EditButton from "@/UIElements/EditButton";
import DeleteButton from "@/UIElements/DeleteButton";
import DeleteConfirmationModal from "@/Pages/Common/DeleteConfirmationModal";
import Paginator from "@/UIElements/Paginator";

export default {
    name: "SupplierIndex",
    components: {
        EditButton,
        DeleteButton,
        DeleteConfirmationModal,
        Paginator
    },
    props: {
        suppliers: {
            required: false,
            type: Object
        }
    },
    data() {
        return {
            confirmingUserDeletion:false,
            selectedSupplier:{}
        }
    },
    methods: {
        deleteContact(supplier) {
            this.selectedSupplier = supplier;
            this.confirmingUserDeletion = true;
        }
    }
}
</script>

<style scoped>

</style>
