<template>
    <div class="flex w-full justify-between">
        <div class="hidden items-center lg:flex">
            Showing {{ collections.meta.from }} to {{ collections.meta.to }} of
            {{ collections.meta.total }} results
        </div>
        <div class="hidden lg:flex" v-if="collections.meta.last_page > 1">
            <component
                :is="link.url ? 'Link' : 'div'"
                v-for="link in collections.meta.links"
                :key="link.index"
                :class="{
                    'bg-brand-600 border-brand-600 text-white': link.active,
                    'border-gray-300 bg-white text-gray-700': !link.active,
                }"
                class="ml-0.5 inline-flex items-center rounded-md border px-3.5 py-1.5 text-sm leading-5 focus:outline-none focus:ring-0"
                :href="link.url"
                v-html="link.label"
            />
        </div>
        <div
            class="flex w-full justify-between lg:hidden"
            v-if="collections.meta.last_page > 1"
        >
            <component
                :is="collections.links.prev ? 'Link' : 'div'"
                class="inline-flex items-center rounded-md border px-3.5 py-1.5 leading-5 focus:outline-none focus:ring-0"
                :href="collections.links.prev"
                v-html="`&laquo; Previous`"
            />
            <component
                :is="collections.links.next ? 'Link' : 'div'"
                class="inline-flex items-center rounded-md border px-3.5 py-1.5 leading-5 focus:outline-none focus:ring-0"
                :href="collections.links.next"
                v-html="`Next &raquo;`"
            />
        </div>
    </div>
</template>

<script>
import { Link } from "@inertiajs/vue3";
export default {
    components: {
        Link,
    },
    props: {
        collections: { type: Object, default: {} },
    },
};
</script>
