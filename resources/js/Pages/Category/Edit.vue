<template>
    <Head :title="$page.props.request.type === '2' ? 'ব্যয়ের খাত' : 'আয়ের খাত'" />

    <app-layout :pageTitle="$page.props.request.type === '2' ? 'ব্যয়ের খাত' : 'আয়ের খাত'">
        <form-component :data="data" module-action="update" />
    </app-layout>
</template>

<script>
import { Head } from "@inertiajs/inertia-vue3";
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
