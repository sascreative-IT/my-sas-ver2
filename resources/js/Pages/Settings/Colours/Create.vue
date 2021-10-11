<template>
    <settings-layout>
        <div>
            <h3 class="text-lg">Add Colour</h3>
            <div class="mt-5">
                <colour-form
                    :material-types="materialTypes"
                    :submit-button-disable="submitting"
                    @onSubmit="onSubmit"
                ></colour-form>
            </div>
        </div>
    </settings-layout>
</template>

<script>
import ColourForm from "@/Pages/Settings/Colours/ColourForm";
import SettingsLayout from "@/Pages/Settings/SettingsLayout";

export default {
    name: "Create",
    components: {
        ColourForm,
        SettingsLayout
    },
    props: {
        materialTypes: {
            required: true,
            type: Array
        }
    },
    data() {
        return {
            submitting: false,
        }
    },
    mounted() {
        // this.colour.type = this.materialTypes[0].type;
    },
    methods: {
        onSubmit(colour) {
            this.submitting = true;
            this.$inertia.post('/settings/colours', colour).then(function () {
                this.submitting = false;
            }).catch(error => {
                this.submitting = false;
                console.log(error);
            })
        }
    },
}
</script>

<style scoped>

</style>
