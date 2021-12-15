<template>
    <div>
        <el-tabs type="card">
            <el-tab-pane label="General">
                <form>
                    <div class="shadow overflow-hidden sm:rounded-md">
                        <div class="px-4 py-5 bg-white sm:p-6">

                            <div class="grid lg:grid-cols-4 md:grid-cols-4 sm:grid-cols-1 gap-4">
                                <div class="col-span-1 sm:col-span-1">
                                    <label for="style_code_custom_style"
                                           class="block text-sm font-medium text-gray-700">
                                        Style code</label>
                                    <input type="text" name="style_code_custom_style"
                                           v-model="custom_style_form.style_code"
                                           disabled="true"
                                           id="style_code_custom_style"
                                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>

                                <div class="col-span-1 sm:col-span-1">
                                    <label for="extended_style_code"
                                           class="block text-sm font-medium text-gray-700">
                                        Extended style code</label>
                                    <input type="text" name="extended_style_code"
                                           v-model="custom_style_form.extended_style_code"
                                           id="extended_style_code"
                                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>

                                <div class="col-span-1 sm:col-span-1">
                                    <label for="style_name_custom_style"
                                           class="block text-sm font-medium text-gray-700">
                                        Style name</label>
                                    <input type="text" name="style_name_custom_style"
                                           v-model="custom_style_form.style_name"
                                           id="style_name_custom_style"
                                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>

                                <div class="col-span-1 sm:col-span-1">
                                    <label for="style_category_custom_style"
                                           class="block text-sm font-medium text-gray-700">
                                        Category</label>
                                    <select name="style_category_custom_style" id="style_category_custom_style"
                                            v-model="custom_style_form.style_category"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        <option value="basketball">Basketball</option>
                                        <option value="netball">Netball</option>
                                        <option value="rugby">Rugby</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mt-5 grid lg:grid-cols-4 md:grid-cols-4 sm:grid-cols-1 gap-4">
                                <div>
                                    <label for="item_type_custom_style"
                                           class="block text-sm font-medium text-gray-700">
                                        Item type</label>
                                    <select name="item_type_custom_style" id="item_type_custom_style"
                                            v-model="custom_style_form.item_type"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        <option value="t-shirt/POLO">T-shirt/POLO</option>
                                        <option value="hoodie">Hoodie</option>
                                        <option value="dress">Dress</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="production_time_custom_style"
                                           class="block text-sm font-medium text-gray-700">
                                        Production time</label>
                                    <input type="number"
                                           v-model="custom_style_form.production_time"
                                           id="production_time_custom_style"
                                           name="production_time_custom_style"
                                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                           step="1" min="0">
                                </div>
                                <div>
                                    <label for="sizes_custom_style"
                                           class="block text-sm font-medium text-gray-700">
                                        Sizes</label>
                                    <select name="sizes_custom_style" id="sizes_custom_style"
                                            v-model="custom_style_form.size"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        <option value="m">M</option>
                                        <option value="l">L</option>
                                        <option value="xl">XL</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="factory_custom_style"
                                           class="block text-sm font-medium text-gray-700">
                                        Factory</label>
                                    <select name="factory_custom_style" id="factory_custom_style"
                                            v-model="custom_style_form.factory"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        <option value="connolly and Sons">Connolly and Sons</option>
                                        <option value="apperal services">Apperal Services</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </el-tab-pane>
            <el-tab-pane label="Panels">
                <form>
                    <div class="shadow overflow-hidden sm:rounded-md">
                        <div class="px-4 py-5 bg-white sm:p-6">
                            <div
                                class="grid place-items-stretch lg:grid-cols-3 md:grid-cols-3 sm:grid-cols-1 gap-4">
                                <div>
                                    <label for="component_custom_style"
                                           class="text-base font-medium text-gray-700">
                                        Component</label>
                                    <input type="text" name="component_custom_style"
                                           v-model="custom_style_form.style_component"
                                           id="component_custom_style"
                                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div>
                                    <label for="fabric_name_custom_style" class="text-base font-medium text-gray-700">Fabric</label>
                                    <select name="fabric_name_custom_style" id="fabric_name_custom_style"
                                            v-model="custom_style_form.fabric_name"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        <option value="">Select option</option>
                                        <option value="mid-dritech-nub">Mid Dritech NUB</option>
                                        <option value="mid-dritech-grandeur">Mid Dritech Grandeur</option>
                                        <option value="mid-dritech-jongstit">Mid Dritech Jongstit</option>
                                    </select>
                                </div>
                                <div class="mt-8 place-self-start">
                                    <form-button type="button">
                                        Add
                                    </form-button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!--                                Table-->
                <div class="p-5">
                    <div class="shadow overflow-hidden sm:rounded-md">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Component
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Fabric
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        First componenet
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        Mid Dritech YRC
                                    </div>
                                </td>
                                <td>
                                    <edit-button>
                                        Edit
                                    </edit-button>
                                    <delete-button>
                                        Delete
                                    </delete-button>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        Second componenet
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        Mid Dritech NUB
                                    </div>
                                </td>
                                <td>
                                    <edit-button>
                                        Edit
                                    </edit-button>
                                    <delete-button>
                                        Delete
                                    </delete-button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </el-tab-pane>
            <el-tab-pane label="Trims / Accessories">
                <form>
                    <div class="shadow overflow-hidden sm:rounded-md">
                        <div class="px-4 py-5 bg-white sm:p-6">
                            <div class="grid lg:grid-cols-1 md:grid-cols-1 sm:grid-cols-1 gap-4">
                                <div class="w-64">
                                    <label for="trims_accessories_custom_style"
                                           class="text-base font-medium text-gray-700">Trims/Accessories</label>
                                    <select name="trims_accessories_custom_style" id="trims_accessories_custom_style"
                                            v-model="custom_style_form.trims_accessories"
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
            </el-tab-pane>
            <el-tab-pane label="Profit">
                <div class="shadow overflow-hidden sm:rounded-md">
                    <div class="px-4 py-5 bg-white sm:p-6">
                        <div class="grid lg:grid-cols-2 md:grid-cols-2 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="profit_size" class="text-base font-medium text-gray-700">Select
                                    size:</label>
                                <select name="profit_size" id="profit_size"
                                        v-model="custom_style_form.profit.size"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    <option value="mid-dritech-yrc">2XL</option>
                                    <option value="mid-dritech-nub">XS</option>
                                </select>
                            </div>
                            <div>
                                <label for="profit_margin" class="text-base font-medium text-gray-700">Profit
                                    margin:</label>
                                <input type="number"
                                       v-model="custom_style_form.profit.margin"
                                       id="profit_margin"
                                       name="profit_margin"
                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                       step="1" min="0">
                            </div>
                        </div>
                    </div>
                </div>
            </el-tab-pane>
            <el-tab-pane label="Embellishment">
                <div class="shadow overflow-hidden sm:rounded-md">
                    <div class="px-4 py-5 bg-white sm:p-6">
                        <div class="grid lg:grid-cols-1 md:grid-cols-1 sm:grid-cols-1 gap-4">
                            <div>
                                <label for="embellishment" class="text-base font-medium text-gray-700">Select
                                    embellishment:</label>
                                <select name="embellishment" id="embellishment"
                                        v-model="custom_style_form.embellishment"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    <option value="cut-and-sew">Cut and Sew</option>
                                    <option value="sublimation">Sublimation</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </el-tab-pane>
        </el-tabs>
        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
            <form-button @handle-on-click="$emit('custom-style-data',custom_style_form)">
                save
            </form-button>
        </div>
    </div>
</template>

<script>
import FormButton from "@/UIElements/FormButton";
import EditButton from "@/UIElements/EditButton";
import DeleteButton from "@/UIElements/DeleteButton";

export default {
    name: "CustomizedForm",
    components: {
        FormButton,
        EditButton,
        DeleteButton
    },
    props: {
        chosenStyleCode: {
            type: String,
            required: true
        },
        resetForm: Boolean
    },
    mounted() {
        this.custom_style_form.style_code = this.chosenStyleCode;
    },
    data() {
        return {
            custom_style_form: {
                style_code: '',
                extended_style_code: '',
                style_name: '',
                style_category: '',
                item_type: '',
                production_time: '',
                size: '',
                factory: '',
                style_component: '',
                fabric_name: '',
                trims_accessories: '',
                profit: {
                    size: '',
                    margin: ''
                },
                embellishment: ''
            }
        }
    },
    watch: {
        chosenStyleCode: function (newValue, oldValue) {
            if (newValue) {
                this.custom_style_form.style_code = newValue;
            }
        },
        resetForm: function (newValue, oldValue) {
            if (newValue === true) {
                this.resetFormField();
            }
        },
    },
    methods: {
        resetFormField() {
            this.custom_style_form = {
                style_code: '',
                extended_style_code: '',
                style_name: '',
                style_category: '',
                item_type: '',
                production_time: '',
                size: '',
                factory: '',
                style_component: '',
                fabric_name: '',
                trims_accessories: '',
                profit: {
                    size: '',
                    margin: ''
                },
                embellishment: ''
            }
        }
    }


}
</script>

<style scoped>

</style>
