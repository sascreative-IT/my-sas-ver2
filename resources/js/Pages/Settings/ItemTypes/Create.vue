<template>
    <settings-layout>
        <div>
            <h3 class="text-lg">Add Item Type</h3>
            <div class="mt-5">
                <form @submit.prevent="addItemType">
                    <div class="shadow overflow-hidden sm:rounded-md">
                        <div class="px-4 py-5 bg-white sm:p-6">
                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="name" class="block text-sm font-medium text-gray-700">Item Type Name</label>
                                    <input v-model="item_type.name" type="text" name="name" id="name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    <div v-if="$page.props.errors.name" class="error-notification">{{ $page.props.errors.name }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                            <inertia-link href="/settings/item-types" class="inline-flex justify-center text-sm font-medium rounded-md text-gray-900 mr-5">
                                Cancel
                            </inertia-link>

                            <button
                                type="submit"
                                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150"
                                :class="{'opacity-50': submitted}"
                            >
                                Add
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </settings-layout>
</template>

<script>
import SettingsLayout from "@/Pages/Settings/SettingsLayout";

export default {
    name: "Create",
    components: {
        SettingsLayout
    },
    data(){
        return {
            item_type:{
                name:''
            },
            submitted: false,
        }
    },
    methods: {
        addItemType() {
            this.submitted = true;
            this.item_type.name = this.item_type.name.toUpperCase();
            this.$inertia.post('/settings/item-types', this.item_type).then(function () {
                this.submitted = false;
            }).catch(error => {
                this.submitted = false;
                console.log(error);
            });
        }
    },
}
</script>

<style scoped>

</style>
