<template>
    <Head title="Dashboard" />

    <app-layout pageTitle="Overview">
        <div class="grid grid-cols-2 gap-2 md:grid-cols-4 md:gap-4">
            <card
                :href="route('classes.index')"
                :counter="data.counter.classes"
            >
                Classes
            </card>
            <card
                :href="route('students.index')"
                :counter="data.counter.students"
            >
                Students
            </card>
            <card
                :href="route('admissions.index')"
                :counter="data.counter.admissions"
            >
                Admissions
            </card>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/App.vue";
import { Head } from "@inertiajs/inertia-vue3";
import Card from "./Card.vue";

export default {
    components: {
        AppLayout,
        Head,
        Card,
    },
    props: {
        data: {
            type: Object,
            default: {},
        },
    },
};
</script>
