<template>
    <div
        class="grow-0 shrink-0 aspect-square rounded-full overflow-hidden"
    >
        <img
            v-if="imageUrl"
            :src="imageUrl"
            class="w-full h-full"
            :alt="imageAlt"
        />
        <div
            v-if="!imageUrl && firstLatter"
            class="w-full h-full object-cover flex justify-center items-center"
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
            default: '',
        },
        imageAlt: {
            type: String,
            default: 'Photo',
        },
    }
}
</script>