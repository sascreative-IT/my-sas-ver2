<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <template>
                    Add a new general style
                </template>
            </h2>
        </template>
        <sweet-modal ref="errorModal" hide-close-button>
            <div>
                <div class="font-medium text-red-600">Whoops! Something went wrong.</div>

                <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                    <li v-for="(error, key) in errors" :key="key">{{ error }}</li>
                </ul>
            </div>
        </sweet-modal>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl rounded-md border">
                    <div class="px-4 py-5 bg-white sm:p-6">
                        <div class="grid lg:grid-cols-2 md:grid-cols-2 sm:grid-cols-1 gap-x-8 gap-y-4">
                            <div>
                                <div class="pt-2 pb-4">
                                    <label
                                        for="style_image"
                                        class="block text-base font-medium text-gray-700"
                                    >
                                        Style image
                                    </label>

                                    <div class="flex justify-center items-center w-full relative">
                                        <label for="dropzone-file"
                                               :class="{'bg-contain bg-center bg-no-repeat' : uploadFieldNotEmpty}" :style="{ backgroundImage: 'url('+url+')'}"
                                               class="flex flex-col justify-center items-center w-full h-64 bg-gray-50 rounded-lg border-2 border-gray-300 border-dashed cursor-pointer dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                            <div class="flex flex-col justify-center items-center pt-5 pb-6">
                                                <svg class="mb-3 w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span></p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">JPEG, JPG or PNG</p>
                                            </div>
                                            <input name="style_image" id="dropzone-file" type="file" @change="previewImage" ref="style_code_image" class="hidden" />
                                        </label>
                                        <div class="absolute top-4 right-4 cursor-pointer" v-show="uploadFieldNotEmpty" @click="setUploadFieldEmpty">
                                            <el-tooltip content="Remove image" placement="top">
                                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                                </svg>
                                            </el-tooltip>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-xl rounded-md border mt-5">
                    <div class="bg-gray-500 pl-5 pt-2 pb-2 text-white">
                        <h4>Style information</h4>
                    </div>
                    <div class="p-5">
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
                </div>
                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                    <form-button @handle-on-click="save">
                        save
                    </form-button>
                </div>
            </div>
        </div>

    </app-layout>
</template>

<script>
import FormButton from "@/UIElements/FormButton";
import EditButton from "@/UIElements/EditButton";
import DeleteButton from "@/UIElements/DeleteButton";
import { SweetModal, SweetModalTab } from 'sweet-modal-vue';
import AppSelect from "@/UIElements/AppSelect";

export default {
    name: "Create",
    props: {
        customers: {
            type: Array,
            required: true
        },
        categories: {
            type: Array,
            required: true
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
        styleData: {
            type: Object,
            required: true,
        },
        materials: {
            type: Array,
            required: true,
        },
        errors: {
            type: Object,
            required: false
        },
        styles: {
            type: Array,
            required: true
        },
        styleType: {
            type: String
        },
        customer: {
            type: String
        }
    },
    components: {
        FormButton,
        EditButton,
        DeleteButton,
        SweetModal,
        AppSelect
    },
    data() {
        return {
            is_customized: false,
            show_new_customized_form: false,
            show_customized_fields: false,
            show_customized_form: false,
            payload: {
                select_style_code: '',
                select_customer: 2,
                style_information: {}
            },
            reset_forms: false,
            styleForm: {},
            url: '',
            form: {styles_type:"General",belongs_to:"internal", sizes: [], panels: []},
            panel: this.defaultPanel()
        }
    },
    mounted() {
        this.styleForm = this.styleData
    },
    watch: {
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
        save() {
            if (this.$refs.style_code_image) {
                this.styleForm.image = this.$refs.style_code_image.files[0];
            }

            this.$inertia.post('/internal-styles', this.form,{
                onFinish: () => {
                    if (Object.keys(this.errors).length > 0) {
                        this.$refs.errorModal.open()
                    }
                },
            })
        },
        previewImage(e) {
            const file = e.target.files[0];
            this.url = URL.createObjectURL(file);
        },
        setUploadFieldEmpty(){
            this.url = '';
            this.$refs.style_code_image.value = null;
        },
        defaultPanel() {
            return {
                name: null,
                fabrics: [],
                default_fabric: {id: null},
                consumption: []
            }
        },
        addPanel(){
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
        },
        updateConsumptionWhenSizeChanges() {
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
    },
    computed: {
        uploadFieldNotEmpty(){
            return this.url !== '';
        },
        selectedFabrics() {
            return this.panel.fabrics;
        },
        selectedSizes() {
            return this.form.sizes;
        }
    }
}
</script>

<style scoped>
input:checked ~ .dot {
    transform: translateX(100%);
    background-color: #374151;
}

</style>
