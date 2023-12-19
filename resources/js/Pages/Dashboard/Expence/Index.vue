<template>
    <Head title="ড্যাশবোর্ড" />

    <app-layout :backHref="route('dashboard')">
        <div
            class="grid w-full grid-cols-2 gap-2 md:grid-cols-3 md:gap-4 lg:grid-cols-4"
        >
            <GridViewCard
                :href="route('expenses.create')"
                icon-class="fa-solid fa-hand-holding-dollar"
            >
                সাধারণ ব্যয়
            </GridViewCard>
            <GridViewCard
                :href="route('expenses.index')"
                icon-class="fa-solid fa-list"
            >
                সাধারণ ব্যয় তালিকা
            </GridViewCard>
            <GridViewCard
                :href="route('staff.index')"
                icon-class="fa-solid fa-money-bill-transfer"
            >
                স্টাফ বেতন
            </GridViewCard>
            <GridViewCard
                :href="route('salaries.index')"
                icon-class="fa-solid fa-list"
            >
                স্টাফ বেতন তালিকা
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
