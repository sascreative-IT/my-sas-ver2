<template>
    <transition name="slide-fade">
        <template v-if="flash && visible">

            <div v-if="flash.type == 'success'" class="fixed flex max-w-xs w-full mt-4 mr-4 top-0 right-0 bg-green-500 rounded-md shadow p-4">
                <div class="mr-2">
                    <i class="fas fa-check-circle" style='color: white'></i>
                </div>
                <div class="flex-1 text-white pl-2">
                    {{ flash.message }}
                </div>
                <div class="ml-2">
                    <button @click="visible = false"
                            class="align-top focus:outline-none focus:text-white">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                             xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <div v-if="flash.type == 'error'" class="fixed flex max-w-xs w-full mt-4 mr-4 top-0 right-0 bg-red-500 rounded-md shadow p-4">
                <div class="mr-2">
                    <i class="fas fa-check-circle" style='color: white'></i>
                </div>
                <div class="flex-1 text-white pl-2" v-if="flash.message">
                    {{ flash.message }}
                </div>
                <div class="flex-1 text-white pl-2" v-else>
                    An unexpected error occurred, please try again later!
                </div>
                <div class="ml-2">
                    <button @click="visible = false"
                            class="align-top focus:outline-none focus:text-white">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                             xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>



        </template>

    </transition>
</template>

<script>
export default {
    name: "Notify",
    props: {
        flash: Object
    },
    data() {
        return {
            visible: false,
            timeout: null,
        }
    },
    watch: {
        flash: {
            deep: true,
            handler() {
                if (this.flash.message != null) {
                    this.visible = true;

                    if (this.timeout || this.flash.message === "") {
                        clearTimeout(this.timeout);
                    }
                    this.timeout = setTimeout(() => this.visible = false, 2000);
                }
            }
        }
    },
    mounted() {
        if (this.flash.message !== null) {
            this.visible = true;
        }

    }
}
</script>

<style scoped>

.slide-fade-enter-active {
    transition: all .3s ease;
}

.slide-fade-leave-active {
    transition: all .8s cubic-bezier(1.0, 0.5, 0.8, 1.0);
}

.slide-fade-enter, .slide-fade-leave-to {
    transform: translateX(100px);
    opacity: 0;
}

.red-color {
    color:red;
}
</style>
