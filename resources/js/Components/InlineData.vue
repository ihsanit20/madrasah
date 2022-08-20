<template>
    <div class="flex items-center gap-2">
        <div v-if="title" class="text-gray-500 print:text-black">
            {{ title }}
        </div>
        <div class="font-semibold text-gray-700 print:text-black">
            <slot>{{ value }}</slot>
        </div>
    </div>
</template>

<script>
export default {
    props: ["title", "value"],
};
</script>
