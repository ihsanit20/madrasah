<template>
    <Link
        :href="href"
        class="relative py-1.5 text-sm font-medium text-gray-500 md:text-lg"
        :class="classes"
    >
        <slot />
        <span
            v-if="newBadge"
            class="absolute -top-2 -left-3 -rotate-45 scale-75 rounded-md bg-rose-600 px-1.5 text-xs text-white md:top-2 md:-left-6"
        >
            New
        </span>
    </Link>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";

export default {
    components: {
        Link,
    },

    props: {
        href: {
            type: String,
            required: true,
        },
        active: {
            type: Boolean,
            default: false,
        },
        newBadge: {
            type: Boolean,
            default: false,
        },
    },

    computed: {
        classes() {
            return this.active ? "text-sky-600" : "text-gray-500";
        },
    },
};
</script>
