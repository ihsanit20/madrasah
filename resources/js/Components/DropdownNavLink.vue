<template>
    <div
        class="flex cursor-pointer items-center justify-between gap-4 py-1.5 text-sm font-medium text-gray-500 md:text-lg"
        :class="classes"
        @click="open = !open"
    >
        <div class="flex items-center gap-4">
            <slot />
        </div>
        <ChevronDownIcon
            class="hidden h-5 w-5 transition-all ease-linear md:block"
            :class="{ 'rotate-180': open }"
        />
    </div>
    <div
        class="flex flex-col items-center rounded bg-gray-100 md:items-start md:pl-4"
    >
        <slot name="items" v-if="open" />
    </div>
</template>

<script>
import { ChevronDownIcon } from "@heroicons/vue/outline";
export default {
    components: {
        ChevronDownIcon,
    },

    props: ["active"],

    created() {
        this.open = this.active;
    },

    data() {
        return {
            open: false,
        };
    },

    computed: {
        classes() {
            return this.active ? "text-sky-600" : "text-gray-500";
        },
    },
};
</script>
