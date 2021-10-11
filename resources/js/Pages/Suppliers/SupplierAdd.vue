<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Add New Supplier
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <supplier-form
                        :crud-action="crudAction"
                        v-on:onCreate="onSubmit"
                    ></supplier-form>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import SupplierForm from '@/Pages/Suppliers/SupplierForm';

export default {
    name: "SupplierAdd",
    components: {
        SupplierForm
    },
    props: {
        crudAction: {
            required: true,
            type: String
        }
    },
    methods: {
        onSubmit(supplier) {
            this.$inertia.post('/suppliers', supplier).then(function ({data}) {
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
