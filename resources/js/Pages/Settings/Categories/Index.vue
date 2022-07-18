<template>
    <settings-layout>
        <div class="flex justify-between">
            <h3 class="text-lg">Categories</h3>

            <div class="flex flex-row-reverse">
                <inertia-link
                    class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150"
                    href="/settings/categories/create">Add Categories</inertia-link>
            </div>
        </div>
        <div class="mt-5">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Name
                    </th>
                    <th scope="col" class="relative px-6 py-3">
                        <span class="sr-only">Edit</span>
                    </th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="(category,index) in categories.data">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ category.name }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button
                                class="inline-flex items-center px-4 py-1 border-red-600 border hover:bg-red-700 hover:border-transparent hover:text-white rounded-sm font-semibold text-xs text-red-700 uppercase tracking-widest active:bg-red-900 focus:outline-none focus:border-red-900 focus:shadow-outline-red transition ease-in-out duration-150"
                                @click="deleteConfirmation(index)"
                            >
                                Delete
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <paginator
                :pagination="categories"
            ></paginator>
        </div>
        <delete-confirmation-modal
            title="Delete Size"
            :message='`Are you sure you want delete "${this.selectedCategory.name}" category ?`'
            :delete-url="'/settings/categories/' + this.selectedCategory.id"
            :show="confirmingUserDeletion"
            @close="confirmingUserDeletion = false"
        ></delete-confirmation-modal>
    </settings-layout>
</template>

<script>
import DeleteConfirmationModal from "@/Pages/Common/DeleteConfirmationModal";
import SettingsLayout from "@/Pages/Settings/SettingsLayout";
import JetConfirmationModal from "@/Jetstream/ConfirmationModal";
import Paginator from "@/UIElements/Paginator";

export default {
    name: "Index",
    components: {
        DeleteConfirmationModal,
        SettingsLayout,
        JetConfirmationModal,
        Paginator
    },
    props: {
        categories: {
            required: false,
            type: Object
        }
    },
    data() {
        return {
            selectedCategory: {},
            confirmingUserDeletion: false
        }
    },
    methods: {
        deleteConfirmation(index) {
            this.selectedCategory = this.categories.data[index]
            this.confirmingUserDeletion = true;
        },
    }
}
</script>

<style scoped>

</style>
