<template>
    <div>
        <div>
            <el-divider content-position="left"><h3 class="text-lg font-bold">General</h3></el-divider>
            <div class="py-4">
                <form>
                    <div class="shadow overflow-hidden sm:rounded-md">
                        <div class="px-4 py-5 bg-white sm:p-6">
                            <div class="grid lg:grid-cols-4 md:grid-cols-4 sm:grid-cols-1 gap-4">
                                <div class="col-span-1 sm:col-span-1" v-if="styleCodeType == 'Customized'">
                                    <label class="block text-sm font-medium text-gray-700">Parent Style code</label>
                                    <input type="text" name="parent_style_code"
                                           :disabled="(styleCodeType == 'Customized')"
                                           v-model="form.parent_style_code"
                                           id="parent_style_code"
                                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div class="col-span-1 sm:col-span-1">
                                    <label class="block text-sm font-medium text-gray-700">Style code extension</label>
                                    <el-tooltip class="item" effect="dark" :content="'type the new extension to change the current extension - '+form.code" placement="top-start">
                                        <el-input placeholder="Extension" v-model="customized_style_code" @change="styleCodeChange">
                                            <template slot="prepend">{{form.parent_style_code}}</template>
                                        </el-input>
                                    </el-tooltip>
                                    <p class="text-xs">Customized style code: {{form.code}}</p>
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
                                        :disabled="(styleCodeType == 'Customized')"
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
                                           :disabled="(styleCodeType == 'Customized')"
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
                <!-- Panel Table -->
                <div class="p-5 border-2 border-gray-200">
                    <table class="w-full">
                        <thead>
                            <tr>
                                <td>Panel</td>
                                <td>Material</td>
                                <td>Colour</td>
                            </tr>
                        </thead>

                        <tbody>
                            <tr v-for="panel in parentStyle.panels" :key="panel.id">
                                <td>{{ panel.name }}</td>
                                <td>
                                    <select class="px-2 my-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/2 p-2.5" @change="(event) => panelFabricSelected(panel.id, event.target.value)">
                                        <option>Select Material</option>
                                        <option v-for="fabric in panel.fabrics" :key="fabric.id" :value="fabric.id"> {{ fabric.name }}</option>
                                    </select>
                                </td>
                                <td>
                                    <select class="px-2 my-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/2 p-2.5" @change="(event) => colourSelected(panel.id, event.target.value)" >
                                        <option>Select Colour</option>
                                        <option v-for="colour in panelColours[panel.id]" :key="colour.id" :value="colour.id"> {{ colour.name }} </option>
                                    </select>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
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
        parentStyle: {
            required: true,
            type: Object
        },
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
        colours: {
            type: Array,
            required: true
        },
        parentPanels:{
            required: true
        },
        componentFabrics:{
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
            form: {
                sizes: [],
                panels: [],
                customized_panels: []
            },
            selectedPanelOptions:{},
            panelColours: {},
            customized_style_code: '',
            panel: this.defaultPanel(),
            component_materials : [],
            show_panel_form: false,
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
                this.form.customized_panels = [];
            },
            deep: true
        },
        form: {
            handler: function (newForm) {
                this.updateConsumptionWhenSizeChanges()
                this.$emit('input', newForm)
            },
            deep: true
        },
    },
    methods: {
        colourSelected(panelId, colourId) {
            this.selectedPanelOptions[panelId].colourId = parseInt(colourId)
            this.form.customized_panels.push(this.selectedPanelOptions[panelId]);
            this.$forceUpdate();
        },

        panelFabricSelected(panelId, fabricId) {
            console.log('fabric selected', panelId, fabricId)
            this.selectedPanelOptions[panelId] = {
                id: panelId,
                fabricId: parseInt(fabricId),
                colourId: null,
            };
            const panel = this.parentStyle.panels.filter(panel => {
                return panel.id == panelId
            })[0];

            const fabric = panel.fabrics.filter(fabric => {
                return fabric.id == fabricId
            })[0];

            if(fabric == undefined) {
                alert('No Fabrics for panel ' + panel.name)
                return false;
            }

            if(fabric.variations.length  == 0 ) {
                alert('No Colours for fabric ' + fabric.name)
                return false;
            }

            const colours = fabric.variations.map(variation => {
                return variation.colour
            })

            this.panelColours[panelId] = colours;
            this.$forceUpdate();
        },

        styleCodeChange(code) {
            this.form.code = this.form.parent_style_code+' '+code
        },
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
            this.show_panel_form = false;
        },
        handleEditPanelRow(dataRow) {
            this.show_panel_form = true;
            this.panel = dataRow;

            if (this.form.id != null) {
                this.panel.id = dataRow.id;
            } else {
                this.panel.id = null;
            }

            this.component_materials = [];
            if (typeof this.panel.fabrics != 'undefined') {
                this.panel.fabrics.forEach((item) => {
                    this.component_materials.push({
                        id: item.id,
                        name: item.name
                    });
                });
            }
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
        },
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
