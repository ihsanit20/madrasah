<template>
    <div class="aspect-square shrink-0 grow-0 overflow-hidden rounded-full">
        <img
            v-if="imageUrl"
            :src="imageUrl"
            class="h-full w-full"
            :alt="imageAlt"
        />
        <div
            v-if="!imageUrl && firstLatter"
            class="flex h-full w-full items-center justify-center object-cover"
        >
            {{ firstLatter }}
        </div>
    </div>
</template>

<script>
export default {
    components: {},
    props: {
        imageUrl: String,
        firstLatter: {
            type: String,
            default: "",
        },
        imageAlt: {
            type: String,
            default: "Photo",
        },
    },
};
</script>
