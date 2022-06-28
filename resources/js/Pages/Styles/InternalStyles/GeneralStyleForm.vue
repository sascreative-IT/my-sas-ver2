<template>
    <div>
        <div>
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
                                    <input type="text" name="style_code_general_style"
                                           v-model="form.code"
                                           id="style_code_general_style"
                                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>



                                <div class="col-span-1 sm:col-span-1">
                                    <label for="style_name_general_style"
                                           class="block text-sm font-medium text-gray-700">
                                        Style name</label>
                                    <input type="text" name="style_name_general_style"
                                           v-model="form.name"
                                           id="style_name_general_style"
                                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>

                                <div class="col-span-1 sm:col-span-1">
                                    <label class="block text-sm font-medium text-gray-700">
                                        Category
                                    </label>
                                    <app-select
                                        :filterable="true"
                                        :multiple="true"
                                        :options="categories"
                                        option-label="name"
                                        no-data-text="No Categories available"
                                        no-match-text="Category not found"
                                        v-model="form.categories"
                                        placeholder="Select Category"
                                    ></app-select>
                                </div>
                            </div>
                            <div class="mt-5" v-if="styleCodeType == 'Customized'">
                                <div class="col-span-1 sm:col-span-1">
                                    <label for="style_code_general_style"
                                           class="block text-sm font-medium text-gray-700">
                                        Parent Style code</label>
                                    <input type="text" name="parent_style_code"
                                           :disabled="(styleCodeType == 'Customized')"
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
                                    <textarea name="style_description_general_style"
                                              v-model="form.description"
                                              id="style_description_general_style"
                                              class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
                                </div>
                            </div>


                            <div class="mt-5 grid lg:grid-cols-4 md:grid-cols-4 sm:grid-cols-1 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">
                                        Item type
                                    </label>
                                    <app-select
                                        :filterable="true"
                                        :multiple="false"
                                        :options="itemTypes"
                                        option-label="name"
                                        no-data-text="No Categories available"
                                        no-match-text="Category not found"
                                        v-model="form.item_type"
                                        placeholder="Select Type"
                                    ></app-select>
                                </div>
                                <div>
                                    <label
                                        for="production_time_general_style"
                                        class="block text-sm font-medium text-gray-700"
                                    >
                                        Production time
                                    </label>
                                    <input type="number"
                                           v-model="form.production_time"
                                           id="production_time_general_style"
                                           name="production_time_general_style"
                                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                           step="1" min="0"
                                    />
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">
                                        Sizes
                                    </label>
                                    <app-select
                                        :filterable="true"
                                        :multiple="true"
                                        :options="sizes"
                                        option-label="name"
                                        no-data-text="No Categories available"
                                        no-match-text="Category not found"
                                        v-model="form.sizes"
                                        placeholder="Select Sizes"
                                    ></app-select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">
                                        Factory
                                    </label>
                                    <app-select
                                        :filterable="true"
                                        :multiple="true"
                                        :options="factories"
                                        option-label="name"
                                        no-data-text="No Factory available"
                                        no-match-text="Factory not found"
                                        v-model="form.factories"
                                        placeholder="Select Factories"
                                    ></app-select>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
            <el-divider content-position="left"><h3 class="text-lg font-bold">Panels</h3></el-divider>
            <div class="py-4">
                <div class="p-5 border-2 border-gray-200">
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

                        <el-table-column
                            label="Action"
                            width="180">
                            <template slot-scope="scope">
                                <form-button @handle-on-click="handleEditPanelRow(scope.row)">
                                    Edit
                                </form-button>
                            </template>
                        </el-table-column>

                    </el-table>
                </div>
                <!-- Panel Add form -->
                <div>
                    <div class="shadow overflow-hidden sm:rounded-md">
                        <div class="px-4 bg-white sm:p-6">
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0 pb-6">
                                <label class="block text-sm text-gray-700 mb-2" for="grid-first-name">
                                    Component Name
                                </label>
                                <input
                                    class="appearance-none block w-full text-gray-700 border rounded leading-tight focus:outline-none focus:bg-white"
                                    id="grid-first-name"
                                    type="text"
                                    v-model="panel.name"
                                >
                            </div>

                            <div class="w-full px-3 mb-6 md:mb-0 pb-6">
                                <label class="block text-gray-700 text-sm mb-2" for="grid-first-name">
                                    Fabrics
                                </label>

                                <div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <app-select
                                                v-model="panel.fabrics"
                                                filterable
                                                multiple
                                                :multiple-limit="styleCodeType === 'New-Customized' ? 1 : 0"
                                                placeholder="Select Fabric"
                                                :options="materials"
                                                option-label="name"
                                                option-value="id"
                                            ></app-select>
                                        </div>

                                        <div>
                                            <app-select
                                                v-model="panel.default_fabric"
                                                filterable
                                                placeholder="Select Default Fabric"
                                                no-data-text="No Fabrics Selected"
                                                no-match-text="No Result"
                                                :options="selectedFabrics"
                                                option-label="name"
                                                option-value="id"
                                            ></app-select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0 pb-6">
                                <label class="block text-sm text-gray-700 mb-2" for="grid-first-name">
                                    Consumption
                                </label>

                                <div>
                                    <div class="consumption mb-2" v-for="(consumption, index) in panel.consumption">
                                        <el-input placeholder="Enter Consumption" v-model="consumption.amount">
                                            <template slot="append">{{ consumption.size.name }}</template>
                                        </el-input>
                                    </div>

                                    <div v-if="selectedSizes.length === 0">
                                        <span><i class="text-sm text-gray-500">No Sizes selected for this style code</i></span>
                                    </div>

                                </div>

                            </div>
                            <hr>

                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0 pb-6">
                                <form-button @handle-on-click="addPanel">
                                    Add Panel
                                </form-button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- End of Panel Add form -->
            </div>
            <el-divider content-position="left"><h3 class="text-lg font-bold">Trims / Accessories</h3></el-divider>
            <div class="py-4">
                <form>
                    <div class="shadow overflow-hidden sm:rounded-md">
                        <div class="px-4 py-5 bg-white sm:p-6">
                            <div class="grid lg:grid-cols-1 md:grid-cols-1 sm:grid-cols-1 gap-4">
                                <div class="w-64">
                                    <label for="trims_accessories_general_style" class="text-base font-medium text-gray-700">Trims/Accessories</label>
                                    <select name="trims_accessories_general_style" id="trims_accessories_general_style"
                                            v-model="form.trims_accessories"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        <option value="">Select option</option>
                                        <option value="mid-dritech-nub">Mid Dritech NUB</option>
                                        <option value="mid-dritech-grandeur">Mid Dritech Grandeur</option>
                                        <option value="mid-dritech-jongstit">Mid Dritech Jongstit</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</template>

<script>
import FormButton from "@/UIElements/FormButton";
import EditButton from "@/UIElements/EditButton";
import DeleteButton from "@/UIElements/DeleteButton";
import AppSelect from "@/UIElements/AppSelect";
import Label from "@/Jetstream/Label";

export default {
    name: "GeneralStyleForm",
    components: {
        Label,
        AppSelect,
        FormButton,
        EditButton,
        DeleteButton
    },
    props: {
        resetForm: Boolean,
        styleCodeType: String,
        categories: {
            required: true,
            type: Array
        },
        itemTypes: {
            type: Array,
            required: true
        },
        sizes: {
            type: Array,
            required: true
        },
        factories: {
            type: Array,
            required: true
        },
        value: {
            type: Object,
            required: true
        },
        materials: {
            type: Array,
            required: true
        },
        errors: {
            type: Object,
            required: false,
            default: {}
        }
    },
    data() {
        return {
            form: {sizes: [], panels: []},
            panel: this.defaultPanel()
        }
    },
    mounted() {
        this.form = this.value
    },
    watch: {
        resetForm: function (newValue, oldValue) {
            if (newValue === true) {
                this.resetFormField();
            }
        },
        value: {
            handler(newValue) {
                this.form = newValue
            },
            deep: true
        },
        form: {
            handler: function (newForm) {
                this.updateConsumptionWhenSizeChanges()
                this.$emit('input', newForm)
            },
            deep: true
        }
    },
    methods: {
        defaultPanel() {
            return {
                name: null,
                fabrics: [],
                default_fabric: {id: null},
                consumption: []
            }
        },
        resetPanels() {
            this.panel = this.defaultPanel()
        },
        updateConsumptionWhenSizeChanges() {
            /*
            this.panel.consumption = this.form.sizes.map(size => {
                console.log(">>>",size)
               return {
                   size: size,
                   amount: null
               }
            });
             */

             let temp_consumption = [...this.panel.consumption]
             this.panel.consumption = this.form.sizes.map(selected_size => {
                 let amount = null

                 let already_set_consumption = temp_consumption.filter((already_set_consumption) => {
                     return already_set_consumption.size.id === selected_size.id
                 })

                 if (already_set_consumption.length > 0) {
                     amount = already_set_consumption[0].amount;
                 }

                 return  {
                     size: {
                         id: selected_size.id,
                         name: selected_size.name
                     },
                     amount: amount
                 }
             })
        },

        resetFormField() {
        },
        addPanel() {
            this.form.panels.push(this.panel)
            this.panel = {
                name: null,
                fabric_ids: [],
                default_fabric: {id: null},
                consumption: []
            }
        },
        handleEditPanelRow(dataRow) {
            this.panel = dataRow;
            for (let [index, val] of this.form.panels.entries()) {
                if (dataRow.name == val.name) {
                    this.form.panels.splice(index, 1);
                }
            }
        }
    },
    computed: {
        selectedFabrics() {
            return this.panel.fabrics;
        },
        selectedSizes() {
            return this.form.sizes;
            // if (this.value.sizes === undefined) {
            //     return []
            // }
            //
            // return this.sizes.filter((size) => {
            //     return this.value.sizes.includes(size.id)
            // })
        },
        disableAddPanelButton() {
            return false;
        }
    }
}
</script>

<style>
.dropdown-menu {
    z-index:10030 !important;
}

.consumption .el-input-group__append {
    width: 80px !important;
    text-align: center;
}
</style>


<style scoped>

</style>
