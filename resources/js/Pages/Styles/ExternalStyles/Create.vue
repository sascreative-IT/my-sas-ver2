<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Add a new style
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="mb-5">
                    <el-alert
                        v-if="errors.length > 0"
                        title="Failed to create style"
                        type="error"
                        show-icon
                    >
                        <ul>
                            <li v-for="error in errors">
                                {{ error}}
                            </li>
                        </ul>
                    </el-alert>
                </div>

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

                                    <div
                                        class="mt-1 pb-4 border-dotted h-48 rounded-lg border-dashed border-2 border-gray-400 flex justify-center items-center">
                                        <div
                                            class="h-48 lg:h-auto lg:w-48 flex-none bg-cover rounded-t lg:rounded-t-none lg:rounded-l text-center overflow-hidden">
                                            <img class="w-32" alt="uploaded-file-thumbnail">
                                        </div>
                                        <div class="p-2 flex flex-col justify-between leading-normal">
                                            <label
                                                class="bg-gray-300 w-52 hover:bg-gray-400 text-gray-800 py-2 px-4 rounded inline-flex items-center">
                                                <i class="fas fa-file-upload fa-lg"></i>
                                                <span class="pl-2">Upload the image</span>
                                                <input
                                                    ref="logo" type="file"
                                                    class="opacity-0 w-2"
                                                    name="style_image"
                                                    id="style_image"
                                                />
                                            </label>
                                        </div>
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

                                        <v-select
                                            id="customer_name"
                                            v-model="styleForm.customer_id"
                                            label="name"
                                            item-id="id"
                                            :options="customers"
                                            :reduce="customer => customer.id"
                                        ></v-select>
                                    </div>
                                    <div class="pt-2 pb-4">
                                        <div class="pt-2 pb-4">

                                            <label for="extending_style_code"
                                                   class="block text-base font-medium text-gray-700">
                                                Extending Style code
                                            </label>

                                            <v-select
                                                id="extending_style_code"
                                                v-model="styleForm.extending_style_id"
                                                label="name"
                                                item-id="id"
                                            ></v-select>
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
                            <general-style-form
                                @general-style-data="save"
                                :reset-form="reset_forms"
                                :categories="categories"
                                :materials="materials"
                                :item-types="itemTypes"
                                :sizes="sizes"
                                :factories="factories"
                                v-model="styleForm"
                                :errors="errors"
                            ></general-style-form>
                        </div>
                        <!--                        <div v-show="show_customized_form && is_customized">-->
                        <!--                            <custom-style-form-->
                        <!--                                :chosen-style-code="payload.select_style_code"-->
                        <!--                                @custom-style-data="save"-->
                        <!--                                :reset-form="reset_forms"-->
                        <!--                            ></custom-style-form>-->
                        <!--                        </div>-->
                        <!--                        <div v-show="show_new_customized_form && is_customized">-->
                        <!--                            <new-custom-style-form-->
                        <!--                                @new-style-data="save"-->
                        <!--                                :reset-form="reset_forms"-->
                        <!--                            ></new-custom-style-form>-->
                        <!--                        </div>-->
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
import GeneralStyleForm from "@/Pages/Styles/InternalStyles/GeneralStyleForm";
import CustomStyleForm from "@/Pages/Styles/InternalStyles/CustomStyleForm";
import NewCustomStyleForm from "@/Pages/Styles/InternalStyles/NewCustomStyleForm";

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
        }
    },
    components: {
        FormButton,
        EditButton,
        DeleteButton,
        GeneralStyleForm,
        CustomStyleForm,
        NewCustomStyleForm
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
        }
    },
    mounted() {
        this.styleForm = this.styleData
    },
    methods: {
        selectStyleType() {
            if (this.is_customized) {
                this.show_customized_fields = true;
            } else {
                this.payload.select_style_code = "";
                this.payload.select_customer = "";
                this.show_customized_fields = false;
            }
        },
        selectExtendedStyle(e) {
            e.preventDefault();
            if (this.payload.select_style_code !== '' && this.payload.select_customer !== '') {
                this.show_customized_form = true;
                this.show_new_customized_form = false;
            } else if (this.payload.select_style_code === '' && this.payload.select_customer !== '') {
                this.show_new_customized_form = true;
                this.show_customized_form = false;
            } else {
                this.show_customized_form = false;
            }
        },
        save() {
            console.log(this.styleForm);
            this.$inertia.post('/internal-styles', this.styleForm)
        },
    }
}
</script>

<style scoped>
input:checked ~ .dot {
    transform: translateX(100%);
    background-color: #374151;
}

</style>
