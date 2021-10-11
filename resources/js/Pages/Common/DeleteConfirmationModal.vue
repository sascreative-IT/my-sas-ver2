<template>
  <jet-confirmation-modal :show="shouldShow" @close="shouldShow = false">
    <template #title>
      {{ title }}
    </template>

    <template #content>
      {{ message}}
    </template>

    <template #footer>
      <jet-secondary-button @click.native="closeModal()">
        Nevermind
      </jet-secondary-button>

      <jet-danger-button @click.native="makeDeleteRequest" class="ml-2" :class="{ 'opacity-25': deleting }" :disabled="deleting">
        {{ deleteButtonText }}
      </jet-danger-button>
    </template>
  </jet-confirmation-modal>
</template>

<script>
export default {
  name: "DeleteConfirmationModal",
  props: {
    title: {
      required: false,
      default: "Confirm",
      type: String
    },
    message: {
      required: false,
      default: "Are you sure you want to delete this ?",
      type: String
    },
    deleteButtonText: {
      required: false,
      default: "Delete",
      type: String
    },
    show: {
      required: true,
      type: Boolean
    },
    deleteUrl: {
      required: true,
      type: String
    }
  },
  data() {
    return {
      deleting: false,
      shouldShow: false
    }
  },
  mounted() {
    this.shouldShow = this.show
  },
  watch: {
    show: function (newValue, oldValue) {
      this.shouldShow = newValue;
    }
  },
  methods: {
    makeDeleteRequest() {
      this.deleting = true;
      this.$inertia.delete(this.deleteUrl, {
        preserveScroll: true,
        onSuccess:() => {
          this.closeModal()
        },
        onError: (error) => {
          console.error(error);
        },
        onFinish: () => {
          this.deleting = false
          this.closeModal()
        }
      })
    },
    closeModal() {
      this.shouldShow = false
      this.$emit('close', this.shouldShow)
    }
  }
}
</script>

<style scoped>

</style>
