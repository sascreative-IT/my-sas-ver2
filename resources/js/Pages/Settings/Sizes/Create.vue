<template>
    <settings-layout>
        <h3 class="text-lg">Sizes Create</h3>
        <div class="mt-5">
            <div>
                <div class="shadow overflow-hidden sm:rounded-md">
                    <div class="px-4 py-5 bg-white sm:p-6">
                        <div class="col-span-6 sm:col-span-3">
                            <label for="full_name" class="block text-sm font-medium text-gray-700">
                                Size/s <span class="text-xs">(Type and press enter then hit save)</span>:
                            </label>
                            <div class="py-2">
                                <el-tag
                                    :key="tag"
                                    v-for="tag in form.sizeTags"
                                    closable
                                    :disable-transitions="false"
                                    @close="handleClose(tag)">
                                    {{tag.name}}
                                </el-tag>
                                <el-input
                                    class="input-new-tag"
                                    v-if="inputVisible"
                                    v-model="inputValue"
                                    ref="saveTagInput"
                                    size="mini"
                                    @keyup.enter.native="handleInputConfirm"
                                    @blur="handleInputConfirm"
                                >
                                </el-input>
                                <el-button v-else class="button-new-tag" size="small" @click="showInput">+ New Size</el-button>
                            </div>
                        </div>
                    </div>
                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                        <inertia-link href="/settings/sizes" class="inline-flex justify-center text-sm font-medium rounded-md text-gray-900 mr-5">
                            Cancel
                        </inertia-link>

                        <button
                            :class="{'opacity-50': submitted}"
                            @click="addSizes"
                            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150"
                        >
                            Save
                        </button>
                    </div>
                </div>
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
    data() {
        return {
            form: {
                sizeTags: []
            },
            inputVisible: false,
            inputValue: '',
            submitted: false,
        };
    },
    methods: {
        handleClose(tag) {
            this.form.sizeTags.splice(this.form.sizeTags.indexOf(tag), 1);
        },

        showInput() {
            this.inputVisible = true;
            this.$nextTick(_ => {
                this.$refs.saveTagInput.$refs.input.focus();
            });
        },

        handleInputConfirm() {
            let inputValue = this.inputValue.toUpperCase();
            if (inputValue) {
                this.form.sizeTags.push({name: inputValue});
            }
            this.inputVisible = false;
            this.inputValue = '';
        },
        addSizes() {
            this.submitted = true;
            this.$inertia.post('/settings/sizes', this.form.sizeTags).then(function () {
                this.submitted = false;
            }).catch(error => {
                this.submitted = false;
            })
        }
    }
}
</script>

<style scoped>

</style>
