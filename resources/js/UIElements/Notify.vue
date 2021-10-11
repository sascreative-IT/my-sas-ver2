<template>
    <transition name="slide-fade">

        <div v-if="flash && visible" class="fixed flex max-w-xs w-full mt-4 mr-4 top-0 right-0 bg-gray-500 rounded-md shadow p-4">
            <div class="mr-2">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="flex-1 text-gray-100 pl-2">
                {{ flash.message }}
            </div>
            <div class="ml-2">
                <button @click="visible = false" class="align-top text-gray-400 hover:text-gray-100 focus:outline-none focus:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                         xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

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
                this.visible = true;
                if(this.timeout || this.flash.message === "") {
                    clearTimeout(this.timeout);
                }
                this.timeout = setTimeout(() => this.visible = false, 2000);
            }
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

.slide-fade-enter, .slide-fade-leave-to
{
    transform: translateX(100px);
    opacity: 0;
}
</style>
