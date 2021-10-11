<template>
    <button :type="type" @click="$emit('handle-on-click',$event)"
            class="inline-flex items-center px-4 py-2 border-gray-800 border hover:bg-gray-700 hover:border-transparent hover:text-white rounded-md font-semibold text-xs text-black uppercase tracking-widest active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150">
        <slot></slot>
    </button>
</template>

<script>
export default {
    name: "EditButton",
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
