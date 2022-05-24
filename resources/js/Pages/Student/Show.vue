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
                    class="flex flex-shrink-0 flex-grow-0 items-center justify-center gap-1 rounded bg-green-600 px-2.5 py-0.5 text-white"
                >
                    তথ্য সম্পাদনা
                </Link>
                <Link
                    :href="route('students.edit', data.student) + '?step=fee'"
                    class="flex flex-shrink-0 flex-grow-0 items-center justify-center gap-1 rounded bg-green-600 px-2.5 py-0.5 text-white"
                >
                    ফি সম্পাদনা
                </Link>
            </div>
        </div>

        <div
            class="max-w-3xl overflow-x-auto rounded border bg-white print:border-0"
        >
            <div class="bg-white px-6 py-4 print:py-0 print:px-4">
                <div class="grid gap-2">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <inline-data
                                title="শিক্ষার্থীর নাম:"
                                :value="data.student.name"
                            />
                        </div>
                        <div>
                            <inline-data
                                title="জন্ম তারিখ:"
                                :value="data.student.dateOfBirthWithFormat"
                            />
                        </div>
                    </div>
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <inline-data
                                title="জন্ম নিবন্ধন নাম্বার:"
                                :value="data.student.birthCertificate"
                            />
                        </div>
                        <div class="flex items-center justify-center gap-4">
                            <div>
                                <inline-data
                                    title="রক্তের গ্রুপ:"
                                    :value="data.student.bloodGroupText"
                                />
                            </div>
                            <div class="flex items-center justify-center gap-4">
                                <div class="text-gray-700">লিঙ্গ:</div>
                                <label
                                    class="flex items-center justify-center gap-2"
                                >
                                    <check-uncheck-icon
                                        class="w-4"
                                        :isChecked="data.student.gender == '1'"
                                    />
                                    <span
                                        :class="{
                                            'font-semibold':
                                                data.student.gender == '1',
                                        }"
                                    >
                                        ছেলে
                                    </span>
                                </label>
                                <label
                                    class="flex items-center justify-center gap-2"
                                >
                                    <check-uncheck-icon
                                        class="w-4"
                                        :isChecked="data.student.gender == '2'"
                                    />
                                    <span
                                        :class="{
                                            'font-semibold':
                                                data.student.gender == '2',
                                        }"
                                    >
                                        মেয়ে
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <hr />
                    <div class="grid gap-4 print:grid-cols-4 md:grid-cols-4">
                        <div class="print:col-span-2 md:col-span-2">
                            <inline-data
                                title="পিতার নাম:"
                                :value="data.student.fatherInfo.name"
                            />
                        </div>
                        <div>
                            <inline-data
                                title="ফোন:"
                                :value="data.student.fatherInfo.phone"
                            />
                        </div>
                        <div>
                            <inline-data
                                title="পেশা:"
                                :value="data.student.fatherInfo.occupation"
                            />
                        </div>
                    </div>
                    <div class="grid gap-4 print:grid-cols-4 md:grid-cols-4">
                        <div class="print:col-span-2 md:col-span-2">
                            <inline-data
                                title="মাতার নাম:"
                                :value="data.student.motherInfo.name"
                            />
                        </div>
                        <div>
                            <inline-data
                                title="ফোন:"
                                :value="data.student.motherInfo.phone"
                            />
                        </div>
                        <div>
                            <inline-data
                                title="পেশা:"
                                :value="data.student.motherInfo.occupation"
                            />
                        </div>
                    </div>
                    <hr />
                    <div class="flex items-center gap-4">
                        <inline-data title="অভিভাবকের তথ্য" />
                        <label class="flex items-center justify-center gap-2">
                            <check-uncheck-icon
                                class="w-4"
                                :isChecked="data.student.guardianType == '1'"
                            />
                            <span
                                :class="{
                                    'font-semibold':
                                        data.student.guardianType == '1',
                                }"
                            >
                                পিতা
                            </span>
                        </label>
                        <label class="flex items-center justify-center gap-2">
                            <check-uncheck-icon
                                class="w-4"
                                :isChecked="data.student.guardianType == '2'"
                            />
                            <span
                                :class="{
                                    'font-semibold':
                                        data.student.guardianType == '2',
                                }"
                            >
                                মাতা
                            </span>
                        </label>
                        <label class="flex items-center justify-center gap-2">
                            <check-uncheck-icon
                                class="w-4"
                                :isChecked="data.student.guardianType == '3'"
                            />
                            <span
                                :class="{
                                    'font-semibold':
                                        data.student.guardianType == '3',
                                }"
                            >
                                বৈধ অভিভাবক
                            </span>
                        </label>
                    </div>
                    <div class="grid gap-4 print:grid-cols-4 md:grid-cols-4">
                        <div class="print:col-span-2 md:col-span-2">
                            <inline-data
                                title="অভিভাবকের নাম:"
                                :value="data.student.guardianInfo.name"
                            />
                        </div>
                        <div>
                            <inline-data
                                title="ফোন:"
                                :value="data.student.guardianInfo.phone"
                            />
                        </div>
                        <div>
                            <inline-data
                                title="সম্পর্ক:"
                                :value="data.student.guardianInfo.relation"
                            />
                        </div>
                    </div>
                    <hr />
                    <div class="font-semibold text-gray-700">
                        বর্তমান ঠিকানা:
                    </div>
                    <div class="grid gap-4 print:grid-cols-3 md:grid-cols-3">
                        <div class="print:col-span-2 md:col-span-2">
                            <inline-data
                                title="বাড়ি নং, রোড নং, গ্রাম/মহল্লা:"
                                :value="data.student.presentAddress.value"
                            />
                        </div>
                        <div>
                            <inline-data
                                title="পোস্ট অফিস:"
                                :value="data.student.presentAddress.postoffice"
                            />
                        </div>
                    </div>
                    <div class="grid gap-4 print:grid-cols-3 md:grid-cols-3">
                        <div>
                            <inline-data
                                title="উপজেলা:"
                                :value="data.student.presentAddress.areaName"
                            />
                        </div>
                        <div>
                            <inline-data
                                title="জেলা:"
                                :value="
                                    data.student.presentAddress.districtName
                                "
                            />
                        </div>
                        <div>
                            <inline-data
                                title="বিভাগ:"
                                :value="
                                    data.student.presentAddress.divisionName
                                "
                            />
                        </div>
                    </div>
                    <div class="font-semibold text-gray-700">
                        স্থায়ী ঠিকানা:
                    </div>
                    <div class="grid gap-4 print:grid-cols-3 md:grid-cols-3">
                        <div class="print:col-span-2 md:col-span-2">
                            <inline-data
                                title="বাড়ি নং, রোড নং, গ্রাম/মহল্লা:"
                                :value="data.student.permanentAddress.value"
                            />
                        </div>
                        <div>
                            <inline-data
                                title="পোস্ট অফিস:"
                                :value="
                                    data.student.permanentAddress.postoffice
                                "
                            />
                        </div>
                    </div>
                    <div class="grid gap-4 print:grid-cols-3 md:grid-cols-3">
                        <div>
                            <inline-data
                                title="উপজেলা:"
                                :value="data.student.permanentAddress.areaName"
                            />
                        </div>
                        <div>
                            <inline-data
                                title="জেলা:"
                                :value="
                                    data.student.permanentAddress.districtName
                                "
                            />
                        </div>
                        <div>
                            <inline-data
                                title="বিভাগ:"
                                :value="
                                    data.student.permanentAddress.divisionName
                                "
                            />
                        </div>
                    </div>
                    <hr />
                    <div class="grid gap-4">
                        <div class="flex flex-wrap items-center gap-5">
                            <div class="text-gray-700">শিক্ষার্থীর ধরন:</div>
                            <label
                                class="flex items-center justify-center gap-2"
                            >
                                <check-uncheck-icon
                                    class="w-4"
                                    :isChecked="data.student.resident == '1'"
                                />
                                <span
                                    :class="{
                                        'font-semibold':
                                            data.student.resident == '1',
                                    }"
                                >
                                    আবাসিক
                                </span>
                            </label>
                            <label
                                class="flex items-center justify-center gap-2"
                            >
                                <check-uncheck-icon
                                    class="w-4"
                                    :isChecked="data.student.resident == '2'"
                                />
                                <span
                                    :class="{
                                        'font-semibold':
                                            data.student.resident == '2',
                                    }"
                                >
                                    অনাবাসিক
                                </span>
                            </label>
                            <label
                                class="flex items-center justify-center gap-2"
                            >
                                <check-uncheck-icon
                                    class="w-4"
                                    :isChecked="data.student.resident == '3'"
                                />
                                <span
                                    :class="{
                                        'font-semibold':
                                            data.student.resident == '3',
                                    }"
                                >
                                    ডে-কেয়ার
                                </span>
                            </label>
                            <label
                                class="flex items-center justify-center gap-2"
                            >
                                <check-uncheck-icon
                                    class="w-4"
                                    :isChecked="data.student.resident == '4'"
                                />
                                <span
                                    :class="{
                                        'font-semibold':
                                            data.student.resident == '4',
                                    }"
                                >
                                    সেমি-আবাসিক
                                </span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-3xl rounded p-3 md:p-4">
            <div
                class="flex flex-wrap items-end justify-between gap-4 print:hidden"
            >
                <Link
                    href="#"
                    class="flex flex-shrink-0 flex-grow-0 items-center justify-center gap-1 rounded border border-sky-600 px-2.5 py-0.5 text-sky-600 hover:bg-sky-600 hover:text-white"
                >
                    পরিচয় পত্র
                </Link>
                <Link
                    href="#"
                    class="flex flex-shrink-0 flex-grow-0 items-center justify-center gap-1 rounded border border-sky-600 px-2.5 py-0.5 text-sky-600 hover:bg-sky-600 hover:text-white"
                >
                    বেতন কার্ড
                </Link>
                <Link
                    href="#"
                    class="flex flex-shrink-0 flex-grow-0 items-center justify-center gap-1 rounded border border-sky-600 px-2.5 py-0.5 text-sky-600 hover:bg-sky-600 hover:text-white"
                >
                    রোজাল্ট কার্ড
                </Link>
                <Link
                    href="#"
                    class="flex flex-shrink-0 flex-grow-0 items-center justify-center gap-1 rounded border border-sky-600 px-2.5 py-0.5 text-sky-600 hover:bg-sky-600 hover:text-white"
                >
                    রশিদগুলা
                </Link>
                <Link
                    :href="
                        route('payments.create') +
                        '?registration=' +
                        data.student.registration
                    "
                    class="flex flex-shrink-0 flex-grow-0 items-center justify-center gap-1 rounded border border-sky-600 px-2.5 py-0.5 text-sky-600 hover:bg-sky-600 hover:text-white"
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
