<template>
    <app-layout>
        <Notify :flash="$page.props.flash"></Notify>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Add New Customer
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <customer-add-form
                        :cs-agents="csAgents"
                        :sales-agents="salesAgents"
                        :logo-id="logoId"
                        v-on:onSubmit="addCustomer"
                    >
                    </customer-add-form>
                </div>
            </div>
        </div>

    </app-layout>
</template>

<script>
import CustomerAddForm from "@/Pages/Customers/Forms/CustomerAddForm";
import Notify from "@/UIElements/Notify";

export default {
    name: "CustomerAdd",
    components: {
        CustomerAddForm,
        Notify
    },
    props: {
        csAgents: {
            required: true,
            type: Array
        },
        salesAgents: {
            required: true,
            type: Array
        },
        logoId: {
            required: false,
            type: Number
        },
        flash: Object
    },
    methods: {
        addCustomer(customer) {
            this.$inertia.post('/customers', customer).then(function ({data}) {
                console.log(data);
            }).catch(error => {
                console.log(error);
            })
        },
    }
}
</script>

<style scoped>

</style>
