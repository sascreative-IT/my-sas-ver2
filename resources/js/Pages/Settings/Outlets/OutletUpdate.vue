<template>
  <settings-layout>
    <outlet-form
        :countries="countries"
        :init-outlet="initOutlet"
        :submit-button-disable="submitting"
        @onSubmit="onSubmit"
    ></outlet-form>
  </settings-layout>
</template>

<script>
import OutletForm from "@/Pages/Settings/Outlets/OutletForm";
import SettingsLayout from "@/Pages/Settings/SettingsLayout";
export default {
  name: "OutletUpdate",
  components: {OutletForm, SettingsLayout},
  props: {
    countries: {
      required: true,
      type: Array
    },
    initOutlet: {
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
    onSubmit(outlet) {
      this.submitting = true
      this.$inertia.put('/settings/outlets/' + this.initOutlet.id, outlet).then(function ({ data }) {
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
