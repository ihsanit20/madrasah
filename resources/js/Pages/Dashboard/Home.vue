<template>
    <Head title="ড্যাশবোর্ড" />

    <app-layout>
        <div class="w-full grid gap-2 grid-cols-2 md:gap-4 md:grid-cols-3 lg:grid-cols-4">
            <GridViewCard
                :href="route('dashboard.admission')"
                icon-class="fa-solid fa-person-circle-plus"
            >
                ভর্তি সংক্রান্ত
            </GridViewCard>
            <GridViewCard
                :href="route('students.class.index')"
                icon-class="fa-solid fa-people-roof"
            >
                শিক্ষার্থী তালিকা
            </GridViewCard>
            <GridViewCard
                :href="route('dashboard.income')"
                icon-class="fa-solid fa-file-invoice-dollar"
            >
                টাকা জমার রশিদ
            </GridViewCard>
            <GridViewCard
                :href="route('dashboard.expence')"
                icon-class="fa-solid fa-money-bills"
            >
                ব্যয় ও খরচ
            </GridViewCard>
            <GridViewCard 
                :href="route('dashboard.staff')" 
                icon-class="fa-solid fa-users-line">
                শিক্ষক ও স্টাফ
            </GridViewCard>
            <GridViewCard 
                :href="route('dashboard.exam')" 
                icon-class="fa-solid fa-clipboard-question">
                পরীক্ষা সংক্রান্ত
            </GridViewCard>
            <GridViewCard
                :href="route('dashboard.sms-panel')"
                icon-class="fa-solid fa-comment-sms"
            >
                SMS প্যানেল
            </GridViewCard>
            <GridViewCard
                :href="route('notices.index')"
                icon-class="fa-solid fa-clipboard-list"
            >
                নোটিশ
            </GridViewCard>
            <GridViewCard
                :href="route('dashboard.routine')"
                icon-class="fa-solid fa-table"
            >
                রুটিন
            </GridViewCard>
            <GridViewCard
                :href="route('summary')"
                icon-class="fa-solid fa-chart-simple"
            >
                রিপোর্ট সামারি
            </GridViewCard>
            <GridViewCard
                :href="route('dashboard.article')"
                icon-class="fa-solid fa-feather-pointed"
            >
                আর্টিকেল
            </GridViewCard>
            <GridViewCard
                :href="route('dashboard.setting')"
                icon-class="fa-solid fa-gear"
            >
                সেটিংস
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
