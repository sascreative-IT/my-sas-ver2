<template>
    <div class="bg-white overflow-hidden shadow-xl rounded-md border mt-5">
        <div class="bg-gray-500 pl-5 pt-2 pb-2 text-white">
            <h4>Order items</h4>
        </div>

        <div class="p-5">
            <div class="shadow overflow-hidden sm:rounded-md">
                <div class="bg-white">

                    <div class="grid lg:grid-cols-1 md:grid-cols-1 sm:grid-cols-1">
                        <el-collapse accordion>
                            <el-collapse-item
                                :key="idx"
                                :name="item.style_code"
                                v-for="(item, idx) in items">
                                <template slot="title">
                                    <i class="el-icon-caret-right"></i>
                                    <p class="text-xl"> {{idx+1}}) {{ item.style_code }} <el-tag size="mini">Expand</el-tag></p>
                                </template>
                                <div>
                                    <el-tabs type="card">
                                        <el-tab-pane label="Info">
                                            <table class="min-w-full divide-y divide-gray-200">
                                                <thead class="bg-gray-50">
                                                <tr>
                                                    <th scope="col"
                                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Sport
                                                    </th>
                                                    <th scope="col"
                                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Unit price
                                                    </th>
                                                    <th scope="col"
                                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Total quantity
                                                    </th>
                                                    <th scope="col"
                                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Artwork cost
                                                    </th>
                                                    <th scope="col"
                                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Total Embellishment Cost
                                                    </th>
                                                    <th scope="col"
                                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Total Setup Cost
                                                    </th>
                                                    <th scope="col"
                                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Item Total
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody  class="bg-white divide-y divide-gray-200">
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ item.sport }}
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ item.unit_price }}
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ item.total_qty }}
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ item.artwork_cost }}
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ item.total_embellishment_cost }}
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ item.total_setup_cost }}
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ item.item_total }}
                                                        </div>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </el-tab-pane>
                                        <el-tab-pane label="Sizes">
                                            <table class="min-w-full divide-y divide-gray-200">
                                                <thead class="bg-gray-50">
                                                <tr>
                                                    <th scope="col"
                                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Size
                                                    </th>
                                                    <th scope="col"
                                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Quantity
                                                    </th>
                                                    <th scope="col"
                                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Price
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody class="bg-white divide-y divide-gray-200">
                                                <tr v-for="size in item.sizes">
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ size.size }}
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ size.qty }}
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ size.price }}
                                                        </div>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </el-tab-pane>
                                        <el-tab-pane label="Numbers">Numbers</el-tab-pane>
                                        <el-tab-pane label="Components">Components</el-tab-pane>
                                        <el-tab-pane label="Trim/Accessories">Accessories</el-tab-pane>
                                        <el-tab-pane label="Style Notes">Notes</el-tab-pane>
                                    </el-tabs>
                                </div>

                            </el-collapse-item>
                        </el-collapse>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "OrderItems",
    props: {
        items: {
            type: Array,
            required: true
        }
    }
}
</script>

<style scoped>

</style>
