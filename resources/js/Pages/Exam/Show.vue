<template>
    <Head title="পরীক্ষা" />

    <app-layout pageTitle="পরীক্ষা">
        <div class="max-w-xl rounded border bg-white p-3 shadow md:p-4">
            <div class="flex justify-end">
                <action-button-edit :href="route('exams.edit', data.exam.id)" />
            </div>
            <div class="grid gap-4">
                <form-heading>{{ data.exam.name }}</form-heading>
                <div class="flex items-center justify-center font-bold">
                    সেশন : {{ data.exam.session }}
                </div>
                <inline-data title="ক্লাস ‍সমূহ :" />
                <ul class="ml-4 grid list-disc md:grid-cols-3">
                    <li v-for="classes in data.exam.classes">
                        {{ classes.name }}
                    </li>
                </ul>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/App.vue";
import { Head } from "@inertiajs/inertia-vue3";
import ActionButtonEdit from "@/Components/ActionButtonEdit.vue";
import InlineData from "@/Components/InlineData.vue";
import FormHeading from "@/Components/FormHeading.vue";

export default {
    components: {
        AppLayout,
        Head,
        ActionButtonEdit,
        InlineData,
        FormHeading,
    },
    props: {
        data: {
            type: Object,
            default: {},
        },
    },
};
</script>
