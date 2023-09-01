<template>
    <section>
        <h2
            v-if="title"
            class="text-brand-600 mb-4 text-xl md:text-3xl text-center font-bold"
        >
            {{ title }}
        </h2>
        <slot />
    </section>
</template>

<script>
export default {
    props: {
        title: {
            type: String,
            default: "",
        },
    },
};
</script>
