<template>
    <div class="text-sm font-medium text-gray-900">
        <div v-if="embUrl" class="h-48 lg:h-auto lg:w-48 flex-none bg-cover rounded-t lg:rounded-t-none lg:rounded-l text-center overflow-hidden">
            <img class="w-32" :src="embUrl" alt="uploaded-file-thumbnail">
        </div>
        <div class="p-2 flex flex-col justify-between leading-normal">
            <label class="bg-gray-300 w-52 hover:bg-gray-400 text-gray-800 py-2 px-4 rounded inline-flex items-center">
                <i class="fas fa-file-upload fa-lg"></i>
                <span class="pl-2">Upload the file</span>
                <input v-on:change="$emit('addArtworks',$event)" ref="sublimation_file" type="file"
                       class="opacity-0 w-2" name="sublimation_file"
                       id="sublimation_file">
            </label>
        </div>
    </div>
</template>

<script>
export default {
    name: "Embellishments",
    props: {
        embUrl: {
            type: Object
        }
    },
    data() {
        return {
            fileUploadUrl: ''
        }
    },
    computed: {
      // fileUrl() {
      //     return URL.createObjectURL(this.embFile);
      // }
    },
    methods: {
    }
}
</script>

<style scoped>

</style>
