<template>
    <Head title="আর্টিকেল" />

    <app-layout
        :backHref="route('dashboard')"
    >
        <div class="w-full grid gap-2 grid-cols-2 md:gap-4 md:grid-cols-3 lg:grid-cols-4">
            <GridViewCard
                :href="route('posts.create')"
                icon-class="fa-solid fa-file-circle-plus"
                class="lg:col-start-2"
            >
                নতুন আর্টিকেল
            </GridViewCard>
            <GridViewCard
                :href="route('posts.index')"
                icon-class="fa-solid fa-list-check"
            >
                আর্টিকেল তালিকা
            </GridViewCard>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/GridApp.vue";
import { Head } from "@inertiajs/vue3";
import GridViewCard from "@/Components/GridViewCard.vue";

export default {
    components: {
        AppLayout,
        Head,
        GridViewCard,
    },
    props: {
        data: {
            type: Object,
            default: {},
        },
    },
};
</script>
