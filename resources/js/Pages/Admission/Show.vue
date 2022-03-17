<template>
    <Head title="Admission" />

    <app-layout pageTitle="View Admission">
        <div class="max-w-md rounded border bg-white p-3 shadow md:p-4">
            <div class="flex items-end justify-end">
                <div class="flex items-center gap-2">
                    <action-button-edit
                        :href="route('admissions.edit', data.admission.id)"
                    />
                </div>
            </div>
            <form-heading class="mb-2">Admission Info</form-heading>
            <div class="grid">
                <inline-data
                    title="Class :"
                    :value="data.admission.className"
                />
                <inline-data
                    title="Student :"
                    :value="data.admission.studentName"
                />
                <inline-data title="Roll :" :value="data.admission.roll" />

                <inline-data title="Year :" :value="data.admission.year" />

                <inline-data v-if="data.admission.resident" value="Resident" />
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/App.vue";
import { Head } from "@inertiajs/inertia-vue3";
import ActionButtonEdit from "@/Components/ActionButtonEdit.vue";
import FormHeading from "@/Components/FormHeading.vue";
import InlineData from "@/Components/InlineData.vue";

export default {
    components: {
        AppLayout,
        Head,
        ActionButtonEdit,
        FormHeading,
        InlineData,
    },
    props: {
        data: {
            type: Object,
            default: {},
        },
    },
};
</script>
