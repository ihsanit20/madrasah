<template>
    <Link
        v-if="href"
        :href="href"
        class="flex flex-col items-center overflow-hidden rounded bg-white p-3 shadow-sm md:p-6 lg:gap-2"
    >
        <div class="text-3xl text-orange-600 md:text-4xl">
            <font-awesome-icon :icon="iconClass" />
        </div>
        <div class="text-lg md:text-xl font-bold text-blue-900">
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
    props: ["iconClass", "href"],
};
</script>
