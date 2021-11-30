<template>
    <settings-layout>
        <div class="">
            <h3 class="text-lg">Colours</h3>

            <div class="flex flex-row-reverse">
                <inertia-link
                    class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150"
                    href="/settings/colours/create"
                >
                    Add Colours
                </inertia-link>
            </div>

            <div class="flex flex-row-reverse mt-2">
                <div class="relative text-gray-600 focus-within:text-gray-400">
      <span class="absolute inset-y-0 left-0 flex items-center pl-2">
        <button type="submit" class="p-1 focus:outline-none focus:shadow-outline">
          <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-6 h-6"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </button>
      </span>
                    <input type="search" v-model="query" class="py-2 text-sm text-white rounded-md pl-10 focus:outline-none focus:bg-white focus:text-gray-900" placeholder="Search..." autocomplete="off" @input="searchColors">
                </div>
            </div>

            <div class="mt-5">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Name
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Type
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Active
                        </th>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Edit</span>
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="(colour,index) in colours.data">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ colour.name }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ colour.type.name }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ parseBoolean(colour.is_active) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <inertia-link
                                class="text-indigo-600 hover:text-indigo-900"
                                :href="'/settings/colours/' + colour.id +'/edit'"
                            >
                                Edit
                            </inertia-link>

                            <button class="ml-2 text-red-600" @click="deleteConfirmation(index)">
                                Delete
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <paginator
                    :pagination="colours"
                ></paginator>
            </div>
        </div>

        <delete-confirmation-modal
            title="Delete Colour"
            :message='`Are you sure you want delete "${this.selectedColour.name}" colour ?`'
            :delete-url="'/settings/colours/' + this.selectedColour.id"
            :show="confirmingUserDeletion"
            @close="confirmingUserDeletion = false"
        ></delete-confirmation-modal>
    </settings-layout>
</template>

<script>
import SettingsLayout from "@/Pages/Settings/SettingsLayout";
import JetConfirmationModal from '@/Jetstream/ConfirmationModal'
import DeleteConfirmationModal from "@/Pages/Common/DeleteConfirmationModal";
import Paginator from "@/UIElements/Paginator";

export default {
    name: "ColoursIndex",
    components: {
        DeleteConfirmationModal,
        SettingsLayout,
        JetConfirmationModal,
        Paginator
    },
    props: {
        colours: {
            required: false,
            type: Array
        },
        q: {
            required: false,
            type: String
        }
    },
    data() {
        return {
            selectedColour: {},
            confirmingUserDeletion: false,
            query: ''
        }
    },
    methods: {
        parseBoolean(value) {
            let parsedValue;
            (value == true) ? parsedValue = 'Yes' : parsedValue = 'No';
            return parsedValue;
        },
        deleteConfirmation(index) {
            this.selectedColour = this.colours[index]
            this.confirmingUserDeletion = true;
        },
        searchColors() {
            this.$inertia.visit(this.$inertia.page.url, {
                preserveState: true,
                preserveScroll: true,
                data: {
                    q: this.query
                }
            })
        }
    }
}
</script>

<style scoped>

</style>
