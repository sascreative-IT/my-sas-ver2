<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <template v-if="styleData.id">
                Edit Style - {{styleData.code}}
                </template>
                <template v-else>
                    Add a new style
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

                                        <div class="p-2 flex flex-col justify-between leading-normal">
                                            <label
                                                class="w-52 py-2 px-4 rounded inline-flex items-center">
                                                <input
                                                    name="style_image"
                                                    id="style_image"
                                                    type="file"
                                                    @change="previewImage"
                                                    ref="style_code_image"
                                                    class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none"
                                                />
                                            </label>
                                        </div>

                                        <div
                                            class="h-48 lg:h-auto lg:w-48 flex-none bg-cover rounded-t lg:rounded-t-none lg:rounded-l text-center overflow-hidden">
                                            <img
                                                v-if="url"
                                                :src="url"
                                                class="mt-4 h-32"
                                            />
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
                                :styleCodeType="styleForm.styles_type"
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
import { SweetModal, SweetModalTab } from 'sweet-modal-vue'

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
        parentStyleCode: {
            type: Object
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
        GeneralStyleForm,
        CustomStyleForm,
        NewCustomStyleForm,
        SweetModal
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
            url: null,
        }
    },
    mounted() {
        this.styleForm.styles_type = "General"
        this.styleForm = this.styleData
        if (this.parentStyleCode !== null && (typeof this.parentStyleCode  != 'undefined')) {
            this.styleForm = this.parentStyleCode;
            this.styleForm.parent_style_code = this.parentStyleCode.code;
        }

        if (this.styleType != null) {
            this.styleForm.styles_type = this.styleType
        }

        if (this.customer != null) {
            this.styleForm.customer = this.customers.find(item => {
                return item.id == this.customer
            });
        }

        this.url = "/" + this.styleForm.style_image;

        if (typeof(this.styleForm.parent_style) != 'undefined') {
            this.styleForm.parent_style_code = this.styleForm.parent_style.code;
        }

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
            if (this.$refs.style_code_image) {
                this.styleForm.image = this.$refs.style_code_image.files[0];
            }

            if (this.styleForm.id !== null) {
                this.$inertia.put('/internal-styles/' + this.styleForm.id, this.styleForm)
            } else {
                this.$inertia.post('/internal-styles', this.styleForm,{
                    onFinish: () => {
                        if (Object.keys(this.errors).length > 0) {
                            this.$refs.errorModal.open()
                        }
                    },
                })
            }
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
                        this.styleForm = this.parentStyleCode;
                        this.styleForm.parent_style_code = this.parentStyleCode.code;
                        this.styleForm.code = "";
                        this.styleForm.name = "";
                        this.styleForm.id = null;
                        this.styleForm.parent_style_id = value.id;
                        this.styleForm.parent_style = {
                            'id' : value.id,
                            'name' : value.name,
                        };

                        if (this.styleType != null) {
                            this.styleForm.styles_type = this.styleType
                        }

                        if (this.customer != null) {
                            this.styleForm.customer = this.customers.find(item => {
                                return item.id == this.customer
                            });
                        }
                    }
                },
            })
        },
        setSelectedCustomerId(value) {
            this.styleForm.customer = value;
            this.$inertia.visit(this.$inertia.page.url, {
                preserveState: true,
                preserveScroll: true,
                data: {
                    customer: value
                }
            })

        },
        setStyleType(value) {
            this.$inertia.visit(this.$inertia.page.url, {
                preserveState: true,
                preserveScroll: true,
                data: {
                    type: value
                },
                onSuccess: () => {
                    this.styleForm.styles_type = value
                }
            })
        },
        previewImage(e) {
            const file = e.target.files[0];
            this.url = URL.createObjectURL(file);
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
