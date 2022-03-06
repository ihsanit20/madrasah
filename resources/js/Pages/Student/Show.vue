<template>
    <Head title="Student" />

    <app-layout pageTitle="View Student">
        <div class="max-w-2xl rounded border bg-white p-3 shadow md:p-4">
            <div class="flex items-end justify-end">
                <div class="flex items-center gap-2">
                    <action-button-edit
                        :href="route('students.edit', data.student.id)"
                    />
                </div>
            </div>
            <form-heading class="mb-2">Basic Information</form-heading>
            <div class="grid md:grid-cols-2">
                <inline-data
                    title="Student's Name :"
                    :value="data.student.name"
                />
                <inline-data
                    title="Gender :"
                    :value="data.student.genderText"
                />
                <inline-data
                    title="Date of Birth :"
                    :value="data.student.dateOfBirthWithFormat"
                />
                <inline-data
                    title="Bith Certificate :"
                    :value="data.student.birthCertificate"
                />
                <inline-data
                    title="Father's Name :"
                    :value="data.student.fatherInfo.name"
                />
                <inline-data
                    title="Father's Occupation :"
                    :value="data.student.fatherInfo.occupation"
                />
                <inline-data
                    title="Mother's Name :"
                    :value="data.student.motherInfo.name"
                />
                <inline-data
                    title="Mother's Occupation :"
                    :value="data.student.motherInfo.occupation"
                />
            </div>
            <form-heading class="mt-6 mb-2">Present Address</form-heading>
            <div class="grid md:grid-cols-2">
                <inline-data
                    title="Address :"
                    :value="data.student.presentAddress.value"
                />
                <inline-data
                    title="Area :"
                    :value="data.student.presentAddress.areaName"
                />
                <inline-data
                    title="District :"
                    :value="data.student.presentAddress.districtName"
                />
                <inline-data
                    title="Division :"
                    :value="data.student.presentAddress.divisionName"
                />
            </div>
            <form-heading class="mt-6 mb-2">Permanent Address</form-heading>
            <div class="grid md:grid-cols-2">
                <inline-data
                    title="Address :"
                    :value="data.student.permanentAddress.value"
                />
                <inline-data
                    title="Area :"
                    :value="data.student.permanentAddress.areaName"
                />
                <inline-data
                    title="District :"
                    :value="data.student.permanentAddress.districtName"
                />
                <inline-data
                    title="Division :"
                    :value="data.student.permanentAddress.divisionName"
                />
            </div>
            <form-heading class="mt-6 mb-2">Contact Information</form-heading>
            <div class="grid md:grid-cols-2">
                <inline-data
                    title="Father's Phone :"
                    :value="data.student.fatherInfo.phone"
                />
                <inline-data
                    title="Mother's Phone :"
                    :value="data.student.motherInfo.phone"
                />
                <inline-data
                    title="Guardian's Name :"
                    :value="data.student.guardianInfo.name"
                />
                <inline-data
                    title="Relation with student :"
                    :value="data.student.guardianInfo.relation"
                />
                <inline-data
                    title="Guardian's Phone :"
                    :value="data.student.guardianInfo.phone"
                />
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
    data() {
        return {
            columns: [
                { title: "Code", align: "left" },
                { title: "Name", align: "left" },
            ],
        };
    },
};
</script>
