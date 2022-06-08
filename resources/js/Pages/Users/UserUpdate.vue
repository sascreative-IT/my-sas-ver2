<template>
    <app-layout>
        <Notify :flash="$page.props.flash"></Notify>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Update User
            </h2>
        </template>

        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="bg-gray-500 pl-5 pt-2 pb-2 text-white">
                        <h4>User details</h4>
                    </div>
                    <form>
                        <div class="shadow overflow-hidden sm:rounded-md">
                            <div class="md:px-4 md:pt-5 md:pb-40 bg-white p-6">
                                <div class="grid grid-cols-6 gap-6">
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="full_name" class="block text-sm font-medium text-gray-700">Full
                                            Name</label>
                                        <input v-model="user.name" type="text" name="full_name" id="full_name"
                                               autocomplete="given-name"
                                               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="email_address" class="block text-sm font-medium text-gray-700">Email
                                            address</label>
                                        <input v-model="user.email" type="email" name="email_address" id="email_address"
                                               autocomplete="email"
                                               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="default_factory"
                                               class="block text-sm font-medium text-gray-700">Default Factory</label>
                                        <select id="default_factory"
                                                v-model="user.selected_factory_id"
                                                name="default_factory"
                                                autocomplete="default_factory"
                                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                            <option v-for="factory in factories" :value="factory.id">
                                                {{ factory.name }}
                                            </option>
                                        </select>
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="factories"
                                               class="block text-sm font-medium text-gray-700">Assign Factories</label>
                                        <v-select multiple class="style-chooser" v-model="user.selected_factories" :options="factoriesArr" :reduce="(option) => option.id" />
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="contact_number"
                                               class="block text-sm font-medium text-gray-700">Contact number</label>
                                        <input type="text" name="contact_number" id="contact_number"
                                               v-model="user.contact_number"
                                               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="factory"
                                               class="block text-sm font-medium text-gray-700">Assign roles</label>
                                        <v-select multiple class="style-chooser" v-model="user.selected_roles"
                                                  :options="rolesArr"/>
                                    </div>

                                </div>
                            </div>
                            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                <form-button
                                    @handle-on-click="updateUser"
                                >Save
                                </form-button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="bg-gray-500 pl-5 pt-2 pb-2 text-white">
                        <h4>Reset password</h4>
                    </div>
                    <form>
                        <div class="shadow overflow-hidden sm:rounded-md">
                            <div class="px-4 py-5 bg-white sm:p-6">
                                <div class="flex flex-row">
                                    <div>
                                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                                        <input v-model="password" type="text" name="password" id="password"
                                               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    <div class="mt-6 pl-6">
                                        <edit-button
                                            @handle-on-click="generatePassword"
                                        >Generate a new password
                                        </edit-button>
                                    </div>
                                    <div class="mt-6 pl-6">
                                        <form-button
                                            @handle-on-click="savePassword"
                                        >Update
                                        </form-button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="bg-gray-500 pl-5 pt-2 pb-2 text-white">
                        <h4>Deactivate</h4>
                    </div>
                    <form>
                        <div class="shadow overflow-hidden sm:rounded-md">
                            <div class="px-4 py-5 bg-white sm:p-6">
                                <div class="flex flex-row">
                                    <div>
                                        <p>Deactivate this user account</p>
                                    </div>
                                    <div class="pl-6">
                                        <delete-button
                                            @handle-on-click="deactivateUser"
                                        >Deactivate
                                        </delete-button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import FormButton from "@/UIElements/FormButton";
import EditButton from "@/UIElements/EditButton";
import DeleteButton from "@/UIElements/DeleteButton";
import Notify from "@/UIElements/Notify";

export default {
    name: "UserUpdate",
    props: {
        initUser: {
            type: Object,
            required: true
        },
        factories: {
            type: Array,
            required: true,
        },
        roles: {
            type: Array,
            required: true
        },
        flash: {
            type:Object
        }
    },
    components: {
        FormButton,
        EditButton,
        DeleteButton,
        Notify
    },
    mounted() {
        this.user.name = this.initUser.name;
        this.user.email = this.initUser.email;
        this.user.contact_number = this.initUser.erp_user_details.contact_number;
        this.user.selected_factory_id = this.initUser.erp_user_details.factory_id;

        for (const [key, value] of Object.entries(this.roles)) {
            this.rolesArr.push(value.name);
        }
        for (const [key, value] of Object.entries(this.initUser.roles)) {
            this.user.selected_roles.push(value.name);
        }

        for (const [key, value] of Object.entries(this.factories)) {
            this.factoriesArr.push({
                id: value.id,
                label: value.name
            });
        }

        for (const [key, value] of Object.entries(this.initUser.factories)) {
            this.user.selected_factories.push(value.id);
        }


    },
    data() {
        return {
            user: {
                name: '',
                email: '',
                contact_number:'',
                selected_factory_id: '',
                selected_roles: [],
                selected_factories: []
            },
            rolesArr: [],
            factoriesArr: [],
            password:''
        }
    },
    methods: {
        updateUser(e) {
            e.preventDefault();
            this.$inertia.put('/users/'+this.initUser.id, this.user, {
                preserveScroll:true
            })
        },
        generatePassword(e) {
            e.preventDefault();
            let length = 8,
                charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789",
                initialVal = "";
            for (let i = 0, n = charset.length; i < length; ++i) {
                initialVal += charset.charAt(Math.floor(Math.random() * n));
            }
            this.password = initialVal;
        },
        savePassword(e) {
            e.preventDefault();
            this.$inertia.put('/users/'+this.initUser.id+'/reset-password', {
                password: this.password
            }, {
                preserveScroll:true
            })
        },
        deactivateUser(e) {
            e.preventDefault();
            this.$inertia.post('/users/deactivate', { user_id:this.initUser.id }, {
                preserveScroll:true
            })
        }
    }
}
</script>

<style>
.style-chooser .vs__dropdown-toggle {
    height: 38px;
}
</style>
