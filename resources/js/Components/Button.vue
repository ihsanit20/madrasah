<template>
    <button
        :type="type"
        class="focus:shadow-outline-green inline-flex items-center rounded-md border border-transparent bg-brand-600 px-4 py-2 text-base font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-brand-600 focus:border-brand-700 focus:outline-none active:bg-brand-700"
    >
        <slot />
    </button>
</template>

<script>
export default {
    props: {
        type: {
            type: String,
            default: "submit",
        },
    },
};
</script>
