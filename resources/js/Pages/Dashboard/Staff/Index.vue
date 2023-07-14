<template>
    <Head title="ড্যাশবোর্ড" />

    <app-layout :backHref="route('dashboard')">
        <div class="w-full grid gap-2 grid-cols-2 md:gap-4 md:grid-cols-3 lg:grid-cols-4">
            <GridViewCard
                :href="route('staff.index')"
                icon-class="fa-solid fa-users-line"
            >
                স্টাফ তালিকা
            </GridViewCard>
            <GridViewCard
                :href="route('staff-attendance-page')"
                icon-class="fa-solid fa-file-lines"
            > 
                শিক্ষক/স্টাফ হাজিরা
            </GridViewCard>
            <GridViewCard
                :href="route('staff.id-card')"
                icon-class="fa-solid fa-id-card-clip"
            > 
                পরিচয়পত্র
            </GridViewCard>
            <GridViewCard
                :href="route('staff-form.index')"
                icon-class="fa-solid fa-user-plus"
            > 
                নতুন নিয়োগ
            </GridViewCard>
            <GridViewCard
                :href="route('designations.index')"
                icon-class="fa-solid fa-users-rectangle"
            > 
                পদবি যুক্ত করুন
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
