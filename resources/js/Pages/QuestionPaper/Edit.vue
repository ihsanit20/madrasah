<template>
    <Head title="Exam" />

    <app-layout pageTitle="Edit Exam">
        <form-component :data="data" module-action="update" />
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
    },
};
</script>
