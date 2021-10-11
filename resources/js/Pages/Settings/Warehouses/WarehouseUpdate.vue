<template>
  <settings-layout>
    <warehouse-form
        :countries="countries"
        :init-warehouse="initWarehouse"
        :submit-button-disable="submitting"
        @onSubmit="onSubmit"
    ></warehouse-form>
  </settings-layout>
</template>

<script>
import WarehouseForm from "@/Pages/Settings/Warehouses/WarehouseForm";
import SettingsLayout from "@/Pages/Settings/SettingsLayout";
export default {
  name: "WarehouseUpdate",
  components: {WarehouseForm, SettingsLayout},
  props: {
    countries: {
      required: true,
      type: Array
    },
    initWarehouse: {
      required: true,
      type: Object
    }
  },
  data() {
    return {
      submitting: false,
    }
  },
  methods: {
    onSubmit(warehouse) {
      this.submitting = true
      this.$inertia.put('/settings/warehouses/' + this.initWarehouse.id, warehouse).then(function ({ data }) {
        this.submitting = false;
      }).catch(error => {
        this.submitted = false;
        console.log(error);
      })
    }
  }
}
</script>

<style scoped>

</style>
