<template>
    <div class="relative">
        <Label
            v-if="label"
            :value="label"
            class="absolute -top-1 left-2 bg-white px-0.5 leading-3 line-clamp-1"
        />
        <slot />
    </div>
</template>

<script>
import Label from "@/Components/Label.vue";
export default {
    components: {
        Label,
    },
    props: ["label"],
};
</script>
