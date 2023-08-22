<template>
    <Head title="ড্যাশবোর্ড" />

    <app-layout
        :backHref="route('dashboard')"
    >
        <div class="w-full grid gap-2 grid-cols-2 md:gap-4 md:grid-cols-3 lg:grid-cols-4">
            <div class="col-span-full text-center text-2xl md:text-6xl bg-white h-96 rounded flex justify-center items-center text-brand-600">
                Coming Soon...
            </div>
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
