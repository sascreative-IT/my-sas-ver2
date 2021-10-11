<template>
    <div class="w-full h-full">
        <el-table
          :data="items"
          stripe
          style="width: 100%"
          empty-text="No data to show"
        >
            <el-table-column
              v-for="header in headers"
              :key="header.key"
              :prop="header.key"
              :label="header.name"
              :width="header.width"
            >
            </el-table-column>
            <slot></slot>
        </el-table>
    </div>
</template>

<script>
export default {
    name: "AppTable",
    props: {
        items: {
            required: true,
            type: Array,
        },
        headers: {
            required: false,
            type: Array
        }
    },
    computed: {
        // preparedHeaders() {
        //     if (this.headers) {
        //         return this.headers.map((header) => {
        //             if (header.isString()) {
        //                 return {
        //                     prop: header,
        //                     name: header,
        //                     width: null
        //                 }
        //             }
        //         })
        //     }
        //
        //     return Object.keys(this.items)
        // }
    }
}
</script>

<style scoped>

</style>
