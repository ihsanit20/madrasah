<template>
    <Head title="Staff Salary" />

    <app-layout>
        <form-component
            :data="data"
            :paid-purpose-ids="paidPurposeIds"
            module-action="store"
        />
    </app-layout>
</template>

<script>
import { Head } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/App.vue";
import FormComponent from "./Form.vue";

export default {
    components: {
        Head,
        AppLayout,
        FormComponent,
    },
    props: {
        data: {
            type: Object,
            default: {},
        },
        paid_purpose_ids: {
            type: Array,
            default: [],
        },
    },
    created() {
        this.paidPurposeIds = this.paid_purpose_ids.map((id) => Number(id));
    },
    data() {
        return {
            paidPurposeIds: [],
        };
    },
};
</script>
