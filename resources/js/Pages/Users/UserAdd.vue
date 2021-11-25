<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create User
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <form>
                        <div class="shadow overflow-hidden sm:rounded-md">
                            <div class="px-4 py-5 bg-white sm:p-6">
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
                                        <v-select multiple class="style-chooser" v-model="user.selected_factories" label="name" :options="factoriesArr" :reduce="name => name.id" />
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="password"
                                               class="block text-sm font-medium text-gray-700">Password</label>
                                        <input type="password" name="password" id="password"
                                               v-model="user.password"
                                               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
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
                                        <v-select multiple class="style-chooser" v-model="user.selected_roles" :options="rolesArr" />
                                    </div>

                                </div>
                            </div>
                            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                <form-button
                                    type="button"
                                    @handle-on-click="saveUser"
                                >Save</form-button>
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

export default {
    props: {
        factories: {
            type: Array,
            required: true,
        },
        roles: {
            type: Array,
            required:true
        }
    },
    components: {
        FormButton
    },
    name: "UserAdd",
    mounted() {
        for (const [key, value] of Object.entries(this.roles)) {
            this.rolesArr.push(value.name);
        }

        for (const [key, value] of Object.entries(this.factories)) {
            this.factoriesArr.push({
                id: value.id,
                name: value.name
            });
        }
    },
    methods: {
        saveUser(e) {
            e.preventDefault();
            this.$inertia.post('/users',this.user);
        }
    },
    data() {
        return {
            rolesArr: [],
            factoriesArr: [],
            user: {
                name: '',
                email: '',
                password:'',
                contact_number: '',
                selected_factory_id: '',
                selected_roles: [],
                selected_factories: []
            }
        }
    }
}
</script>

<style>
.style-chooser .vs__dropdown-toggle {
    height: 38px;
}
</style>
