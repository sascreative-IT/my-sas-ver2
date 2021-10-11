<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Factory order - #SAS301
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <order-info :details="this.order_info" />

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
                                        <div
                                            class="h-48 lg:h-auto lg:w-48 flex-none bg-cover rounded-t lg:rounded-t-none lg:rounded-l text-center overflow-hidden">
                                            <img class="w-64" :src="uploadedUrl" alt="uploaded-file-thumbnail">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <order-items :items="this.order_items" />

                <div class="bg-white overflow-hidden shadow-xl rounded-md border mt-5">
                    <div class="bg-gray-500 pl-5 pt-2 pb-2 text-white">
                        <h4>Payment information</h4>
                    </div>

                    <div class="p-5">
                        <div class="shadow overflow-hidden sm:rounded-md">
                            <div class="px-4 py-5 bg-white sm:p-6">
                                <div>
                                    <div class="flex flex-col">
                                        <div class="pb-6">
                                            <h4>Payment type</h4>
                                            <ul>
                                                <li>{{ payment_type }}</li>
                                            </ul>
                                        </div>
                                        <div class="pb-6">
                                            <h4>Payment terms</h4>
                                            <ul>
                                                <li>{{ payment_term }}</li>
                                            </ul>
                                        </div>
                                        <div class="pb-6">
                                            <h4>Sponsor code applied:</h4>
                                            <input
                                                disabled
                                                :placeholder="applied_sponser_code"
                                                class="h-9 w-64 mt-1 focus:ring-indigo-500 focus:border-indigo-500 block shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                type="text">
                                        </div>
                                    </div>
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
import Vue from "vue";
import OrderInfo from "@/Pages/Factory/Components/OrderInfo";
import OrderItems from "@/Pages/Factory/Components/OrderItems";

export default {
    name: "FactoryOrderShow",
    components: {
        OrderInfo,
        OrderItems
    },
    props: {},
    data() {
        return {
            uploadedUrl: 'https://sas.co.nz/wp-content/uploads/2020/11/Leavers-by-SAS-1536x1104.png',
            payment_type: 'Cash',
            payment_term: '50% deposit balance before shipping',
            applied_sponser_code: 'HGE123',
            order_info: {
                sales_agent: 'Adelia Pagac',
                customer_service_agent: 'Bethel Fisher',
                ordered_date: '6-28-2021',
                order_type: 'Direct',
                factory: 'SL Factory',
                production_type: 'Make',
                customer_name: 'John Doe',
                team_club_school: 'Pukekohe High School'
            },
            order_items: [
                {
                    style_code: 'SHTG 04K',
                    production: 'Cut & Sew',
                    sport: 'tag',
                    unit_price: '40',
                    total_qty: '14',
                    artwork_cost: '0.00',
                    total_embellishment_cost: '0.00',
                    total_setup_cost: '0.00',
                    item_total: '560.00',
                    sizes: [
                        {
                            size: '12K',
                            qty: '1',
                            price: '40'
                        },
                        {
                            size: '12K',
                            qty: '1',
                            price: '40'
                        }
                    ],
                    numbers: ['12K - Empty', 'S (Men\'s) - Empty'],
                    components: '',
                    trim_accessories: '',
                    style_notes: '1st Main Panel,Entire Garment,Light Dritech,As per artwrok Velcro,Left & Right Hips,N/A,White'
                },
                {
                    style_code: 'TEE 05K',
                    production: 'Sublimation',
                    sport: 'tag',
                    unit_price: '50',
                    total_qty: '14',
                    artwork_cost: '0.00',
                    total_embellishment_cost: '0.00',
                    total_setup_cost: '0.00',
                    item_total: '700.00',
                    sizes: [
                        {
                            size: '12K',
                            qty: '1',
                            price: '40'
                        },
                        {
                            size: '12K',
                            qty: '1',
                            price: '40'
                        }
                    ],
                    numbers: ['12K - Empty', 'S (Men\'s) - Empty'],
                    components: '',
                    trim_accessories: '',
                    style_notes: '1st Main Panel,Entire Garment,Light Dritech,As per artwrok Velcro,Left & Right Hips,N/A,White'
                }
            ],
        }
    },
}
</script>

<style scoped>

</style>
