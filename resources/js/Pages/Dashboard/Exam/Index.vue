<template>
    <Head title="ড্যাশবোর্ড" />

    <app-layout :backHref="route('dashboard')">
        <div class="w-full grid gap-2 grid-cols-2 md:gap-4 md:grid-cols-3 lg:grid-cols-4">
            <GridViewCard
                :href="route('admit-card.index')"
                icon-class="fa-solid fa-address-card"
            >
                প্রবেশপত্র
            </GridViewCard>
            <GridViewCard
                :href="route('seat-plan.index')"
                icon-class="fa-solid fa-pager"
            > 
                আসন নং
            </GridViewCard>
            <GridViewCard
                :href="route('question-papers.exams')"
                icon-class="fa-solid fa-file-circle-question"
            >
                প্রশ্নপত্র
            </GridViewCard>
            <GridViewCard
                :href="route('results.exams')"
                icon-class="fa-solid fa-rectangle-list"
            > 
                ফলাফল
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
