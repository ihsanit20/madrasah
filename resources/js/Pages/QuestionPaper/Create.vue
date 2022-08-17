<template>
    <Head title="প্রশ্নপত্র" />

    <app-layout pageTitle="নতুন প্রশ্নপত্র">
        <form-component :data="data" module-action="store" />
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
