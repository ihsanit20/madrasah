<template>
    <Head title="ভর্তি আবেদন ফরম" />

    <app-layout pageTitle="ভর্তি আবেদন ফরম">
        <form-component
            :data="data"
            :type="type"
            :student="old_student_id"
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
        type: {
            type: String,
            default: "new",
        },
        old_student_id: {
            type: Boolean,
            default: false,
        },
    },
};
</script>
