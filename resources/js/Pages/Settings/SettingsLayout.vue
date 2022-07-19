<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Settings
            </h2>
        </template>

        <div class="py-12">
            <div class="flex max-w-7xl mx-auto sm:px-6 lg:px-8">

                <div class="w-2/12 flex flex-col">
                    <div class="mb-2 flex flex-col" v-for="category in categories">
                        <jet-nav-link
                            v-for="item in category"
                            :key="item.name"
                            class="font-semibold mb-1 text-gray-500 border-none text-base"
                            :class="{'ml-1 text-black': route().current(item.route)}"
                            :href="route(item.route)" :active="route().current(item.route)"
                        >
                            {{ item.name }}
                        </jet-nav-link>
                        <!--                      <div class="break" style="width:75%;"></div>-->
                    </div>

                    <div class="mb-2 flex flex-col">
                        <jet-nav-link
                            class="font-semibold mb-1 text-gray-500 border-none text-base"
                            :class="{'ml-1 text-black': route().current(route('settings.currencies.index'))}"
                            :href="route('settings.currencies.index')"
                            :active="route().current(route('settings.currencies.index'))"
                        >
                            Currencies
                        </jet-nav-link>
                    </div>

                    <div class="mb-2 flex flex-col">
                        <jet-nav-link
                            class="font-semibold mb-1 text-gray-500 border-none text-base"
                            :class="{'ml-1 text-black': route().current(route('settings.currency-exchange-rates.index'))}"
                            :href="route('settings.currency-exchange-rates.index')"
                            :active="route().current(route('settings.currency-exchange-rates.index'))"
                        >
                            Exchange Rates
                        </jet-nav-link>
                    </div>

                </div>

                <div class="w-10/12">
                    <jet-validation-errors
                        :nested-fields="nestedFields"
                        :nested-field-type="true"
                        class="mb-4" />
                    <slot></slot>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import JetNavLink from '@/Jetstream/NavLink'
import JetValidationErrors from '@/Jetstream/ValidationErrors'

export default {
    name: "SettingsLayout",
    components: {
        JetNavLink,
        JetValidationErrors
    },
    props: {
        nestedFields: {
            required: false,
            type: Array
        },
    },
    data() {
        return {
            categories: {
                main: [
                    {
                        name: 'Factories',
                        route: 'settings.factories.index',
                    },
                    {
                        name: 'Warehouses',
                        route: 'settings.warehouses.index',
                    }
                ],
                outlets: [
                    {
                        name: 'Outlets',
                        route: 'settings.outlets.index',
                    }
                ],
                materials: [
                    {
                        name: 'Material',
                        route: 'settings.materials.index'
                    }
                ],
                colours: [
                    {
                        name: 'Colour',
                        route: 'settings.colours.index'
                    }
                ],
                sizes: [
                    {
                        name: 'Sizes',
                        route: 'settings.sizes.index'
                    }
                ],
                style_categories: [
                    {
                        name: 'Style Categories',
                        route: 'settings.categories.index'
                    }
                ],
                item_types: [
                    {
                        name: 'Item Types',
                        route: 'settings.item-types.index'
                    }
                ],
            }
        }
    }
}
</script>

<style scoped>
.break {
    background-color: #dcdcdc;
    height: 1px;
}
</style>

<style>
.el-tag + .el-tag {
    margin-left: 10px;
}
.button-new-tag {
    margin-left: 10px;
    height: 32px;
    line-height: 30px;
    padding-top: 0;
    padding-bottom: 0;
}
.input-new-tag {
    width: 320px;
    vertical-align: bottom;
}
</style>
