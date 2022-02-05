<template>
    <Head title="Classes" />

    <app-layout :pageTitle="classes.name">
        <form-component :data="{ classes }" module-action="update" />
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
        classes: {
            type: Object,
            default: {},
        },
    },
};
</script>
