<template>
    <Head title="ড্যাশবোর্ড" />

    <app-layout :backHref="route('dashboard')">
        <div class="w-full grid gap-2 grid-cols-2 md:gap-4 md:grid-cols-3 lg:grid-cols-4">
            <GridViewCard
                :href="route('payments.create')"
                icon-class="fa-solid fa-money-check-dollar"
            >
                শিক্ষার্থী রশিদ
            </GridViewCard>
            <GridViewCard
                :href="route('incomes.index')"
                icon-class="fa-solid fa-money-check"
            >
                অন্যান্য রশিদ
            </GridViewCard>
            <GridViewCard
                :href="route('payments.index')"
                icon-class="fa-solid fa-list"
            >
                রশিদ তালিকা
            </GridViewCard>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/GridApp.vue";
import { Head } from "@inertiajs/inertia-vue3";
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
