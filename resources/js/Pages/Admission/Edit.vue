<template>
    <Head :title="pageTitle" />

    <app-layout>
        <form-component v-if="step === 1" :data="data" module-action="update" />
        <test-component v-if="step === 2" :data="data" module-action="update" />
        <fee-component v-if="step === 3" :data="data" module-action="update" />
        <complete-component
            v-if="step === 4"
            :data="data"
            module-action="update"
        />
        <class-edit-component v-if="step === 5" :data="data" module-action="update" />
    </app-layout>
</template>

<script>
import { Head } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/GridApp.vue";
import FormComponent from "./Form.vue";
import TestComponent from "./Test.vue";
import FeeComponent from "./Fee.vue";
import CompleteComponent from "./Complete.vue";
import ClassEditComponent from "./ClassEdit.vue";

export default {
    components: {
        Head,
        AppLayout,
        FormComponent,
        TestComponent,
        FeeComponent,
        CompleteComponent,
        ClassEditComponent,
    },

    created() {
        if (this.step == "2") {
            this.pageTitle = "ভর্তির যোগ্যতা যাচাই";
        }

        if (this.step == "3") {
            this.pageTitle = "প্রদেয় ফি নির্ধারণ";
        }
    },

    data() {
        return {
            pageTitle: "ভর্তি আবেদন ফরম",
        };
    },

    props: {
        data: {
            type: Object,
            default: {},
        },
        step: {
            type: Number,
            default: 1,
        },
    },
};
</script>
