<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Update Supplier - {{ initSupplier.name }}
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <supplier-form
                    :crud-action="crudAction"
                    :init-supplier="initSupplier"
                    :contacts="contacts"
                    :countries="countries"
                    :materials="materials"
                    :colours="colours"
                    :materialSuppliers="materialSuppliers"
                    v-on:onUpdate="onSubmit"
                ></supplier-form>
            </div>
        </div>
    </app-layout>
</template>

<script>
import SupplierForm from "@/Pages/Suppliers/SupplierForm";

export default {
    name: "SupplierUpdate",
    components: {
        SupplierForm
    },
    props: {
        crudAction: {
            required: true,
            type: String
        },
        initSupplier: {
            required: true,
            type: Object
        },
        contacts: {
            required: true,
            type: Array
        },
        countries: {
            required: false,
            type: Array
        },
        materials: {
            required: false,
            type: Array
        },
        colours: {
            required: false,
            type: Array
        },
        materialSuppliers: {
            required: false,
            type: Array
        }
    },
    methods: {
        onSubmit(supplier) {
            this.$inertia.put('/suppliers/' + this.initSupplier.id, supplier).then(function ({data}) {
                console.log(data);
            }).catch(error => {
                console.log(error);
            })
        }
    }
}
</script>

<style scoped>

</style>
