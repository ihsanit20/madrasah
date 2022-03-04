<template>
    <div class="flex items-center gap-2">
        <div v-if="title" class="text-gray-700">{{ title }}</div>
        <div class="font-semibold text-gray-700">
            <slot>{{ value }}</slot>
        </div>
    </div>
</template>

<script>
export default {
    props: ["title", "value"],
};
</script>
