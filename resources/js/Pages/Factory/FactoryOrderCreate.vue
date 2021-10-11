<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create a new factory order
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl rounded-md border mt-5">
                    <div class="bg-gray-500 pl-5 pt-2 pb-2 text-white">
                        <h4>Order placement details</h4>
                    </div>

                    <div class="p-5">
                        <div class="shadow overflow-hidden sm:rounded-md">
                            <div class="px-4 py-5 bg-white sm:p-6">
                                <div class="grid lg:grid-cols-4 md:grid-cols-1 sm:grid-cols-1 gap-4">
                                    <div class="w-64">
                                        <label class="text-base font-medium text-gray-700">
                                            Sales Agent
                                        </label>
                                        <app-select
                                          placeholder="Select Sales Person"
                                          no-match-text="No sale person found under given name"
                                          option-label="name"
                                          :filterable="true"
                                          option-value="id"
                                          :options="customerServiceAgents"
                                          v-model="form.sale_made_by.id"
                                        ></app-select>
                                    </div>

                                    <div class="w-64">
                                        <label class="text-base font-medium text-gray-700">
                                            Customer Service Agent
                                        </label>
                                        <app-select
                                          placeholder="Select Customer Service Person"
                                          no-match-text="No customer service person found under given name"
                                          option-label="name"
                                          :filterable="true"
                                          option-value="id"
                                          :options="customerServiceAgents"
                                          v-model="form.customer_service_by.id"
                                        ></app-select>
                                    </div>

                                    <div>
                                        <label class="text-base font-medium text-gray-700">
                                            Date
                                        </label>
                                        <div class="focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            <el-date-picker
                                                v-model="form.date"
                                                type="date"
                                                placeholder="Pick a date">
                                            </el-date-picker>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="bg-white overflow-hidden shadow-xl rounded-md border mt-5">
                    <div class="bg-gray-500 pl-5 pt-2 pb-2 text-white">
                        <h4>Order information</h4>
                    </div>

                    <div class="p-5">
                        <form>
                            <div class="shadow overflow-hidden sm:rounded-md">
                                <div class="px-4 py-5 bg-white sm:p-6">
                                    <div class="grid lg:grid-cols-2 md:grid-cols-1 sm:grid-cols-1 gap-4">
                                        <div class="w-64">
                                            <label class="text-base font-medium text-gray-700">
                                                Select factory
                                            </label>
                                            <app-select
                                              placeholder="Select Factory"
                                              no-match-text="No Factory found"
                                              option-label="name"
                                              :filterable="true"
                                              option-value="id"
                                              :options="factories"
                                              v-model="form.factory"
                                              @input="factorySelected"
                                            ></app-select>

                                        </div>
                                        <div class="w-64">
                                            <label for="order_style" class="text-base font-medium text-gray-700">
                                                Select order type
                                            </label>
                                            <app-select
                                              placeholder="Select Order Type"
                                              option-label="name"
                                              option-value="id"
                                              :options="[{id: 'direct', name: 'Direct'}]"
                                              v-model="form.type"
                                            ></app-select>
                                        </div>
                                    </div>
                                    <div class="grid lg:grid-cols-2 md:grid-cols-1 sm:grid-cols-1 gap-4 mt-5">
                                        <div class="w-64">
                                            <label for="production_type" class="text-base font-medium text-gray-700">
                                                Select production type
                                            </label>
                                            <app-select
                                              placeholder="Select Production Type"
                                              option-label="name"
                                              option-value="id"
                                              :options="[
                                                {id: 'make', name: 'Make'},
                                                {id: 'pickup', name: 'Pickup'},
                                              ]"
                                              v-model="form.production_requirement"
                                            ></app-select>
                                        </div>
                                        <div class="flex flex-col">
                                            <div class="w-64">
                                                <label class="text-base font-medium text-gray-700">
                                                    Select a customer
                                                </label>

                                                <app-select
                                                  placeholder="Select Customer"
                                                  option-label="name"
                                                  option-value="id"
                                                  :filterable="true"
                                                  :options="customers"
                                                  v-model="form.customer"
                                                ></app-select>
                                            </div>

                                            <div class="w-64 mt-5">
                                                <label class="text-base font-medium text-gray-700">
                                                    Teams/Clubs/Schools
                                                </label>
                                                <input
                                                    class="h-10focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                    type="text">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-xl rounded-md border mt-5">
                    <div class="bg-gray-500 pl-5 pt-2 pb-2 text-white">
                        <h4>Design attachment</h4>
                    </div>

                    <div class="p-5">
                        <div class="shadow overflow-hidden sm:rounded-md">
                            <div class="bg-white">
                                <div class="grid grid-cols-1">
                                    <div
                                        class="mt-1 pb-4 border-dotted h-48 rounded-lg border-dashed border-2 border-gray-400 flex justify-center items-center">
                                        <div v-if="fileUploadUrl"
                                             class="h-48 lg:h-auto lg:w-48 flex-none bg-cover rounded-t lg:rounded-t-none lg:rounded-l text-center overflow-hidden">
                                            <img class="w-32" :src="fileUploadUrl" alt="uploaded-file-thumbnail">
                                        </div>
                                        <div class="p-2 flex flex-col justify-between leading-normal">
                                            <label
                                                class="bg-gray-300 w-52 hover:bg-gray-400 text-gray-800 py-2 px-4 rounded inline-flex items-center">
                                                <i class="fas fa-file-upload fa-lg"></i>
                                                <span class="pl-2">Upload the file</span>
                                                <input v-on:change="onFileChange" ref="logo" type="file"
                                                       class="opacity-0 w-2" name="factory_design_attach"
                                                       id="factory_design_attach">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--                Add items -->
                <div class="bg-white overflow-hidden shadow-xl rounded-md border mt-5">
                    <div class="bg-gray-500 pl-5 pt-2 pb-2 text-white">
                        <h4>Add items</h4>
                    </div>

                    <div class="p-5">
                        <div class="shadow overflow-hidden sm:rounded-md">
                            <div v-if="item.style" class="px-4 py-5 bg-white sm:p-6">
                                <div class="grid md:grid-cols-1 sm:grid-cols-1 gap-4" :class="addItemsGrid">
                                    <div>
                                        <label class="text-base font-medium text-gray-700">
                                            Style code
                                        </label>
                                        <app-select
                                          placeholder="Select Style code"
                                          option-label="name"
                                          option-value="id"
                                          :filterable="true"
                                          :options="styles"
                                          v-model="item.style"
                                          @input="styleSelected"
                                        ></app-select>
                                    </div>
                                    <div>
                                        <label for="production" class="text-base font-medium text-gray-700">
                                            Production
                                        </label>
                                        <select
                                            name="production"
                                            v-model="item.production_requirement"
                                            id="production"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            <option value="cut_sew">Cut & Sew</option>
                                            <option value="sublimation">Sublimation</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="price" class="text-base font-medium text-gray-700">
                                            Price
                                        </label>
                                        <input
                                          v-model="item.price"
                                            id="price"
                                            type="text"
                                            class="h-9 mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    <div v-show="item.production_requirement !== 'cut_sew'">
                                        <label for="production" class="text-base font-medium text-gray-700">
                                            Embellishment
                                        </label>
                                        <div class="mt-1">
                                            <el-select
                                                @remove-tag="handleEmbellishmentDeselect"
                                                @change="handleEmbellishmentSelect"
                                                v-model="add_items.embellishment"
                                                multiple placeholder="Select">
                                                <el-option
                                                    v-for="item in embellishment_options"
                                                    :key="item"
                                                    :label="item"
                                                    :value="item">
                                                </el-option>
                                            </el-select>
                                        </div>
                                    </div>
                                </div>

                                <div class="grid lg:grid-cols-1 md:grid-cols-1 sm:grid-cols-1">
                                        <div class="mt-10">
                                            <el-tabs type="card">
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
                                                            <td v-if="size" class="px-6 py-4 whitespace-nowrap">
                                                                <div class="text-sm font-medium text-gray-900">
                                                                    {{ size.name  }}
                                                                </div>
                                                            </td>
                                                            <td v-if="size" class="px-6 py-4 whitespace-nowrap">
                                                                <div class="text-sm font-medium text-gray-900">
                                                                    <input
                                                                      v-model="size.quantity"
                                                                      @input="itemSizeQuantityChanged(size)"
                                                                      class="h-9 w-full mt-1 focus:ring-indigo-500 focus:border-indigo-500 block shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                                      type="number"
                                                                    >
                                                                </div>
                                                            </td>
                                                            <td v-if="size" class="px-6 py-4 whitespace-nowrap">
                                                                <div class="text-sm font-medium text-gray-900">
                                                                    <input
                                                                        v-model="size.price"
                                                                        class="h-9 w-full mt-1 focus:ring-indigo-500 focus:border-indigo-500 block shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                                        type="number">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </el-tab-pane>
                                                <el-tab-pane label="Numbers">
                                                    <div class="flex flex-col">
                                                        <div>
                                                            <el-checkbox v-model="with_names">With names</el-checkbox>
                                                        </div>
                                                        <div class="mt-10" >
                                                            <table class="min-w-full divide-y divide-gray-200">
                                                                <thead class="bg-gray-50">
                                                                <tr>
                                                                    <th scope="col"
                                                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                                        Size
                                                                    </th>
                                                                    <th scope="col"
                                                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                                        Number
                                                                    </th>
                                                                    <th v-if="with_names" scope="col"
                                                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                                        Name
                                                                    </th>
                                                                </tr>
                                                                </thead>
                                                                <tbody v-for="size in  item.sizes" class="bg-white divide-y divide-gray-200">
                                                                    <tr v-if="size" v-for="addition in size.additions">
                                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                                            <div class="text-sm font-medium text-gray-900">
                                                                                {{ size.name }}
                                                                            </div>
                                                                        </td>
                                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                                            <div class="text-sm font-medium text-gray-900">
                                                                                <input
                                                                                  v-model="addition.number"
                                                                                  type="number"
                                                                                  class="h-9 w-64 mt-1 focus:ring-indigo-500 focus:border-indigo-500 block shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                                                >
                                                                            </div>
                                                                        </td>
                                                                        <td v-if="with_names" class="px-6 py-4 whitespace-nowrap">
                                                                            <div class="text-sm font-medium text-gray-900">
                                                                                <input v-model="addition.name" type="text"
                                                                                       class="h-9 w-64 mt-1 focus:ring-indigo-500 focus:border-indigo-500 block shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </el-tab-pane>
                                                <el-tab-pane label="Components">
                                                    <div class="flex flex-col">
                                                        <div>
                                                            <table class="min-w-full divide-y divide-gray-200" >
                                                                <thead class="bg-gray-50">
                                                                <tr>
                                                                    <th scope="col"
                                                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                                        Panel
                                                                    </th>
                                                                    <th scope="col"
                                                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                                        Fabric
                                                                    </th>
                                                                    <th scope="col"
                                                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                                        Colour
                                                                    </th>
                                                                </tr>
                                                                </thead>
                                                                <tbody class="bg-white divide-y divide-gray-200">
                                                                <tr :key="index" v-for="(panel, index) in item.panels">
                                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                                        <div class="text-sm font-medium text-gray-900">
                                                                            {{panel.panel.name}}
                                                                        </div>
                                                                    </td>
                                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                                        <div class="text-sm font-medium text-gray-900">
                                                                            <app-select
                                                                              :options="panel.panel.fabrics"
                                                                              option-value="id"
                                                                              option-label="name"
                                                                               v-model="panel.fabric"
                                                                              @input="fabricSelected"
                                                                            ></app-select>
                                                                        </div>
                                                                    </td>
                                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                                        <div class="text-sm font-medium text-gray-900">
                                                                            <el-select
                                                                              class="w-full"
                                                                              v-model="panel.fabric_variation"
                                                                              @input="fabricSelected"
                                                                            >
                                                                                <el-option
                                                                                  v-for="option in panel.fabric.variations"
                                                                                  :key="option.id"
                                                                                  :label="option.colour.name"
                                                                                  :value="option.id">
                                                                                </el-option>
                                                                            </el-select>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </el-tab-pane>
                                                <el-tab-pane label="Trim/Accessories">

                                                </el-tab-pane>
                                                <el-tab-pane label="Style notes">
                                                    <textarea class="ml-2 resize-none w-1/2 h-32 mt-1 focus:ring-indigo-500 focus:border-indigo-500 block shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
                                                </el-tab-pane>
                                                <el-tab-pane label="Sublimation" :disabled="add_items.production === 'cut_sew' || add_items.production === ''">
                                                    <div class="flex flex-col" v-show="add_items.production === 'sublimation'">
                                                        <div>
                                                            <el-checkbox v-model="add_items.current_artwork">Current artwork</el-checkbox>
                                                        </div>
                                                        <div v-show="add_items.current_artwork === false">
                                                            <div class="py-6">
                                                                <button
                                                                    class="float-right inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150"
                                                                >Add item</button>
                                                            </div>
                                                            <table class="min-w-full divide-y divide-gray-200">
                                                                <thead class="bg-gray-50">
                                                                <tr>
                                                                    <th scope="col"
                                                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                                        Setup cost
                                                                    </th>
                                                                    <th scope="col"
                                                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                                        Note
                                                                    </th>
                                                                    <th scope="col"
                                                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                                        Design reference
                                                                    </th>
                                                                    <th scope="col"
                                                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                                        Design file
                                                                    </th>
                                                                </tr>
                                                                </thead>
                                                                <tbody class="bg-white divide-y divide-gray-200">
                                                                <tr>
                                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                                        <div class="text-sm font-medium text-gray-900">
                                                                            <input
                                                                                class="h-9 w-64 mt-1 focus:ring-indigo-500 focus:border-indigo-500 block shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                                                type="number">
                                                                        </div>
                                                                    </td>
                                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                                        <div class="text-sm font-medium text-gray-900">
                                                                            <input
                                                                                class="h-9 w-64 mt-1 focus:ring-indigo-500 focus:border-indigo-500 block shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                                                type="text">
                                                                        </div>
                                                                    </td>
                                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                                        <div class="text-sm font-medium text-gray-900">
                                                                            <input
                                                                                class="h-9 w-64 mt-1 focus:ring-indigo-500 focus:border-indigo-500 block shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                                                type="text">
                                                                        </div>
                                                                    </td>
                                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                                        <div class="text-sm font-medium text-gray-900">
                                                                            <div v-if="add_items.sublimation_file_urls[0]" class="h-48 lg:h-auto lg:w-48 flex-none bg-cover rounded-t lg:rounded-t-none lg:rounded-l text-center overflow-hidden">
                                                                                <img class="w-32" :src="add_items.sublimation_file_urls[0]" alt="uploaded-file-thumbnail">
                                                                            </div>
                                                                            <div class="p-2 flex flex-col justify-between leading-normal">
                                                                                <label class="bg-gray-300 w-52 hover:bg-gray-400 text-gray-800 py-2 px-4 rounded inline-flex items-center">
                                                                                    <i class="fas fa-file-upload fa-lg"></i>
                                                                                    <span class="pl-2">Upload the file</span>
                                                                                    <input v-on:change="onSublimationUploadChange" ref="sublimation_file" type="file"
                                                                                           class="opacity-0 w-2" name="sublimation_file"
                                                                                           id="sublimation_file">
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </el-tab-pane>
                                                <el-tab-pane v-for="(item, idx) in add_items.embellishment" :key="item" :label="item">
                                                    <embellishments
                                                        :emb-url="add_items.embellishment_file_urls[item]"
                                                        @addArtworks="(...args) => handleEmbellishmentUploads(item, ...args)"
                                                    ></embellishments>
                                                </el-tab-pane>
                                            </el-tabs>

                                            <div class="py-6">
                                                <button
                                                  @click="addItem"
                                                  class="float-right inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150"
                                                >Add item</button>
                                            </div>
                                        </div>
                                    </div>


                                <div class="grid md:grid-cols-1 sm:grid-cols-1 gap-4">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Style Name
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody  class="bg-white divide-y divide-gray-200">
                                        <tr v-for="item in form.items">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ item.style.name }}
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!--                Payments -->
                <div class="bg-white overflow-hidden shadow-xl rounded-md border mt-5">
                    <div class="bg-gray-500 pl-5 pt-2 pb-2 text-white">
                        <h4>Payments</h4>
                    </div>

                    <div class="p-5">
                        <div class="shadow overflow-hidden sm:rounded-md">
                            <div class="px-4 py-5 bg-white sm:p-6">
                                <div>
                                    <div class="flex flex-col">
                                        <div class="pb-6">
                                            <h4>Payment type</h4>
                                            <ul>
                                                <li><el-checkbox >Cash</el-checkbox></li>
                                            </ul>
                                        </div>
                                        <div class="pb-6">
                                            <h4>Payment terms</h4>
                                            <ul>
                                                <li><el-radio label="half_deposit" v-model="payments.payment_terms">50% deposit balance before shipping</el-radio></li>
                                                <li><el-radio label="cash_account" v-model="payments.payment_terms">Cash account full payment before starting goods</el-radio></li>
                                            </ul>
                                        </div>
                                        <div class="pb-6">
                                            <h4>Sponsor code</h4>
                                            <input
                                                v-model="payments.sponsor_code"
                                                class="h-9 w-64 mt-1 focus:ring-indigo-500 focus:border-indigo-500 block shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-xl rounded-md border mt-5">
                    <div class="p-5">
                        <div class="overflow-hidden sm:rounded-md">
                            <div class="bg-white flex flex-row-reverse">
                                <div>
                                    <button
                                      @click.prevent="saveOrder"
                                    class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150">
                                        Save order
                                    </button>
                                </div>
                                <div class="px-2">
                                    <button
                                    class="inline-flex items-center px-4 py-2 border-gray-800 border hover:bg-gray-700 hover:border-transparent hover:text-white rounded-md font-semibold text-xs text-black uppercase tracking-widest active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150">
                                        Cancel
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import SelectMenu from "@/UIElements/SelectMenu";
import Embellishments from "@/Pages/Factory/Embellishments";
import Vue from "vue";
import AppSelect from "@/UIElements/AppSelect";
import AppTable from "@/UIElements/AppTable";

export default {
    name: "FactoryOrderCreate",
    components: {
        AppTable,
        AppSelect,
        SelectMenu,
        Embellishments
    },
    props: {
        factories: {
            type: Array,
            required: true
        },
        customers: {
            type: Array,
            required: true
        },
        customerServiceAgents: {
            type: Array,
            required: true
        },
        categories: {
            required: true,
            type: Array,
        },
        styles: {
            required: true,
            type: Array,
        },
        selectedStyleDetails: {
            required: false,
            default: null,
            type: Object
        },
        selectedStyleFabrics: {
            required: false,
            default: null,
            type: Object
        }
    },
    computed: {
        addItemsGrid() {
            return {
                'lg:grid-cols-4': this.add_items.production === 'sublimation' || this.add_items.production === '',
                'lg:grid-cols-5': this.add_items.production === 'cut_sew'
            }
        },
        additions() {
            return this.item.sizes.map(size => {
                return size.additions.map(addition => {
                    return addition
                })
            })
        }
    },
    watch: {
        selectedStyleDetails: {
            immediate: true,
            handler(styleDetails) {
                this.item.sizes = [];
                if (styleDetails) {
                    styleDetails.sizes.forEach((size, index) => {
                        this.item.sizes[index] = {
                            id: size.id,
                            name: size.name,
                            quantity: 0,
                            price: this.item.price ?? 0,
                            additions: [],
                        }
                    })

                    this.item.panels = [];
                    styleDetails.panels.forEach((panel, index) => {
                        this.item.panels[index] = {
                            id: panel.id,
                            panel: panel,
                            fabric: {variations: []},
                            fabric_variation: null
                        }
                    })
                }

            }
        },
    },
    data() {
        return {
            item: {
                style: {},
                production_requirement: null,
                sizes: [],
                panels: [],
                price: 0,
            },
            form: {
                items: [],
                customer: {},
                factory: {},
                sale_made_by: {},
                customer_service_by: {}
            },
            customer_options: [],
            selected_customer: {},
            fileUploadUrl: null,
            embellishment_options: [
                'Heat Transfer',
                ' Screen Print ',
                ' Embroidery ',
                ' Applique ',
                ' Tackle Twill ',
                ' Partial Sublimation ',
                ' Patch ',
            ],
            uploads: {
                file: ''
            },
            cut_sew_components: [
                { paneling_detail: 'Main Body', fabric: 'Mid Dritech (Jongstit)', color: ['Blue','Red','Yellow'] },
                { paneling_detail: 'Sleeve', fabric: 'Mid Dritech (Jongstit)', color: ['Blue','Red','Yellow'] },
                { paneling_detail: 'Crew Neck Collar', fabric: 'Mid Dritech (Jongstit)', color: ['Blue','Red','Yellow'] },
            ],
            sublimation_components: [
                { paneling_detail: 'Main Body', fabric: 'Mid Dritech (Jongstit)' }
            ],
            with_names: false,
            add_items: {
                category: '',
                style_code: '',
                production: '',
                price: '',
                embellishment: [],
                current_artwork: false,
                sublimation_file_urls: [],
                sublimation_files:[],
                embellishment_file_urls:{},
                embellishment_files: {}
            },
            sales_details: {
                date: ''
            },
            payments: {
                payment_type:'',
                payment_terms:'',
                sponsor_code:''
            },
            show_embellishment_url:false
        }
    },
    methods: {
        saveOrder() {
            // this.$inertia.post('/factory/order', this.form)
        },
        addItem() {
            this.form.items.push(this.item)
        },
        fabricSelected() {
            this.$forceUpdate();
        },
        itemSizeQuantityChanged(size) {
            console.log('size changed', size)
            size.additions = [];
            for (let i =0; size.quantity > i; i++) {
                size.additions[i] = {
                    number: null,
                    name: null
                }
            }
            this.$forceUpdate();
        },
        styleSelected() {
            console.log('selected')
            this.$inertia.visit(this.$inertia.page.url, {
                preserveState: true,
                preserveScroll: true,
                data: {
                    style_id: this.item.style.id
                }
            })
        },
        factorySelected() {
            console.log(this.form.factory.id);
            this.$inertia.visit(this.$inertia.page.url, {
                preserveState: true,
                preserveScroll: true,
                data: {
                    factory_id: this.form.factory.id
                }
            })
        },
        onFileChange(e) {
            this.uploads.file = e.target.files[0];
            const isUploaded = e.target.files.length;

            if (isUploaded !== 0) {
                this.fileUploadUrl = URL.createObjectURL(this.uploads.file);
            } else {
                this.uploads.file = '';
                this.fileUploadUrl = '';
            }

        },
        onSublimationUploadChange(e) {
            this.add_items.sublimation_files.push(e.target.files[0])

            if (e.target.files.length !== 0) {
                this.add_items.sublimation_file_urls[0] = URL.createObjectURL(this.add_items.sublimation_files[0]);
            } else {
                this.add_items.sublimation_files[0] = '';
                this.add_items.sublimation_file_urls[0] = ''
            }

        },
        handleEmbellishmentSelect(e) {

        },
        handleEmbellishmentDeselect(e) {

        },
        handleEmbellishmentUploads(item, e) {
            let embFile = e.target.files[0];
            this.add_items.embellishment_files[item] = embFile;
            Vue.set(this.add_items.embellishment_file_urls,item,URL.createObjectURL(embFile))
            console.log(this.add_items.embellishment_file_urls);
        },
        getCurrentDate() {
            let today = new Date();
            let dd = String(today.getDate()).padStart(2, '0');
            let mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
            let yyyy = today.getFullYear();
            today = yyyy + '-' + mm + '-' + dd;

            return today;
        }
    },
    mounted() {
        console.log(this.$inertia)
        for (let key in this.customers) {
            if (this.customers.hasOwnProperty(key)) {
                this.customer_options.push(this.customers[key]);
            }
        }

        this.sales_details.date = this.getCurrentDate()
    }
}
</script>

<style>
.style-chooser .vs__dropdown-toggle {
    height: 38px;
}
</style>
