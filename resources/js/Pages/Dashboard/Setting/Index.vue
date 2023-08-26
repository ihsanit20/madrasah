<template>
    <Head title="ড্যাশবোর্ড" />

    <app-layout :backHref="route('dashboard')">
        <div class="w-full grid gap-2 grid-cols-2 md:gap-4 md:grid-cols-3 lg:grid-cols-4">
            <GridViewCard
                :href="route('settings.site-setup')"
                icon-class="fa-solid fa-bars-progress"
            >
                সাইট সেটিং
            </GridViewCard>
            <GridViewCard
                :href="route('admins.index')"
                icon-class="fa-solid fa-users-gear"
            >
                এ্যাডমিন সেটিংস
            </GridViewCard>
            <GridViewCard
                :href="route('classes.index')"
                icon-class="fa-solid fa-users-rectangle"
            >
                ক্লাস সেটিংস
            </GridViewCard>
            <GridViewCard
                :href="route('fees.index')"
                icon-class="fa-solid fa-money-bill-wave"
            >
                প্রদেয় ফি
            </GridViewCard>
            <GridViewCard
                :href="route('purposes.index')"
                icon-class="fa-solid fa-money-bill-wave"
            >
                অন্যান্য বাবদ
            </GridViewCard>
            <GridViewCard
                :href="route('categories.index', [{ type: 1 }])"
                icon-class="fa-solid fa-folder-plus"
            >
                আয়ের খাত
            </GridViewCard>
            <GridViewCard
                :href="route('categories.index', [{ type: 2 }])"
                icon-class="fa-solid fa-folder-minus"
            >
                ব্যয়ের খাত
            </GridViewCard>
            <GridViewCard
                :href="route('exams.index')"
                icon-class="fa-solid fa-file-circle-plus"
            >
                পরীক্ষা সেটিং
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
