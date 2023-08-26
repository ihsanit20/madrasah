<template>
    <Head title="Staff Form" />

    <app-layout>
        <div class="max-w-3xl rounded pb-2">
            <div
                class="flex flex-wrap items-end justify-between gap-4 print:hidden"
            >
                <h2
                    class="flex-shrink flex-grow text-xl font-bold leading-5 text-gray-700"
                >
                    শিক্ষক/স্টাফ প্রফাইল
                </h2>
                <Link
                    :href="route('staff-form.edit', data.staff.id)"
                    class="flex flex-shrink-0 flex-grow-0 items-center justify-center gap-1 rounded border border-brand-600 px-4 pt-1 text-brand-600"
                >
                    তথ্য সম্পাদনা
                </Link>
                <Link
                    :href="route('staff-form.edit', data.staff.id) + '?step=salary'"
                    class="flex flex-shrink-0 flex-grow-0 items-center justify-center gap-1 rounded border border-brand-600 bg-brand-600 px-4 pt-1 text-white"
                >
                    পরবর্তী ধাপ &#8594;
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
                    <div class="shrink grow">
                        <div class="flex items-start gap-1.5">
                            <div
                                class="w-32 shrink-0 grow-0 bg-gray-200 pt-1 pr-1 text-right text-sm font-semibold text-gray-800"
                            >
                                শিক্ষক/স্টাফ নাম:
                            </div>
                            <div
                                class="shrink grow pt-1 text-sm font-semibold text-gray-800"
                            >
                                {{ data.staff.name }}
                            </div>
                        </div>
                        <div class="flex items-start gap-1.5">
                            <div
                                class="w-32 shrink-0 grow-0 bg-gray-200 pt-1 pr-1 text-right text-sm font-semibold text-gray-800"
                            >
                                পদবি:
                            </div>
                            <div
                                class="shrink grow pt-1 text-sm font-semibold text-gray-800"
                            >
                                {{ data.staff.designation_title }}
                            </div>
                        </div>
                        <div class="flex items-start gap-1.5">
                            <div
                                class="w-32 shrink-0 grow-0 bg-gray-200 pt-1 pr-1 text-right text-sm font-semibold text-gray-800"
                            >
                                আবেদনের তারিখ:
                            </div>
                            <div
                                class="shrink grow pt-1 text-sm font-semibold text-gray-800"
                            >
                                {{
                                    $e2bnumber(
                                        data.staff.application_date_with_format || ""
                                    )
                                }}
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
                                {{
                                    $e2bnumber(
                                        data.staff.date_of_birth_with_format || ""
                                    )
                                }}
                            </div>
                        </div>
                        <div class="flex items-start gap-1.5">
                            <div
                                class="w-32 shrink-0 grow-0 bg-gray-200 pt-1 pr-1 text-right text-sm font-semibold text-gray-800"
                            >
                                NID নং:
                            </div>
                            <div
                                class="shrink grow pt-1 text-sm font-semibold text-gray-800"
                            >
                                {{ data.staff.nid }}
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
                                {{ data.staff.blood_group_text }}
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
                                {{ data.staff.gender_text }}
                            </div>
                        </div>
                        <div class="flex items-start gap-1.5">
                            <div
                                class="w-32 shrink-0 grow-0 bg-gray-200 pt-1 pr-1 text-right text-sm font-semibold text-gray-800"
                            >
                                পিতার নাম:
                            </div>
                            <div
                                class="shrink grow pt-1 text-sm font-semibold text-gray-800"
                            >
                                {{ data.staff.fathers_info.name }}
                            </div>
                        </div>
                        <div class="flex items-start gap-1.5">
                            <div
                                class="w-32 shrink-0 grow-0 bg-gray-200 pt-1 pr-1 text-right text-sm font-semibold text-gray-800"
                            >
                                পিতার ফোন:
                            </div>
                            <div
                                class="shrink grow pt-1 text-sm font-semibold text-gray-800"
                            >
                                {{ data.staff.fathers_info.phone }}
                            </div>
                        </div>
                        <div class="flex items-start gap-1.5">
                            <div
                                class="w-32 shrink-0 grow-0 bg-gray-200 pt-1 pr-1 text-right text-sm font-semibold text-gray-800"
                            >
                                মাতার নাম:
                            </div>
                            <div
                                class="shrink grow pt-1 text-sm font-semibold text-gray-800"
                            >
                                {{ data.staff.mothers_info.name }}
                            </div>
                        </div>
                        <div class="flex items-start gap-1.5">
                            <div
                                class="w-32 shrink-0 grow-0 bg-gray-200 pt-1 pr-1 text-right text-sm font-semibold text-gray-800"
                            >
                                মাতার ফোন:
                            </div>
                            <div
                                class="shrink grow pt-1 text-sm font-semibold text-gray-800"
                            >
                                {{ data.staff.mothers_info.phone }}
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
                        যোগাযোগ
                    </div>
                    <div class="shrink grow border-y border-gray-400"></div>
                </div>
                <div class="flex items-start gap-1.5">
                    <div
                        class="w-24 shrink-0 grow-0 bg-gray-200 pt-1 pr-0.5 text-right text-sm font-semibold text-gray-800"
                    >
                        ফোন নাম্বার:
                    </div>
                    <div
                        class="shrink grow pt-1.5 text-sm font-semibold text-gray-800"
                    >
                        {{ data.staff.phone }}<span v-if="data.staff.alternative_phone">, {{ data.staff.alternative_phone }}</span>
                    </div>
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
                        {{ present_address_text }}
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
                        {{ permanent_address_text }}
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
                        পরিচিত মাধ্যম
                    </div>
                    <div class="shrink grow border-y border-gray-400"></div>
                </div>
                <div class="flex items-start gap-1.5">
                    <div
                        class="w-24 shrink-0 grow-0 bg-gray-200 pt-1 pr-0.5 text-right text-sm font-semibold text-gray-800"
                    >
                        নাম:
                    </div>
                    <div
                        class="shrink grow pt-1.5 text-sm font-semibold text-gray-800"
                    >
                        {{ data.staff.reference_info.name }}
                    </div>
                </div>
                <div class="flex items-start gap-1.5">
                    <div
                        class="w-24 shrink-0 grow-0 bg-gray-200 pt-1 pr-0.5 text-right text-sm font-semibold text-gray-800"
                    >
                        সম্পর্ক:
                    </div>
                    <div
                        class="shrink grow pt-1.5 text-sm font-semibold text-gray-800"
                    >
                        {{ data.staff.reference_info.relation }}
                    </div>
                </div>
                <div class="flex items-start gap-1.5">
                    <div
                        class="w-24 shrink-0 grow-0 bg-gray-200 pt-1 pr-0.5 text-right text-sm font-semibold text-gray-800"
                    >
                        ফোন নাম্বার:
                    </div>
                    <div
                        class="shrink grow pt-1.5 text-sm font-semibold text-gray-800"
                    >
                        {{ data.staff.reference_info.phone }}
                    </div>
                </div>
                <div class="flex items-start gap-1.5">
                    <div
                        class="w-24 shrink-0 grow-0 bg-gray-200 pt-1 pr-0.5 text-right text-sm font-semibold text-gray-800"
                    >
                        ঠিকানা:
                    </div>
                    <div
                        class="shrink grow pt-1.5 text-sm font-semibold text-gray-800"
                    >
                        {{ data.staff.reference_info.address }}
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
                        শিক্ষাগত যোগ্যতা
                    </div>
                    <div class="shrink grow border-y border-gray-400"></div>
                </div>
                <table class="w-full table-fixed border border-black">
                    <tr class="border-b border-black text-center">
                        <th class="bg-gray-200 pt-1.5 pb-0.5">পরীক্ষার নাম</th>
                        <th class="pt-1.5 pb-0.5">সাল</th>
                        <th class="bg-gray-200 pt-1.5 pb-0.5">
                            প্রতিষ্ঠানের নাম
                        </th>
                        <th class="pt-1.5 pb-0.5">বোর্ড</th>
                        <th class="bg-gray-200 pt-1.5 pb-0.5">ফলাফল</th>
                    </tr>
                    <tr
                        v-for="(educational_qualification, key) in data.staff.educational_qualifications"
                        :key="key"
                        class="text-center"
                    >
                        <td class="bg-gray-200 pt-1.5 pb-0.5">
                            {{ educational_qualification.exam_name }}
                        </td>
                        <td class="pt-1.5 pb-0.5">
                            {{ $e2bnumber(educational_qualification.year) }}
                        </td>
                        <td class="bg-gray-200 pt-1.5 pb-0.5">
                            {{ educational_qualification.institute_name }}
                        </td>
                        <td class="pt-1.5 pb-0.5">
                            {{ educational_qualification.board }}
                        </td>
                        <td class="bg-gray-200 pt-1.5 pb-0.5">
                            {{ educational_qualification.result }}
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div v-if="false" class="max-w-3xl rounded p-3 md:p-4">
            <div
                class="flex flex-wrap items-end justify-between gap-4 print:hidden"
            >
                <Link
                    href="#"
                    class="flex flex-shrink-0 flex-grow-0 items-center justify-center gap-1 rounded border border-brand-600 px-2.5 pt-1 text-brand-600 hover:bg-brand-600 hover:text-white"
                >
                    রশিদগুলা
                </Link>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/GridApp.vue";
import { Link, Head } from "@inertiajs/vue3";
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
    computed: {
        present_address_text() {
            let addressText = '';

            addressText += this.data.staff.present_address_info.address;
            addressText += ", " + this.data.staff.present_address_info.postoffice;

            let selectedArea = Object.values(this.data.areas).find((area) => {
                return parseInt(area.id) === parseInt(this.data.staff.present_address_info.area);
            })

            let selectedDistrict = Object.values(this.data.districts).find((district) => {
                return parseInt(district.id) === parseInt(this.data.staff.present_address_info.district);
            })

            let selectedDivision = Object.values(this.data.divisions).find((division) => {
                return parseInt(division.id) === parseInt(this.data.staff.present_address_info.division);
            })

            addressText += ", " + (selectedArea ? selectedArea.name : "");
            addressText += ", " + (selectedArea ? selectedDistrict.name : "");
            addressText += ", " + (selectedArea ? selectedDivision.name : "");

            return addressText;
        },
        permanent_address_text() {
            let addressText = '';

            addressText += this.data.staff.permanent_address_info.address;
            addressText += ", " + this.data.staff.permanent_address_info.postoffice;

            let selectedArea = Object.values(this.data.areas).find((area) => {
                return parseInt(area.id) === parseInt(this.data.staff.permanent_address_info.area);
            })

            let selectedDistrict = Object.values(this.data.districts).find((district) => {
                return parseInt(district.id) === parseInt(this.data.staff.permanent_address_info.district);
            })

            let selectedDivision = Object.values(this.data.divisions).find((division) => {
                return parseInt(division.id) === parseInt(this.data.staff.permanent_address_info.division);
            })

            addressText += ", " + (selectedArea ? selectedArea.name : "");
            addressText += ", " + (selectedArea ? selectedDistrict.name : "");
            addressText += ", " + (selectedArea ? selectedDivision.name : "");

            return addressText;
        }
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
