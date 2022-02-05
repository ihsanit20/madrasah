<template>
    <div class="w-full flex">
        <Link :href="href" class="text-center cursor-pointer border border-blue-600 text-white hover:bg-blue-700 bg-blue-600 rounded-md px-3 py-1.5">
            + Add New
        </Link>
    </div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";

export default {
    components: {
        Link,
    },
    props: ['href']
}
</script>