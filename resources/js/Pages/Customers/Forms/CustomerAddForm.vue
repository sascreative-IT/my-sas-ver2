<template>
    <form @submit.prevent="onSubmit" enctype="multipart/form-data">
    <div class="shadow overflow-hidden sm:rounded-md">
        <div class="px-4 py-5 bg-white sm:p-6">
            <div class="grid lg:grid-cols-2 md:grid-cols-2 sm:grid-cols-1 gap-x-8 gap-y-4">
                <div>
                    <div class="pt-2 pb-4">
                        <label for="customer_logo" class="block text-base font-medium text-gray-700">Customer
                            Logo</label>
                        <div
                            class="mt-1 pb-4 border-dotted h-48 rounded-lg border-dashed border-2 border-gray-400 flex justify-center items-center">
                            <div v-if="fileUploadUrl" class="h-48 lg:h-auto lg:w-48 flex-none bg-cover rounded-t lg:rounded-t-none lg:rounded-l text-center overflow-hidden">
                                <img class="w-32" :src="fileUploadUrl" alt="uploaded-file-thumbnail">
                            </div>
                            <div class="p-2 flex flex-col justify-between leading-normal">
                                <label class="bg-gray-300 w-52 hover:bg-gray-400 text-gray-800 py-2 px-4 rounded inline-flex items-center">
                                    <i class="fas fa-file-upload fa-lg"></i>
                                    <span class="pl-2">Upload the logo</span>
                                    <input v-on:change="onFileChange" ref="logo" type="file"
                                           class="opacity-0 w-2" name="customer_logo"
                                           id="customer_logo">
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="pt-2 pb-4">
                        <label for="full_name" class="block text-base font-medium text-gray-700">Full
                            name</label>
                        <input v-model="customer.name" type="text" name="full_name" id="full_name"
                               autocomplete="given-name"
                               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                    <div class="pt-2 pb-4">
                        <label for="email_address" class="block text-base font-medium text-gray-700">Email
                            address</label>
                        <input v-model="customer.email" type="email" name="email_address"
                               id="email_address" autocomplete="email"
                               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                </div>

                <div>
                    <div class="pt-2 pb-4">
                        <label for="cs_agent" class="block text-base font-medium text-gray-700">Customer
                            service agent</label>
                        <select v-model="customer.cs_agent_id" id="cs_agent" name="cs_agent"
                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option v-for="csAgent in csAgents" :value="csAgent.id">
                                {{ csAgent.name }}
                            </option>
                        </select>
                    </div>
                    <div class="pt-2 pb-4">
                        <label for="sales_agent"
                               class="block text-base font-medium text-gray-700">Sales agent</label>
                        <select v-model="customer.sales_agent_id" id="sales_agent"
                                name="sales_agent"
                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option v-for="salesAgent in salesAgents" :value="salesAgent.id">
                                {{ salesAgent.name }}
                            </option>
                        </select>
                    </div>
                    <div class="pt-2 pb-4">
                        <label for="description" class="block text-base font-medium text-gray-700">Details</label>
                        <textarea v-model="customer.description" type="text" name="description"
                                  id="description"
                                  class="mt-1 resize-none focus:ring-indigo-500 focus:border-indigo-500 block w-full h-28 shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            </textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-6 mt-6">
                        <div class="col-span-1">
                            <div>
                              <form-button>
                                Next
                              </form-button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>
</template>

<script>
import FormButton from "@/UIElements/FormButton";
import NProgress from 'nprogress'

export default {
name: "CustomerAddForm",
  components: {FormButton},
    props: {
        csAgents: {
            required: true,
            type: Array
        },
        salesAgents: {
            required: true,
            type: Array
        }
    },
    data() {
        return {
            customer: {
                name: '',
                email: '',
                description: '',
                cs_agent_id: null,
                sales_agent_id: null,
                logo_id: null,
            },
            uploads: {
                logo:''
            },
            fileUploadUrl: null,
            uploadInstructions: true,
            submitted: false,
        }
    },
    methods: {
        onFileChange(e) {
            this.uploads.logo = e.target.files[0];
            const isUploaded = e.target.files.length;
            if (isUploaded !== 0) {

                const headers = {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                }
                const form = new FormData();
                form.append('logo', this.uploads.logo);
                NProgress.start();
                axios.post('/upload-logo', form, { headers: headers}).
                then(response => {
                    this.customer.logo_id = response.data.logo_id;
                    NProgress.done();
                }).catch(error => {
                    console.log(error);
                    NProgress.done();
                });

                this.fileUploadUrl = URL.createObjectURL(this.uploads.logo);
                this.uploadInstructions = false;
            } else {
                this.uploadInstructions = true;
                this.uploads.logo = '';
                this.fileUploadUrl = '';
            }
        },
        onSubmit() {
            this.$emit('onSubmit', this.customer)
        }
    }
}
</script>

<style scoped>

</style>
