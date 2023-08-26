<template>
    <Head title="ক্লাস/বিভাগ যোগ করুন" />

    <app-layout pageTitle="ক্লাস/বিভাগ যোগ করুন">
        <form-component :data="data" module-action="store" />
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
    },
};
</script>
