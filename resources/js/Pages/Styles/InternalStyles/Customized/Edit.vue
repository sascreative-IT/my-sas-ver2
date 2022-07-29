<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <template v-if="styleData.id">
                    Edit customized style - {{styleData.code}}
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
                                               :style="{ backgroundImage: 'url('+url+')'}"
                                               class="bg-contain bg-center bg-no-repeat flex flex-col justify-center items-center w-full h-64 bg-gray-50 rounded-lg border-2 border-gray-300 border-dashed cursor-pointer dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                        </label>
                                    </div>

                                </div>
                            </div>
                            <div>
                                <div>
                                    <div class="pt-2 pb-4">

                                        <label
                                            for="customer_name"
                                            class="block text-base font-medium text-gray-700"
                                        >
                                            Customer Name
                                        </label>

                                        <input
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/2 p-2.5"
                                            type="text"
                                            :placeholder="styleData.customer.name"
                                            disabled="true">
                                        </input>
                                    </div>
                                    <div class="pt-2 pb-4">
                                        <div class="pt-2 pb-4">

                                            <label for="parent_style_code"
                                                   class="block text-base font-medium text-gray-700">
                                                Extending Parent Style Code
                                            </label>

                                            <input
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/2 p-2.5"
                                                type="text"
                                                :placeholder="styleData.parent_style.code"
                                                disabled="true">
                                            </input>

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
                                            <div class="grid lg:grid-cols-4 md:grid-cols-4 sm:grid-cols-1 gap-4">
                                                <div class="col-span-1 sm:col-span-1">
                                                    <label class="block text-sm font-medium text-gray-700">Parent Style code</label>
                                                    <input type="text" name="parent_style_code"
                                                           :placeholder="styleData.parent_style.code"
                                                           :disabled="true"
                                                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                </div>
                                                <div class="col-span-1 sm:col-span-1">
                                                    <label class="block text-sm font-medium text-gray-700">Style code extension</label>
                                                    <input type="text" name="parent_style_code"
                                                           :placeholder="styleData.code"
                                                           :disabled="true"
                                                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                </div>
                                                <div class="col-span-1 sm:col-span-1">
                                                    <label for="style_name_general_style"
                                                           class="block text-sm font-medium text-gray-700">
                                                        Style name</label>
                                                    <input type="text" name="style_name_general_style"
                                                           :placeholder="styleData.name"
                                                           :disabled="true"
                                                           id="style_name_general_style"
                                                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                </div>
                                                <div class="col-span-1 sm:col-span-1">
                                                    <label class="block text-sm font-medium text-gray-700">
                                                        Category
                                                    </label>
                                                    <div class="flex flex-row">
                                                        <div v-for="category in styleData.categories" class="mt-1 pr-1">
                                                            <div class="border border-gray-400 h-8 w-24 mb-4 md:mb-0 rounded-md inline-flex items-center justify-center">
                                                                <div tabindex="0" aria-label="gray border badge" class="focus:outline-none flex items-center">
                                                                    <span class="text-sm text-gray-700 dark:text-gray-100 font-normal">{{category.name}}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-5 grid lg:grid-cols-4 md:grid-cols-4 sm:grid-cols-1 gap-4">
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">
                                                        Item type
                                                    </label>
                                                    <input type="text" name="parent_style_code"
                                                           :placeholder="styleData.item_type.name"
                                                           :disabled="true"
                                                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                </div>
                                                <div>
                                                    <label
                                                        for="production_time_general_style"
                                                        class="block text-sm font-medium text-gray-700"
                                                    >
                                                        Production time
                                                    </label>
                                                    <input type="text" name="parent_style_code"
                                                           :placeholder="styleData.production_time"
                                                           :disabled="true"
                                                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">
                                                        Sizes
                                                    </label>
                                                    <div class="flex flex-wrap">
                                                        <div v-for="size in styleData.sizes" class="mt-1 pr-1">
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
                                                    <div class="flex flex-wrap">
                                                        <div v-for="factory in styleData.factories" class="mt-1 pr-1">
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
                                        <tr v-for="panel in thisStyle.panels" :key="panel.id" v-show="selectedPanelsObj !== typeof('undefined')">
                                            <td>{{ panel.name }}</td>
                                            <td>
                                                <select v-model="selectedPanelsObj[panel.id].fabricId" class="px-2 my-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/2 p-2.5" @change="(event) => panelFabricSelected(panel.id, event.target.value)">
                                                    <option>Select Material</option>
                                                    <option v-for="fabric in panel.fabrics" :key="fabric.id" :value="fabric.id"> {{ fabric.name }}</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select v-model="selectedPanelsObj[panel.id].colourId"  class="px-2 my-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/2 p-2.5" @change="(event) => colourSelected(panel.id, event.target.value)" >
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
                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                        <form-button @handle-on-click="update">
                            Update
                        </form-button>
                    </div>
                </div>
            </div>
        </div>

    </app-layout>
</template>

<script>
import FormButton from "@/UIElements/FormButton";

export default {
    name: "Edit",
    components:{
        FormButton
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
            type: String
        },
        colours: {
            type: Array,
            required: true,
        },
        selectedPanels: {
            type: Object
        },
        parentStyle: {
            required: true,
            type: Object
        },
        thisStyle: {
            required: true,
            type: Object
        },
    },
    data() {
        return {
            form: {
                customized_panels: []
            },
            selectedPanelOptions:{},
            panelColours: {},
            customized_style_code: '',
            panel: this.defaultPanel(),
            component_materials : [],
            show_panel_form: false,
            selectedPanelsObj: {},
        }
    },
    mounted() {
        this.selectedPanelsObj = this.selectedPanels;
        this.form.customized_panels = [];
        Object.entries(this.selectedPanelsObj).forEach(item => {
            this.panelFabricSelected(item[1].id, item[1].fabricId)
            this.colourSelected(item[1].id, item[1].colourId)
        })
        this.form.customized_panels = [];
    },
    methods: {
        colourSelected(panelId, colourId) {
            this.selectedPanelOptions[panelId].colourId = parseInt(colourId)
            this.$forceUpdate();
        },
        panelFabricSelected(panelId, fabricId) {
            this.selectedPanelOptions[panelId] = {
                id: panelId,
                fabricId: parseInt(fabricId),
                colourId: null,
            };
            const panel = this.thisStyle.panels.filter(panel => {
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
        update() {
            this.form.customized_panels = this.selectedPanelsObj;
            this.$inertia.put('/customized-styles/' + this.thisStyle.id, this.form)
        },
    },
    computed: {
        selectedFabrics() {
            return this.panel.fabrics;
        },
        disableAddPanelButton() {
            return false;
        },
    }
}
</script>

<style scoped>

</style>
