<template>
    <app-layout>
        <Notify :flash="$page.props.flash"></Notify>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Users
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between">    
                <div class="w-2/4">
                    <inertia-link class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150"
                                  href="/users/create">Add User
                    </inertia-link>
                </div>
                <div class="flex-row-reverse">
                    <div class="relative text-gray-600 focus-within:text-gray-400">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-2">
                        <button type="submit" class="p-1 focus:outline-none focus:shadow-outline">
                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-6 h-6"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </button>
                    </span>
                        <input type="search" v-model="query" class="py-2 text-sm text-white rounded-md pl-10 focus:outline-none focus:bg-white focus:text-gray-900" placeholder="Search..." autocomplete="off" @input="searchUsers">
                    </div>
                </div>
            </div>    

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mt-5">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Name
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Email
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Contact number
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Factory
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Role
                            </th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Edit</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="user in users.data">
                            <td class="px-6 py-2 whitespace-nowrap text-sm text-gray-500">
                                {{ user.name }}
                            </td>
                            <td class="px-6 py-2 whitespace-nowrap text-sm text-gray-500">
                                {{ user.email }}
                            </td>
                            <td class="px-6 py-2 whitespace-nowrap text-sm text-gray-500">
                                {{ user.erp_user_details && user.erp_user_details.contact_number }}
                            </td>
                            <td class="px-6 py-2 whitespace-nowrap text-sm text-gray-500">
                                {{ user.erp_user_details && user.erp_user_details.factory.name }}
                            </td>
                            <td class="px-6 py-2 whitespace-nowrap text-sm text-gray-500">
                                <span v-for="role in user.roles" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                  {{role.name}}
                                </span>
                            </td>
                            <td class="px-6 py-2">
                                <a :href="'/users/' + user.id +'/edit'" class="inline-flex items-center px-4 py-1 border-gray-600 border hover:bg-gray-700 hover:border-transparent hover:text-white rounded-sm font-semibold text-xs text-black uppercase tracking-widest active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150">Edit</a>
                            </td>
                        </tr>

                        </tbody>
                    </table>
                    <paginator
                        :pagination="users"
                    ></paginator>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import Notify from "@/UIElements/Notify";
import Paginator from "@/UIElements/Paginator";

export default {
    props: {
        users: {
            required: true,
            type: Object
        },
        flash: {
            type:Object
        },
        q: {
            required: false,
            type: String
        }
    },
    components: {
        Notify,
        Paginator
    },
    data() {
        return {
            query: ''
        }
    },
    methods: {
        searchUsers() {
            this.$inertia.visit(this.$inertia.page.url, {
                preserveState: true,
                preserveScroll: true,
                data: {
                    q: this.query
                }
            })
        }
    }
}
</script>
