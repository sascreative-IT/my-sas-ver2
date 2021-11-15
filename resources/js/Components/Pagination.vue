<template>
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-3" v-if="links.length > 3">
    <div>
        <div class="flex flex-wrap justify-center -mb-1">
            <div v-for="(link, k) in links" :key="k">
                <div v-if="link.url === null"  class="mr-1 mb-1 px-4 py-1 text-sm leading-1 text-gray-400 border rounded" v-html="link.label" />
                <inertia-link v-else class="mr-1 mb-1 px-4 py-1 text-sm leading-1 border rounded hover:bg-gray-700 hover:border-transparent hover:text-white focus:border-gray-400 focus:text-gray-400" :class="{ 'bg-gray-700 text-white': link.active }" :href="link.url" v-html="link.label" />
            </div>
        </div>
    </div>
    </div>
</template>


<script>

export default {
    props: {
        links: Array,
    },
}
</script>
