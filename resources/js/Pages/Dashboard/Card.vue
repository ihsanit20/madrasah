<template>
    <Link
        :href="href"
        class="flex items-center gap-4 overflow-hidden rounded bg-white shadow-sm md:p-4"
    >
        <div class="text-5xl text-gray-600">
            {{ counter }}
        </div>
        <div class="text-lg text-gray-500">
            <slot></slot>
        </div>
    </Link>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";
export default {
    components: {
        Link,
    },
    props: ["counter", "href"],
};
</script>
