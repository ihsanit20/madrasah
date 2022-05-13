<template>
    <Head title="ড্যাশবোর্ড" />

    <app-layout>
        <div class="grid grid-cols-2 gap-2 md:gap-4 lg:grid-cols-3">
            <card
                :href="route('classes.index')"
                :counter="data.counter.classes"
            >
                ক্লাস/বিভাগ
            </card>
            <card
                :href="route('students.index')"
                :counter="data.counter.students"
            >
                শিক্ষার্থী
            </card>
            <card
                :href="route('admissions.index')"
                :counter="data.counter.admissions"
            >
                ভর্তির ফরম
            </card>
            <card
                :href="route('payments.new')"
                :counter="data.counter.payments"
            >
                টাকা জমার রশিদ
            </card>
            <card :href="route('staff.index')" :counter="data.counter.staff">
                শিক্ষক/স্টাফ
            </card>
            <card :href="route('admins.index')" :counter="data.counter.admins">
                Admin
            </card>
            <card
                :href="route('notices.index')"
                :counter="data.counter.notices"
            >
                নোটিশ বোর্ড
            </card>
            <card
                :href="route('expenses.index')"
                :counter="data.counter.expenses"
            >
                ব্যয়/খরচ
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
