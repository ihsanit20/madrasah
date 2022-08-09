<template>
    <Head title="Student" />

    <app-layout>
        <div class="max-w-3xl rounded p-3 md:p-4">
            <div
                class="flex flex-wrap items-end justify-between gap-4 print:hidden"
            >
                <h2
                    class="flex-shrink flex-grow text-xl font-bold leading-5 text-gray-700"
                >
                    শিক্ষার্থীর প্রফাইল
                </h2>
                <Link
                    :href="route('students.edit', data.student.id)"
                    class="flex flex-shrink-0 flex-grow-0 items-center justify-center gap-1 rounded bg-green-600 px-2.5 pt-1 text-white"
                >
                    তথ্য সম্পাদনা
                </Link>
                <Link
                    :href="route('students.edit', data.student) + '?step=fee'"
                    class="flex flex-shrink-0 flex-grow-0 items-center justify-center gap-1 rounded bg-green-600 px-2.5 pt-1 text-white"
                >
                    ফি সম্পাদনা
                </Link>
            </div>
        </div>

        <div
            class="max-w-3xl overflow-x-auto rounded border bg-white print:border-0"
        >
            <div class="space-y-1 bg-white px-6 py-4 print:py-0 print:px-4">
                <div class="flex items-center gap-2">
                    <div class="shrink-0 grow-0 font-bold text-gray-600">
                        মৌলিক তথ্য
                    </div>
                    <div class="shrink grow border-y border-gray-400"></div>
                </div>
                <div class="flex flex-col gap-2 py-2 md:flex-row">
                    <div class="shrink-0 grow-0">
                        <image-previe-with-save
                            class="w-44"
                            ratioClass="aspect-[40/48]"
                            option="student"
                            :imageUrl="data.student.imageUrl"
                            :id="data.student.id"
                            :width="100"
                            :height="120"
                        />
                    </div>
                    <div class="shrink grow">
                        <div class="flex items-start gap-1.5">
                            <div
                                class="w-32 shrink-0 grow-0 bg-gray-200 pt-1 pr-1 text-right text-sm font-semibold text-gray-800"
                            >
                                শিক্ষার্থীর নাম:
                            </div>
                            <div
                                class="shrink grow pt-1 text-sm font-semibold text-gray-800"
                            >
                                {{ data.student.name }}
                            </div>
                        </div>
                        <div class="flex items-start gap-1.5">
                            <div
                                class="w-32 shrink-0 grow-0 bg-gray-200 pt-1 pr-1 text-right text-sm font-semibold text-gray-800"
                            >
                                শিক্ষার্থীর ধরণ:
                            </div>
                            <div
                                class="shrink grow pt-1 text-sm font-semibold text-gray-800"
                            >
                                {{ data.student.residentText }}
                            </div>
                        </div>
                        <div class="flex items-start gap-1.5">
                            <div
                                class="w-32 shrink-0 grow-0 bg-gray-200 pt-1 pr-1 text-right text-sm font-semibold text-gray-800"
                            >
                                রেজি. নং:
                            </div>
                            <div
                                class="shrink grow pt-1 text-sm font-semibold text-gray-800"
                            >
                                {{ data.student.registration }}
                            </div>
                        </div>
                        <div class="flex items-start gap-1.5">
                            <div
                                class="w-32 shrink-0 grow-0 bg-gray-200 pt-1 pr-1 text-right text-sm font-semibold text-gray-800"
                            >
                                জন্ম তারিখ:
                            </div>
                            <div
                                class="shrink grow pt-1 text-sm font-semibold text-gray-800"
                            >
                                {{ data.student.dateOfBirthWithFormat }}
                            </div>
                        </div>
                        <div class="flex items-start gap-1.5">
                            <div
                                class="w-32 shrink-0 grow-0 bg-gray-200 pt-1 pr-1 text-right text-sm font-semibold text-gray-800"
                            >
                                জন্ম নিবন্ধন নং:
                            </div>
                            <div
                                class="shrink grow pt-1 text-sm font-semibold text-gray-800"
                            >
                                {{ data.student.birthCertificate }}
                            </div>
                        </div>
                        <div class="flex items-start gap-1.5">
                            <div
                                class="w-32 shrink-0 grow-0 bg-gray-200 pt-1 pr-1 text-right text-sm font-semibold text-gray-800"
                            >
                                রক্তের গ্রুপ:
                            </div>
                            <div
                                class="shrink grow pt-1 text-sm font-semibold text-gray-800"
                            >
                                {{ data.student.bloodGroupText }}
                            </div>
                        </div>
                        <div class="flex items-start gap-1.5">
                            <div
                                class="w-32 shrink-0 grow-0 bg-gray-200 pt-1 pr-1 text-right text-sm font-semibold text-gray-800"
                            >
                                লিঙ্গ:
                            </div>
                            <div
                                class="shrink grow pt-1 text-sm font-semibold text-gray-800"
                            >
                                {{ data.student.genderText }}
                            </div>
                        </div>
                        <div class="flex items-start gap-1.5">
                            <div
                                class="w-32 shrink-0 grow-0 bg-gray-200 pt-1 pr-1 text-right text-sm font-semibold text-gray-800"
                            >
                                অভিভাবকের নাম:
                            </div>
                            <div
                                class="shrink grow pt-1 text-sm font-semibold text-gray-800"
                            >
                                {{ data.student.guardianInfo.name }}
                            </div>
                        </div>
                        <div class="flex items-start gap-1.5">
                            <div
                                class="w-32 shrink-0 grow-0 bg-gray-200 pt-1 pr-1 text-right text-sm font-semibold text-gray-800"
                            >
                                অভিভাবকের ফোন:
                            </div>
                            <div
                                class="shrink grow pt-1 text-sm font-semibold text-gray-800"
                            >
                                {{ data.student.guardianInfo.phone }}
                            </div>
                        </div>
                        <div class="flex items-start gap-1.5">
                            <div
                                class="w-32 shrink-0 grow-0 bg-gray-200 pt-1 pr-1 text-right text-sm font-semibold text-gray-800"
                            >
                                সম্পর্ক:
                            </div>
                            <div
                                class="shrink grow pt-1 text-sm font-semibold text-gray-800"
                            >
                                {{ data.student.guardianInfo.relation }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div
            class="max-w-3xl overflow-x-auto rounded border bg-white print:border-0"
        >
            <div class="space-y-1 bg-white px-6 py-4 print:py-0 print:px-4">
                <div class="flex items-center gap-2">
                    <div class="shrink-0 grow-0 font-bold text-gray-600">
                        পিতা-মাতার তথ্য
                    </div>
                    <div class="shrink grow border-y border-gray-400"></div>
                </div>
                <div class="grid gap-2 md:grid-cols-2">
                    <div>
                        <div class="flex items-center gap-1.5">
                            <div
                                class="w-24 shrink-0 grow-0 bg-gray-200 pt-1 pr-2 text-right text-sm font-semibold text-gray-800"
                            >
                                পিতার নাম:
                            </div>
                            <div
                                class="shrink grow text-sm font-semibold text-gray-800"
                            >
                                {{ data.student.fatherInfo.name }}
                            </div>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <div
                                class="w-24 shrink-0 grow-0 bg-gray-200 pt-1 pr-2 text-right text-sm font-semibold text-gray-800"
                            >
                                পিতার ফোন:
                            </div>
                            <div
                                class="shrink grow text-sm font-semibold text-gray-800"
                            >
                                {{ data.student.fatherInfo.phone }}
                            </div>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <div
                                class="w-24 shrink-0 grow-0 bg-gray-200 pt-1 pr-2 text-right text-sm font-semibold text-gray-800"
                            >
                                পিতার পেশা:
                            </div>
                            <div
                                class="shrink grow text-sm font-semibold text-gray-800"
                            >
                                {{ data.student.fatherInfo.occupation }}
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="flex items-center gap-1.5">
                            <div
                                class="w-24 shrink-0 grow-0 bg-gray-200 pt-1 pr-2 text-right text-sm font-semibold text-gray-800"
                            >
                                মাতার নাম:
                            </div>
                            <div
                                class="shrink grow text-sm font-semibold text-gray-800"
                            >
                                {{ data.student.motherInfo.name }}
                            </div>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <div
                                class="w-24 shrink-0 grow-0 bg-gray-200 pt-1 pr-2 text-right text-sm font-semibold text-gray-800"
                            >
                                মাতার ফোন:
                            </div>
                            <div
                                class="shrink grow text-sm font-semibold text-gray-800"
                            >
                                {{ data.student.motherInfo.phone }}
                            </div>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <div
                                class="w-24 shrink-0 grow-0 bg-gray-200 pt-1 pr-2 text-right text-sm font-semibold text-gray-800"
                            >
                                মাতার পেশা:
                            </div>
                            <div
                                class="shrink grow text-sm font-semibold text-gray-800"
                            >
                                {{ data.student.motherInfo.occupation }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div
            class="max-w-3xl overflow-x-auto rounded border bg-white print:border-0"
        >
            <div class="space-y-1 bg-white px-6 py-4 print:py-0 print:px-4">
                <div class="flex items-center gap-2">
                    <div class="shrink-0 grow-0 font-bold text-gray-600">
                        ঠিকানা
                    </div>
                    <div class="shrink grow border-y border-gray-400"></div>
                </div>
                <div class="flex items-start gap-1.5">
                    <div
                        class="w-24 shrink-0 grow-0 bg-gray-200 pt-1 pr-0.5 text-right text-sm font-semibold text-gray-800"
                    >
                        বর্তমান ঠিকানা:
                    </div>
                    <div
                        class="shrink grow pt-1.5 text-sm font-semibold text-gray-800"
                    >
                        {{ data.student.presentAddress.value }},
                        {{ data.student.presentAddress.postoffice }},
                        {{ data.student.presentAddress.areaName }},
                        {{ data.student.presentAddress.districtName }},
                        {{ data.student.presentAddress.divisionName }}
                    </div>
                </div>
                <div class="flex items-start gap-1.5">
                    <div
                        class="w-24 shrink-0 grow-0 bg-gray-200 pt-1 pr-0.5 text-right text-sm font-semibold text-gray-800"
                    >
                        স্থায়ী ঠিকানা:
                    </div>
                    <div
                        class="shrink grow pt-1.5 text-sm font-semibold text-gray-800"
                    >
                        {{ data.student.permanentAddress.value }},
                        {{ data.student.permanentAddress.postoffice }},
                        {{ data.student.permanentAddress.areaName }},
                        {{ data.student.permanentAddress.districtName }},
                        {{ data.student.permanentAddress.divisionName }}
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-3xl rounded p-3 md:p-4">
            <div
                class="flex flex-wrap items-end justify-between gap-4 print:hidden"
            >
                <Link
                    :href="route('students.id-card', data.student.id)"
                    class="flex flex-shrink-0 flex-grow-0 items-center justify-center gap-1 rounded border border-sky-600 px-2.5 pt-1 text-sky-600 hover:bg-sky-600 hover:text-white"
                >
                    পরিচয় পত্র
                </Link>
                <Link
                    href="#"
                    class="flex flex-shrink-0 flex-grow-0 items-center justify-center gap-1 rounded border border-sky-600 px-2.5 pt-1 text-sky-600 hover:bg-sky-600 hover:text-white"
                >
                    বেতন কার্ড
                </Link>
                <Link
                    href="#"
                    class="flex flex-shrink-0 flex-grow-0 items-center justify-center gap-1 rounded border border-sky-600 px-2.5 pt-1 text-sky-600 hover:bg-sky-600 hover:text-white"
                >
                    রোজাল্ট কার্ড
                </Link>
                <Link
                    :href="
                        route('students.money-receipt.index', data.student.id)
                    "
                    class="flex flex-shrink-0 flex-grow-0 items-center justify-center gap-1 rounded border border-sky-600 px-2.5 pt-1 text-sky-600 hover:bg-sky-600 hover:text-white"
                >
                    রশিদগুলা
                </Link>
                <Link
                    :href="
                        route('payments.create') +
                        '?registration=' +
                        data.student.registration
                    "
                    class="flex flex-shrink-0 flex-grow-0 items-center justify-center gap-1 rounded border border-sky-600 px-2.5 pt-1 text-sky-600 hover:bg-sky-600 hover:text-white"
                >
                    টাকা জমা নিন
                </Link>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/App.vue";
import { Link, Head } from "@inertiajs/inertia-vue3";
import ActionButtonEdit from "@/Components/ActionButtonEdit.vue";
import FormHeading from "@/Components/FormHeading.vue";
import InlineData from "@/Components/InlineData.vue";
import LetterHead from "@/Templete/LetterHead.vue";
import PrintButton from "@/Components/PrintButton.vue";
import AdmissionFormTemplete from "@/Templete/AdmissionForm.vue";
import CheckUncheckIcon from "@/Components/CheckUncheckIcon.vue";
import ImagePrevieWithSave from "@/Components/ImagePrevieWithSave.vue";

export default {
    components: {
        AppLayout,
        Link,
        Head,
        ActionButtonEdit,
        FormHeading,
        InlineData,
        LetterHead,
        PrintButton,
        AdmissionFormTemplete,
        CheckUncheckIcon,
        ImagePrevieWithSave,
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
