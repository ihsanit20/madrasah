<template>
    <button
        type="button"
        class="flex items-center justify-center gap-1 rounded border border-dashed border-gray-400 px-2 py-1 text-gray-500"
    >
        <PlusCircleIcon class="h-4 w-4" />
        <span class="-mb-1 text-sm">
            <slot>যোগ করুন</slot>
        </span>
    </button>
</template>

<script>
import { PlusCircleIcon } from "@heroicons/vue/outline";
export default {
    components: {
        PlusCircleIcon,
    },
};
</script>
