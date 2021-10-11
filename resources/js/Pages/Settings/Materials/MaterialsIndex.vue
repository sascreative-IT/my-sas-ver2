<template>
  <settings-layout>
    <div class="">
      <h3 class="text-lg">Materials</h3>

      <div class="flex flex-row-reverse">
        <inertia-link
            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150"
            href="/settings/material/create">
          Material Create
        </inertia-link>
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
              Unit
            </th>

            <th scope="col" class="relative px-6 py-3">
              <span class="sr-only">Edit</span>
            </th>
          </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
          <tr v-for="(material,index) in materials">
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="text-sm text-gray-900">{{ material.name }}</div>
            </td>

            <td class="px-6 py-4 whitespace-nowrap">
              <div class="text-sm text-gray-900">{{ material.type }}</div>
            </td>

            <td class="px-6 py-4 whitespace-nowrap">
              <div class="text-sm text-gray-900">{{ material.unit }}</div>
            </td>

            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
              <inertia-link
                  class="text-indigo-600 hover:text-indigo-900"
                  :href="'/settings/material/' + material.id +'/edit'"
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
      </div>
    </div>

    <delete-confirmation-modal
        title="Delete Outlet"
        :message='`Are you sure you want delete "${this.selectedOutlet.name}" outlet ?`'
        :delete-url="'/settings/outlets/' + this.selectedOutlet.id"
        :show="confirmingUserDeletion"
        @close="confirmingUserDeletion = false"
    ></delete-confirmation-modal>
  </settings-layout>
</template>

<script>
import SettingsLayout from "@/Pages/Settings/SettingsLayout";
import JetConfirmationModal from '@/Jetstream/ConfirmationModal'
import DeleteConfirmationModal from "@/Pages/Common/DeleteConfirmationModal";

export default {
  name: "MaterialsIndex",
  components: {DeleteConfirmationModal, SettingsLayout, JetConfirmationModal},
  props: {
    materials: {
      required: false,
      type: Array
    }
  },
  data() {
    return {
      selectedOutlet: {},
      confirmingUserDeletion: false
    }
  },
  methods: {
    deleteConfirmation(index) {
      this.selectedOutlet = this.outlets[index]
      this.confirmingUserDeletion = true;
    },
  }
}
</script>

<style scoped>

</style>
