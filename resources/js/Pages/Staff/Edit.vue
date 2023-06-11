<template>
    <Head title="Staff" />

    <app-layout>
        <salary-component v-if="step === 'salary'" :data="data" />
        <education-component v-else-if="step === 'education'" :data="data" />
        <form-component v-else-if="step === 'basic'" :data="data" module-action="update" />
    </app-layout>
</template>

<script>
import { Head } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/App.vue";
import FormComponent from "./Form.vue";
import SalaryComponent from "./Salary.vue";
import EducationComponent from "./Education.vue";

export default {
    components: {
        Head,
        AppLayout,
        FormComponent,
        SalaryComponent,
        EducationComponent,
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
