<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <template>
                    View Style
                </template>
            </h2>
        </template>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl rounded-md border mt-5">
                <div class="bg-gray-500 pl-5 pt-2 pb-2 text-white">
                    <h4>Style information</h4>
                </div>
                <div class="p-5">
                    <el-divider content-position="left"><h3 class="text-lg font-bold">General</h3></el-divider>
                    <div class="py-4">
                        <form>
                            <div class="shadow overflow-hidden sm:rounded-md">
                                <div class="px-4 py-5 bg-white sm:p-6">

                                    <div class="grid lg:grid-cols-3 md:grid-cols-3 sm:grid-cols-1 gap-4">
                                        <div class="col-span-1 sm:col-span-1">
                                            <label for="style_code_general_style"
                                                   class="block text-sm font-medium text-gray-700">
                                                Style code</label>
                                            <p class="mt-1 block w-full shadow-sm text-sm lg:text-base border-gray-300 rounded-md">{{form.code}}</p>
                                        </div>


                                        <div class="col-span-1 sm:col-span-1">
                                            <label for="style_name_general_style"
                                                   class="block text-sm font-medium text-gray-700">
                                                Style name</label>
                                            <p class="mt-1 block w-full shadow-sm text-sm lg:text-base border-gray-300 rounded-md">{{form.name}}</p>
                                        </div>

                                        <div class="col-span-1 sm:col-span-1">
                                            <label class="block text-sm font-medium text-gray-700">
                                                Category
                                            </label>
                                            <div class="flex flex-row">
                                                <div v-for="category in form.categories" class="mt-1 pr-1">
                                                    <div class="border border-gray-400 h-8 w-24 mb-4 md:mb-0 rounded-md inline-flex items-center justify-center">
                                                        <div tabindex="0" aria-label="gray border badge" class="focus:outline-none flex items-center">
                                                            <span class="text-sm text-gray-700 dark:text-gray-100 font-normal">{{category.name}}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="mt-5" v-if="form.styles_type == 'Customized'">
                                        <div class="col-span-1 sm:col-span-1">
                                            <label for="style_code_general_style"
                                                   class="block text-sm font-medium text-gray-700">
                                                Parent Style code</label>
                                            <p class="mt-1 block w-full shadow-sm text-sm lg:text-base border-gray-300 rounded-md">{{form.parent_style_code}}</p>
                                            <input type="text" name="parent_style_code"
                                                   :disabled="(form.styles_type === 'Customized')"
                                                   v-model="form.parent_style_code"
                                                   id="parent_style_code"
                                                   class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        </div>
                                    </div>

                                    <div class="mt-5">
                                        <div>
                                            <label for="style_description_general_style"
                                                   class="block text-sm font-medium text-gray-700">
                                                Description</label>
                                            <p class="mt-1 block w-full shadow-sm text-sm lg:text-base border-gray-300 rounded-md">{{form.description}}</p>
                                        </div>
                                    </div>


                                    <div class="mt-5 grid lg:grid-cols-4 md:grid-cols-4 sm:grid-cols-1 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">
                                                Item type
                                            </label>
                                            <p class="mt-1 block w-full shadow-sm text-sm lg:text-base border-gray-300 rounded-md">{{form.item_type != null ? form.item_type.name : ''}}</p>
                                        </div>
                                        <div>
                                            <label
                                                for="production_time_general_style"
                                                class="block text-sm font-medium text-gray-700"
                                            >
                                                Production time
                                            </label>
                                            <p class="mt-1 block w-full shadow-sm text-sm lg:text-base border-gray-300 rounded-md">{{form.production_time}}</p>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">
                                                Sizes
                                            </label>
                                            <div class="flex flex-row">
                                                <div v-for="size in form.sizes" class="mt-1 pr-1">
                                                    <div class="border border-gray-400 h-8 w-24 mb-4 md:mb-0 rounded-md inline-flex items-center justify-center">
                                                        <div tabindex="0" aria-label="gray border badge" class="focus:outline-none flex items-center">
                                                            <span class="text-sm text-gray-700 dark:text-gray-100 font-normal">{{size.name}}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">
                                                Factory
                                            </label>
                                            <div class="flex flex-row">
                                                <div v-for="factory in form.factories" class="mt-1 pr-1">
                                                    <div class="border border-gray-400 h-8 w-24 mb-4 md:mb-0 rounded-md inline-flex items-center justify-center">
                                                        <div tabindex="0" aria-label="gray border badge" class="focus:outline-none flex items-center">
                                                            <span class="text-sm text-gray-700 dark:text-gray-100 font-normal">{{factory.name}}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>
                    <el-divider content-position="left"><h3 class="text-lg font-bold">Panels</h3></el-divider>
                    <div class="pb-4">
                        <div>
                            <div class="shadow overflow-hidden sm:rounded-md">
                                <div class="px-4 bg-white sm:p-6">
                                    <div class="pX-5 border-2 border-gray-200">
                                        <el-table
                                            :data="form.panels"
                                            stripe
                                            style="width: 100%"
                                        >

                                            <el-table-column
                                                prop="name"
                                                label="Name"
                                                width="180">
                                            </el-table-column>

                                            <el-table-column
                                                label="Fabrics"
                                            >
                                                <template slot-scope="scope">
                                                    {{ scope.row.fabrics.map(fabric => fabric.name).join(', ') }}
                                                </template>
                                            </el-table-column>

                                            <el-table-column
                                                prop="default_fabric.name"
                                                label="Default Fabric"
                                                width="180">
                                            </el-table-column>

                                            <el-table-column
                                                label="Consumption"
                                                width="180">
                                                <template slot-scope="scope">
                                                    <div v-for="consumption in scope.row.consumption">
                                                        <label> <b>{{ consumption.size.name }} : </b></label>
                                                        <span> {{ consumption.amount }}</span>
                                                    </div>
                                                </template>
                                            </el-table-column>

                                        </el-table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </app-layout>
</template>

<script>
export default {
    name: "Show",
    props: {
        styleData: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            form: {sizes: [], panels: []},

        }
    },
    mounted() {
        this.form = this.styleData
    },
    methods: {

    }
}
</script>

<style scoped>

</style>
