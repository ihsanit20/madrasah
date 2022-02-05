<template>
    <Head title="Doctor" />

    <app-layout pageTitle="Create Classes">
        <form-component :data="{ classes }" module-action="store" />
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
