<template>
    <Head title="SMS Service" />

    <app-layout pageTitle="SMS Panel">
        <form-component :data="data" :step="step" module-action="update" />
    </app-layout>
</template>

<script>
import { Head } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/GridApp.vue";
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
        step: {
            type: String,
            default: 'New',
        }
    },
};
</script>
