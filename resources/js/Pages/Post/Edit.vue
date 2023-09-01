<template>
    <Head title="Post" />

    <app-layout>
        <template #header> Edit Post </template>

        <div class="py-4">
            <form-component :data="data" module-action="update" />
        </div>
    </app-layout>
</template>

<script>
import { Head, Link } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/App.vue";
import FormComponent from "./Form.vue";

export default {
    components: {
        AppLayout,
        Head,
        Link,
        FormComponent,
    },

    data() {
        return {
            //
        };
    },

    props: {
        data: {
            type: Object,
            default: {},
        },
    },
};
</script>
