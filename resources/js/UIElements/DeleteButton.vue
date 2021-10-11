<template>
    <button :type="type" @click="$emit('handle-on-click',$event)"
            class="inline-flex items-center px-4 py-2 border-red-800 border hover:bg-red-700 hover:border-transparent hover:text-white rounded-md font-semibold text-xs text-red-800 uppercase tracking-widest active:bg-red-900 focus:outline-none focus:border-red-900 focus:shadow-outline-gray transition ease-in-out duration-150">
        <slot></slot>
    </button>
</template>

<script>
export default {
    name: "DeleteButton",
    props: {
        type: {
            type: String,
            default: 'submit',
        },
    }
}
</script>

<style scoped>

</style>
