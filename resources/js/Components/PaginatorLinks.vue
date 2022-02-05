<template>
    <div class="w-full flex justify-between">
        <div class="hidden lg:flex items-center">
            Showing {{ collections.meta.from }} to {{ collections.meta.to }} of {{ collections.meta.total }} results
        </div>
        <div class="hidden lg:flex" v-if="collections.meta.last_page > 1">
            <Link v-for="link in collections.meta.links" :key="link.index" :class="{ 'bg-blue-600 text-white border-blue-600' : link.active, 'bg-white text-gray-700 border-gray-300' : ! link.active }" class="inline-flex items-center ml-0.5 px-3.5 py-1.5 text-sm border leading-5 rounded-md focus:outline-none focus:ring-0" :href="link.url" v-html="link.label" />
        </div>
        <div class="w-full flex justify-between lg:hidden" v-if="collections.meta.last_page > 1">
            <Link class="inline-flex items-center px-3.5 py-1.5 border leading-5 rounded-md focus:outline-none focus:ring-0" :href="collections.links.prev" v-html="`&laquo; Previous`" />
            <Link class="inline-flex items-center px-3.5 py-1.5 border leading-5 rounded-md focus:outline-none focus:ring-0" :href="collections.links.next" v-html="`Next &raquo;`" />
        </div>
    </div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";
export default {
    components: {
        Link,
    },
    props: {
        collections: { type: Object, default: {} },
    },
}
</script>