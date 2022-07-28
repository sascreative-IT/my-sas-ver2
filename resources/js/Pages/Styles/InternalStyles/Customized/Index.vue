<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Internal(SAS) Styles - Customized
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex flex-row-reverse">
                    <inertia-link
                        class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150"
                        href="/customized-styles/create">Add New Style
                    </inertia-link>
                </div>

                <div class="">
                    <div class="relative text-gray-600 focus-within:text-gray-400">
            <span class="absolute inset-y-0 left-0 flex items-center pl-2">
              <button type="submit" class="p-1 focus:outline-none focus:shadow-outline">
                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-6 h-6"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
              </button>
            </span>
                        <input type="search" v-model="query" class="py-2 text-sm text-white rounded-md pl-10 focus:outline-none focus:bg-white focus:text-gray-900" placeholder="Search..." autocomplete="off" @input="searchStyles">
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mt-5">
                    <app-table
                        :items="internalStyles.data"
                        :headers="[
                        {key: 'code', name: 'Code', width: '200px'},
                        {key: 'name', name: 'Name'},
                        {key: 'styles_type', name: 'Style Type'},
                        {key: 'item_type.name', name: 'Item Type'},
                      ]"
                    >
                        <el-table-column
                            fixed="right"
                            label="Operations"
                            width="120">
                            <template #default="scope">
                                <inertia-link
                                    class="inline-flex items-center px-4 py-1 border-gray-600 border hover:bg-gray-700 hover:border-transparent hover:text-white rounded-sm font-semibold text-xs text-black uppercase tracking-widest active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150"
                                    :href="`/customized-styles/edit/${scope.row.id}`"
                                >
                                    Edit
                                </inertia-link>
                            </template>
                        </el-table-column>
                    </app-table>

                    <paginator
                        :pagination="internalStyles"
                    ></paginator>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppSelect from "@/UIElements/AppSelect";
import AppTable from "@/UIElements/AppTable";
import Paginator from "@/UIElements/Paginator";
export default {
    name: "Index",
    components: {AppTable, AppSelect, Paginator},
    props: {
        internalStyles: {
            required: true,
            type: Array
        }
    },
    methods: {
        searchStyles() {
            this.$inertia.visit(this.$inertia.page.url, {
                preserveState: true,
                preserveScroll: true,
                data: {
                    q: this.query,
                    page: 1
                }
            })
        }
    }
}
</script>

<style scoped>

</style>
