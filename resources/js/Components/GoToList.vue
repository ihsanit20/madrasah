<template>
    <span
        @click="goBack"
        class="text-center font-bold cursor-pointer border border-brand-600 text-brand-600 hover:bg-brand-600 hover:text-white px-3 py-1.5 rounded-xl"
    >
        {{ value }}
    </span>
</template>

<script>
export default {
    props: {
        href: {
            type: String,
            default: "#",
        },
        value: {
            type: String,
            default: "Go to list",
        },
        history: {
            type: Boolean,
            default: true,
        },
    },
    methods: {
        goBack() {
            this.$inertia.get(
                this.history
                    ? localStorage.getItem("historyOfList") || this.href
                    : this.href
            );
        },
    },
};
</script>
