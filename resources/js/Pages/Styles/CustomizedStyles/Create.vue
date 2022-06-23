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
                            <div>
                                <div>
                                    <div v-if="styleForm.styles_type !== 'General'">
                                    <div class="pt-2 pb-4">

                                        <label
                                            for="customer_name"
                                            class="block text-base font-medium text-gray-700"
                                        >
                                            Customer Name
                                        </label>

                                        <v-select
                                            id="customer_name"
                                            v-model="styleForm.customer"
                                            label="name"
                                            item-id="id"
                                            :options="customers"
                                            :reduce="customer => customer.id"
                                            @input="setSelectedCustomerId"
                                        ></v-select>
                                    </div>
                                    <div class="pt-2 pb-4" v-if="styleForm.styles_type === 'Customized'">
                                        <div class="pt-2 pb-4">

                                            <label for="parent_style_code"
                                                   class="block text-base font-medium text-gray-700">
                                                Extending Parent Style Code
                                            </label>

                                            <v-select
                                                :disabled="styleForm.styles_type === 'General'"
                                                id="parent_style_code"
                                                v-model="styleForm.parent_style"
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
                                :colours="colours"
                                :factories="factories"
                                v-model="styleForm"
                                :errors="errors"
                                :styleCodeType="styleForm.styles_type"
                            ></general-style-form>
                        </div>
                    </div>
                </div>
                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6" v-if="styleData.id">
                    <form-button @handle-on-click="update">
                        Update
                    </form-button>
                </div>
                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6" v-else>
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
        },
        colours: {
            type: Array,
            required: true,
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

        if (typeof(this.styleForm.parent_style) != 'undefined' && this.styleForm.parent_style != null) {
            this.styleForm.parent_style_code = this.styleForm.parent_style.code;
        }
        // console.log(this.styleForm.parent_style)

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

            this.$inertia.post('/customized-styles', this.styleForm)
        },
        update() {
            this.$inertia.put('/customized-styles/' + this.styleForm.id, this.styleForm)
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
                            'code' : value.code
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
