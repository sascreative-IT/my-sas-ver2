<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Internal(SAS) Styles
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex flex-row-reverse">
                    <inertia-link
                      class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150"
                      href="/internal-styles/create">Add New Style
                    </inertia-link>
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mt-5">
                    <app-table
                      :items="internalStyles"
                      :headers="[
                        {key: 'code', name: 'Code', width: '200px'},
                        {key: 'name', name: 'Name'},
                        {key: 'type.name', name: 'Type'},
                      ]"
                    >
                        <el-table-column
                          fixed="right"
                          label="Operations"
                          width="120">
                            <template #default="scope">
                                <inertia-link
                                  class="inline-flex items-center px-4 py-1 border-gray-600 border hover:bg-gray-700 hover:border-transparent hover:text-white rounded-sm font-semibold text-xs text-black uppercase tracking-widest active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150"
                                  :href="`/internal-styles/edit/${scope.row.id}`"
                                >
                                    Edit
                                </inertia-link>
                            </template>
                        </el-table-column>
                    </app-table>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppSelect from "@/UIElements/AppSelect";
import AppTable from "@/UIElements/AppTable";
export default {
    name: "Index",
    components: {AppTable, AppSelect},
    props: {
        internalStyles: {
            required: true,
            type: Array
        }
    }
}
</script>

<style scoped>

</style>
