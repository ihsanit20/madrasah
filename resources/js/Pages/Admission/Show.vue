<template>
    <Head title="Student" />

    <app-layout>
        <div class="max-w-3xl rounded p-3 md:p-4">
            <div class="flex items-end justify-between gap-4 print:hidden">
                <h2
                    class="flex-shrink flex-grow text-xl font-bold leading-5 text-gray-700"
                >
                    ক্লাস/বিভাগ প্রিভিউ
                </h2>
                <print-button />
                <Link
                    :href="route('students.edit', data.student.id)"
                    class="flex flex-shrink-0 flex-grow-0 items-center justify-center gap-1 rounded bg-green-600 px-2.5 py-0.5 text-white"
                >
                    <PencilAltIcon class="w-5" />
                    <span class="hidden md:block">Edit</span>
                </Link>
            </div>
        </div>
        <div class="max-w-3xl rounded border bg-white p-3 shadow md:p-4">
            <letter-head :photoFrame="true" />
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
import LetterHead from "@/Templete/LetterHead.vue";
import PrintButton from "@/Components/PrintButton.vue";

export default {
    components: {
        AppLayout,
        Head,
        ActionButtonEdit,
        FormHeading,
        InlineData,
        LetterHead,
        PrintButton,
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
