<template>
    <Head title="Staff" />

    <app-layout>
        <salary-component v-if="step === 'salary'" :data="data" />
        <complete-component v-else-if="step === 'complete'" :data="data" />
        <form-component v-else :data="data" module-action="update" />
    </app-layout>
</template>

<script>
import { Head } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/GridApp.vue";
import FormComponent from "./Form.vue";
import SalaryComponent from "./Salary.vue";
import CompleteComponent from "./Complete.vue";

export default {
    components: {
        Head,
        AppLayout,
        FormComponent,
        SalaryComponent,
        CompleteComponent,
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
