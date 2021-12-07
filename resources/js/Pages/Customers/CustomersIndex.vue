<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Customers 
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex flex-row-reverse">
                    <inertia-link class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150"
                        href="/customers/create">Add New Customer</inertia-link>
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
                                email
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                CS Agent
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Sales Agent
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Registered date
                            </th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Edit</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-if="customers.length > 0" v-for="customer in customers">
                            <td class="px-6 py-3 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ customer.name }}
                                </div>
                            </td>
                            <td class="px-6 py-3 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ customer.email }}
                                </div>
                            </td>
                            <td class="px-6 py-3 whitespace-nowrap">
                                <div v-if="customer.cs_agent" class="text-sm font-medium text-gray-900">
                                    {{ customer.cs_agent.name }}
                                </div>
                            </td>
                            <td class="px-6 py-3 whitespace-nowrap">
                                <div v-if="customer.sales_agent" class="text-sm font-medium text-gray-900">
                                    {{ customer.sales_agent.name }}
                                </div>
                            </td>
                            <td class="px-6 py-3 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    {{formatDate(customer.created_at)}}
                                </div>
                            </td>
                            <td class="px-6 py-3 whitespace-nowrap text-right text-sm font-medium">
                                <inertia-link
                                    class="inline-flex items-center px-4 py-1 border-gray-600 border hover:bg-gray-700 hover:border-transparent hover:text-white rounded-sm font-semibold text-xs text-black uppercase tracking-widest active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150"
                                :href="'/customers/' + customer.id +'/edit'"
                                >
                                    Edit
                                </inertia-link>
                            </td>
                        </tr>

                        <!-- More items... -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </app-layout>
</template>

<script>
export default {
    name: "CustomersIndex",
    props: {
        customers: {
            required: false,
            type: Array
        }
    },
    methods: {
        formatDate(date) {
            let convertedDate = new Date(date);
            return convertedDate.getFullYear()+'-' + (convertedDate.getMonth()+1) + '-'+convertedDate.getDate();
        },
    }
}
</script>

<style scoped>

</style>
