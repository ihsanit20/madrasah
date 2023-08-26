<template>
    <Head title="টাকা জমার রশিদ" />

    <app-layout>
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
