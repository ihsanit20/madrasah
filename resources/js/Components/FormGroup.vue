<template>
    <div class="relative">
        <Label
            v-if="label"
            :value="label"
            class="bg-white px-0.5 line-clamp-1"
            :class="{ 'absolute -top-1 left-2 leading-3': absolute }"
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
    props: {
        label: {
            type: String,
            default: "",
        },
        absolute: {
            type: Boolean,
            default: false,
        },
    },
};
</script>
