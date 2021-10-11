<template>
    <div class="bg-white overflow-hidden shadow-xl rounded-md border mt-5">
        <div class="bg-gray-500 pl-5 pt-2 pb-2 text-white">
            <h4>Order Information</h4>
        </div>

        <div class="p-5">
            <div class="shadow overflow-hidden sm:rounded-md">
                <div class="px-4 py-5 bg-white sm:p-6">
                    <div class="grid lg:grid-cols-4 md:grid-cols-1 sm:grid-cols-1 gap-4">
                        <div class="w-64">
                            <label class="text-base font-medium text-gray-700">
                                Sales Agent
                            </label>
                            <input
                                :placeholder="details.sales_agent"
                                disabled
                                class="h-10 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                type="text">
                        </div>

                        <div class="w-64">
                            <label class="text-base font-medium text-gray-700">
                                Customer Service Agent
                            </label>
                            <input
                                :placeholder="details.customer_service_agent"
                                disabled
                                class="h-10 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                type="text">
                        </div>

                        <div>
                            <label class="text-base font-medium text-gray-700">
                                Date
                            </label>
                            <div
                                class="focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                <input
                                    :placeholder="details.ordered_date"
                                    disabled
                                    class="h-10 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                    type="text">
                            </div>
                        </div>

                        <div>
                            <label class="text-base font-medium text-gray-700">
                                Order type
                            </label>
                            <div
                                class="focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                <input
                                    :placeholder="details.order_type"
                                    disabled
                                    class="h-10 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                    type="text">
                            </div>
                        </div>
                    </div>
                    <div class="grid lg:grid-cols-4 md:grid-cols-1 sm:grid-cols-1 gap-4 mt-6">
                        <div class="w-64">
                            <label class="text-base font-medium text-gray-700">
                                Factory
                            </label>
                            <input
                                :placeholder="details.factory"
                                disabled
                                class="h-10 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                type="text">
                        </div>
                        <div class="w-64">
                            <label class="text-base font-medium text-gray-700">
                                Production type
                            </label>
                            <input
                                :placeholder="details.production_type"
                                disabled
                                class="h-10 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                type="text">
                        </div>
                        <div class="w-64">
                            <label class="text-base font-medium text-gray-700">
                                Customer name
                            </label>
                            <input
                                :placeholder="details.customer_name"
                                disabled
                                class="h-10 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                type="text">
                        </div>
                        <div class="w-64">
                            <label class="text-base font-medium text-gray-700">
                                Teams/Clubs/Schools
                            </label>
                            <input
                                :placeholder="details.team_club_school"
                                disabled
                                class="h-10 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                type="text">
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</template>

<script>
export default {
    name: "OrderInfo",
    props: {
        details: {
            type: Object,
            required: true
        }
    }
}
</script>

<style scoped>

</style>
