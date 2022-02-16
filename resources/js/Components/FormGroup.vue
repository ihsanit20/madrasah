<template>
    <div class="relative">
        <Label
            v-if="label"
            :value="label"
            class="absolute -top-1.5 left-2.5 bg-white px-0.5 leading-4 line-clamp-1"
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
