<template>
  <form @submit.prevent="onSubmit">
    <div class="shadow overflow-hidden sm:rounded-md">
      <div class="px-4 py-5 bg-white sm:p-6">
        <div class="grid grid-cols-6 gap-6">
          <div class="col-span-6 sm:col-span-3">
            <label for="full_name" class="block text-sm font-medium text-gray-700">Outlet Name</label>
            <input v-model="outlet.name" type="text" name="full_name" id="full_name" autocomplete="given-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
          </div>

          <div class="col-span-6 sm:col-span-3">
            <label for="country" class="block text-sm font-medium text-gray-700">Country</label>
            <select v-model="outlet.country_id" id="country" name="country" autocomplete="country" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
              <option v-for="country in countries" :value="country.id"> {{ country.name }}</option>
            </select>
          </div>
        </div>
      </div>
      <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
        <inertia-link href="/settings/outlets" class="inline-flex justify-center text-sm font-medium rounded-md text-gray-900 mr-5">
          Cancel
        </inertia-link>

        <button
            type="submit"
            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
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
  name: "OutletForm",
  props: {
    initOutlet: {
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
      outlet: {}
    }
  },
  mounted() {
    this.outlet = this.initOutlet
  },
  methods: {
    onSubmit() {
      this.$emit('onSubmit', this.outlet)
    }
  }
}
</script>

<style scoped>

</style>
