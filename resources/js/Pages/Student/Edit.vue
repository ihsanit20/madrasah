<template>
    <Head title="শিক্ষার্থী" />

    <app-layout pageTitle="শিক্ষার্থীর তথ্য ‍সম্পাদনা">
        <fee-component v-if="step === 'fee'" :data="data" module-action="update" />
        <form-component v-else :data="data" module-action="update" />
    </app-layout>
</template>

<script>
import { Head } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/GridApp.vue";
import FormComponent from "./Form.vue";
import FeeComponent from "./Fee.vue";

export default {
    components: {
        Head,
        AppLayout,
        FormComponent,
        FeeComponent,
    },

    props: {
        data: {
            type: Object,
            default: {},
        },
        step: {
            type: String,
            default: '',
        },
    },
};
</script>
