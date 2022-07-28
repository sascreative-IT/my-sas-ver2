<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <template>
                    Create a customized style
                </template>
            </h2>
        </template>

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
                            <div>
                                <div class="pt-2 pb-4">

                                    <label
                                        for="customer_name"
                                        class="block text-base font-medium text-gray-700"
                                    >
                                        Customer Name
                                    </label>

                                    <v-select
                                        id="customer_name"
                                        v-model="form.customer"
                                        label="name"
                                        item-id="id"
                                        :options="customers"
                                        :reduce="customer => customer.id"
                                        @input="setSelectedCustomerId"
                                    ></v-select>
                                </div>
                                <div class="pt-2 pb-4">
                                    <div class="pt-2 pb-4 z-10 absolute">
                                        <label for="parent_style_code"
                                               class="block text-base font-medium text-gray-700">
                                            Extending Parent Style Code
                                        </label>
                                        <v-select
                                            id="parent_style_code"
                                            v-model="form.parent_style"
                                            :options="styles"
                                            label="code"
                                            item-id="id"
                                            @input="setSelectedStyleCode"
                                        ></v-select>
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
                                            <div class="grid lg:grid-cols-4 md:grid-cols-4 sm:grid-cols-1 gap-4">
                                                <div class="col-span-1 sm:col-span-1">
                                                    <label class="block text-sm font-medium text-gray-700">Parent Style code</label>
                                                    <input type="text" name="parent_style_code"
                                                           :disabled="true"
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
                                                        :disabled="true"
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
                                                           :disabled="true"
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
                                                        :clearable="false"
                                                        :filterable="true"
                                                        :multiple="true"
                                                        :options="sizes"
                                                        :all-removable="false"
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
                                                        :all-removable="false"
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
                                    <table class="w-full">
                                        <thead>
                                        <tr>
                                            <td>Panel</td>
                                            <td>Material</td>
                                            <td>Colour</td>
                                        </tr>
                                        </thead>

                                        <tbody v-if="parentStyleCode !== null">
                                        <tr v-for="panel in parentStyleCode.panels" :key="panel.id">
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
import GeneralStyleForm from "@/Pages/Styles/CustomizedStyles/GeneralStyleForm";
import CustomStyleForm from "@/Pages/Styles/CustomizedStyles/CustomStyleForm";
import NewCustomStyleForm from "@/Pages/Styles/CustomizedStyles/NewCustomStyleForm";
import vue2Dropzone from 'vue2-dropzone'
import 'vue2-dropzone/dist/vue2Dropzone.min.css'
import AppSelect from "@/UIElements/AppSelect";
import Label from "@/Jetstream/Label";

export default {
    name: "Create",
    components: {
        FormButton,
        EditButton,
        DeleteButton,
        Label,
        GeneralStyleForm,
        CustomStyleForm,
        NewCustomStyleForm,
        AppSelect,
        vueDropzone: vue2Dropzone
    },
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
        parentStyleCode: {
            type: Object
        },
        styleType: {
            type: String
        },
        customer: {
            type: Number
        },
        colours: {
            type: Array,
            required: true,
        },
        selectedPanels: {
            type: Object
        }
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
            parent_panels:{},
            component_fabrics:[],
            url: '',
            form: {
                styles_type:"Customized",
                belongs_to:"internal",
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
        this.styleForm = this.styleData
        if (this.parentStyleCode !== null && (typeof this.parentStyleCode  != 'undefined')) {
            this.form = this.parentStyleCode;
            this.form.parent_style_code = this.parentStyleCode.code;
            this.form.customized_panels = [];
        }

        if (this.styleType != null) {
            this.form.styles_type = this.styleType
        }

        if (this.customer != null) {
            this.form.customer = this.customers.find(item => {
                return item.id === this.customer
            });
        }

        if (this.parentStyleCode != null) {
            this.form.parent_style = {
                code: this.parentStyleCode.code,
                id: this.parentStyleCode.id,
                name: this.parentStyleCode.name
            }
        }

        if ( this.styleData.style_image === "" || this.styleData.style_image == null) {
            this.url = ''
        } else {
            this.url = this.styleData.style_image;
        }

    },
    methods: {
        previewImage(e) {
            const file = e.target.files[0];
            this.url = URL.createObjectURL(file);
        },
        setUploadFieldEmpty(){
            this.url = '';
            this.$refs.style_code_image.value = null;
        },
        setSelectedCustomerId(value) {
            this.form.customer = value;
            this.$inertia.visit(this.$inertia.page.url, {
                preserveState: true,
                preserveScroll: true,
                data: {
                    customer: parseInt(value)
                }
            })
        },
        setSelectedStyleCode(value) {
            this.$inertia.visit(this.$inertia.page.url, {
                preserveState: true,
                preserveScroll: true,
                data: {
                    parent_id: value.id
                },
                onSuccess: () => {
                    if (this.parentStyleCode !== null) {
                        this.form = this.parentStyleCode;
                        this.form.parent_style_code = this.parentStyleCode.code;
                        this.form.code = "";
                        this.form.name = "";
                        this.form.id = null;
                        this.form.parent_style_id = value.id;
                        this.form.parent_style = {
                            'id' : value.id,
                            'name' : value.name,
                            'code' : value.code
                        };

                        if (this.styleType != null) {
                            this.form.styles_type = this.styleType
                        }

                        if (this.customer != null) {
                            this.form.customer = this.customers.find(item => {
                                return item.id == this.customer
                            });
                        }
                    }
                },
            })
        },
        defaultPanel() {
            return {
                name: null,
                fabrics: [],
                default_fabric: {id: null},
                consumption: []
            }
        },
        styleCodeChange(code) {
            this.form.code = this.form.parent_style_code+' '+code
        },
        colourSelected(panelId, colourId) {
            this.selectedPanelOptions[panelId].colourId = parseInt(colourId)
            this.form.customized_panels = this.selectedPanelOptions
            this.$forceUpdate();
        },
        panelFabricSelected(panelId, fabricId) {
            console.log('fabric selected', panelId, fabricId)
            this.selectedPanelOptions[panelId] = {
                id: panelId,
                fabricId: parseInt(fabricId),
                colourId: null,
            };
            const panel = this.parentStyleCode.panels.filter(panel => {
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
        save() {
            if (this.$refs.style_code_image) {
                this.form.image = this.$refs.style_code_image.files[0];
            }
            this.$inertia.post('/customized-styles', this.form)
        },
    },
    computed: {
        uploadFieldNotEmpty(){
            return this.url !== '';
        }
    }
}
</script>

<style scoped>

</style>
