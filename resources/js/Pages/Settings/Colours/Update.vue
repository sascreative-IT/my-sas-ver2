<template>
    <settings-layout>
        <div>
            <h3 class="text-lg">Update Colour</h3>
            <div class="mt-5">
                <colour-form
                    :material-types="materialTypes"
                    :init-colour="initColour"
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
    name: "Update",
    components: {ColourForm, SettingsLayout},
    props: {
        materialTypes: {
            required: true,
            type: Array
        },
        initColour: {
            required: true,
            type: Object
        }
    },
    data() {
        return {
            submitting: false,
        }
    },
    methods: {
        onSubmit(colour) {
            this.submitting = true
            this.$inertia.put('/settings/colours/' + this.initColour.id, colour).then(function ({data}) {
                this.submitting = false;
            }).catch(error => {
                this.submitting = false;
                console.log(error);
            })
        }
    }
}
</script>

<style scoped>

</style>
