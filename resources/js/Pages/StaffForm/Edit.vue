<template>
    <Head title="Staff" />

    <app-layout>
        <salary-component v-if="step === 'salary'" :data="data" />
        <form-component v-else :data="data" module-action="update" />
    </app-layout>
</template>

<script>
import { Head } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/App.vue";
import FormComponent from "./Form.vue";
import SalaryComponent from "./Salary.vue";

export default {
    components: {
        Head,
        AppLayout,
        FormComponent,
        SalaryComponent,
    },

    props: {
        data: {
            type: Object,
            default: {},
        },
        step: {
            type: String,
            default: "",
        },
    },
};
</script>
