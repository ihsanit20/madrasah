<template>
    <Link
        :href="href"
        class="flex flex-col items-center overflow-hidden rounded bg-white p-3 shadow-sm md:p-6 lg:gap-2"
    >
        <div class="text-4xl text-orange-600 md:text-6xl">
            {{ counter }}
        </div>
        <div class="text-lg font-medium text-blue-900">
            <slot />
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
