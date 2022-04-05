<template>
    <div class="flex flex-shrink flex-grow justify-end md:justify-center">
        <div
            class="flex cursor-pointer items-center gap-1 md:w-full md:max-w-xs md:rounded-full md:border md:px-3 md:py-1"
        >
            <SearchIcon class="h-5 w-5" />
            <span class="hidden flex-shrink flex-grow text-sm md:inline-block">
                Search...
            </span>
        </div>
    </div>
</template>

<script>
import { SearchIcon } from "@heroicons/vue/outline";
export default {
    components: {
        SearchIcon,
    },
};
</script>
