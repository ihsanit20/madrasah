<template>
    <Head title="ভর্তি আবেদন ফরম" />

    <app-layout pageTitle="ভর্তি আবেদন ফরম">
        <form-component
            :data="{ ...data, has_online_form, online_form }"
            :type="type"
            :student="old_student_id"
            module-action="store"
        />
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/GridApp.vue";
import { Head } from "@inertiajs/vue3";
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
            type: Number,
            default: 0,
        },
        has_online_form: {
            type: Boolean,
            default: false,
        },
        online_form: {
            type: Object,
            default: {},
        },
    },
};
</script>
