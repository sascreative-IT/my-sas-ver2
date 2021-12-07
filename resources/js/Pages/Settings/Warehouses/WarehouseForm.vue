<template>
  <form @submit.prevent="onSubmit">
    <div class="shadow overflow-hidden sm:rounded-md">
      <div class="px-4 py-5 bg-white sm:p-6">
        <div class="grid grid-cols-6 gap-6">
          <div class="col-span-6 sm:col-span-3">
            <label for="full_name" class="block text-sm font-medium text-gray-700">Warehouse Name</label>
            <input v-model="warehouse.name" type="text" name="full_name" id="full_name" autocomplete="given-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
          </div>

          <div class="col-span-6 sm:col-span-3">
            <label for="country" class="block text-sm font-medium text-gray-700">Country</label>
            <select v-model="warehouse.country_id" id="country" name="country" autocomplete="country" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
              <option v-for="country in countries" :value="country.id"> {{ country.name }}</option>
            </select>
          </div>
        </div>
      </div>
      <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
        <inertia-link href="/settings/warehouses" class="inline-flex justify-center text-sm font-medium rounded-md text-gray-900 mr-5">
          Cancel
        </inertia-link>

        <button
            type="submit"
            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150"
            :class="{'opacity-50': submitButtonDisable}"
        >
          {{buttonText}}
        </button>
      </div>
    </div>
  </form>
</template>

<script>
export default {
  name: "WarehouseForm",
  props: {
    initWarehouse: {
      required: true,
      type: Object
    },
    countries: {
      required: true,
      type: Array
    },
    submitButtonDisable: {
      required: false,
      default: false,
      type: Boolean
    },
    buttonText: {
      required: false,
      default: 'Save',
      type: String
    }
  },
  data() {
    return {
      warehouse: {}
    }
  },
  mounted() {
    this.warehouse = this.initWarehouse
  },
  methods: {
    onSubmit() {
      this.$emit('onSubmit', this.warehouse)
    }
  }
}
</script>

<style scoped>

</style>
