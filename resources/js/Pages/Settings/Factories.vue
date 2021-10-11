<template>
  <settings-layout>
    <div class="">
      <h3 class="text-lg">Factories</h3>

      <div class="flex flex-row-reverse">
        <inertia-link
            class="bg-green-500 w-28 h-8 text-center pt-1.5 pl-3 pr-2 text-white rounded text-sm"
            href="/settings/factories/create"
        >
          Add Factory
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
              Country
            </th>
            <th scope="col" class="relative px-6 py-3">
              <span class="sr-only">Edit</span>
            </th>
          </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
          <tr v-for="factory in factories">
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="text-sm text-gray-900">{{ factory.name }}</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="text-sm text-gray-900"> {{factory.country.name}} </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
              <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit</a>
            </td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>
  </settings-layout>
</template>

<script>

import SettingsLayout from "@/Pages/Settings/SettingsLayout";
export default {
name: "Factories",
  components: {SettingsLayout},
  props: {
    factories: {
      required: false,
      type: Array
    }
  }
}
</script>

<style scoped>

</style>
