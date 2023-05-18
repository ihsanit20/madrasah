<template>
    <Head title="Staff" />

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
                    :href="route('staff.edit', data.staff.id)"
                    class="flex flex-shrink-0 flex-grow-0 items-center justify-center gap-1 rounded bg-green-600 px-2.5 pt-1 text-white"
                >
                    তথ্য সম্পাদনা
                </Link>
                <Link
                    :href="route('staff.edit', data.staff) + '?step=salary'"
                    class="flex flex-shrink-0 flex-grow-0 items-center justify-center gap-1 rounded bg-green-600 px-2.5 pt-1 text-white"
                >
                    বেতন সম্পাদনা
                </Link>
                <Link
                    :href="route('staff.salaries.create', data.staff.id)"
                    class="flex flex-shrink-0 flex-grow-0 items-center justify-center gap-1 rounded bg-green-600 px-2.5 pt-1 text-white"
                >
                    বেতন দিন
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
                                শিক্ষার্থীর নাম:
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
                                {{ data.staff.designationTitle }}
                            </div>
                        </div>
                        <div class="flex items-start gap-1.5">
                            <div
                                class="w-32 shrink-0 grow-0 bg-gray-200 pt-1 pr-1 text-right text-sm font-semibold text-gray-800"
                            >
                                নিয়োগের তারিখ:
                            </div>
                            <div
                                class="shrink grow pt-1 text-sm font-semibold text-gray-800"
                            >
                                {{
                                    $e2bnumber(
                                        data.staff.dateOfBirthWithFormat || ""
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
                                        data.staff.dateOfBirthWithFormat || ""
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
                                {{ data.staff.birthCertificate }}
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
                                {{ data.staff.bloodGroupText }}
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
                                {{ data.staff.genderText }}
                            </div>
                        </div>
                    </div>
                    <div class="grid shrink-0 grow-0">
                        <label class="shrink-0 grow-0 text-gray-700">
                            ছবি
                        </label>
                        <image-previe-with-save
                            class="w-44"
                            ratioClass="aspect-[40/48]"
                            option="staff"
                            :imageUrl="data.staff.imageUrl"
                            :id="data.staff.id"
                            :width="100"
                            :height="120"
                        />
                        <label class="mt-4 shrink-0 grow-0 text-gray-700">
                            সাক্ষর
                        </label>
                        <image-previe-with-save
                            class="w-44"
                            ratioClass="aspect-[16/9]"
                            option="staff"
                            :imageUrl="data.staff.signatureUrl"
                            :id="data.staff.id"
                            :type="2"
                            :width="160"
                            :height="90"
                        />
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
                        ---
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
                        ---
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
                        ---
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
                        ---
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
                        ---
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
                        ---
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
                        ---
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
                    <tr class="text-center">
                        <td class="bg-gray-200 pt-1.5 pb-0.5">পরীক্ষার নাম</td>
                        <td class="pt-1.5 pb-0.5">{{ $e2bnumber(2013) }}</td>
                        <td class="bg-gray-200 pt-1.5 pb-0.5">
                            প্রতিষ্ঠানের নাম
                        </td>
                        <td class="pt-1.5 pb-0.5">বোর্ড</td>
                        <td class="bg-gray-200 pt-1.5 pb-0.5">ফলাফল</td>
                    </tr>
                    <tr class="text-center">
                        <td class="bg-gray-200 pt-1.5 pb-0.5">পরীক্ষার নাম</td>
                        <td class="pt-1.5 pb-0.5">{{ $e2bnumber(2013) }}</td>
                        <td class="bg-gray-200 pt-1.5 pb-0.5">
                            প্রতিষ্ঠানের নাম
                        </td>
                        <td class="pt-1.5 pb-0.5">বোর্ড</td>
                        <td class="bg-gray-200 pt-1.5 pb-0.5">ফলাফল</td>
                    </tr>
                    <tr class="text-center">
                        <td class="bg-gray-200 pt-1.5 pb-0.5">পরীক্ষার নাম</td>
                        <td class="pt-1.5 pb-0.5">{{ $e2bnumber(2013) }}</td>
                        <td class="bg-gray-200 pt-1.5 pb-0.5">
                            প্রতিষ্ঠানের নাম
                        </td>
                        <td class="pt-1.5 pb-0.5">বোর্ড</td>
                        <td class="bg-gray-200 pt-1.5 pb-0.5">ফলাফল</td>
                    </tr>
                    <tr class="text-center">
                        <td class="bg-gray-200 pt-1.5 pb-0.5">পরীক্ষার নাম</td>
                        <td class="pt-1.5 pb-0.5">{{ $e2bnumber(2013) }}</td>
                        <td class="bg-gray-200 pt-1.5 pb-0.5">
                            প্রতিষ্ঠানের নাম
                        </td>
                        <td class="pt-1.5 pb-0.5">বোর্ড</td>
                        <td class="bg-gray-200 pt-1.5 pb-0.5">ফলাফল</td>
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
                    class="flex flex-shrink-0 flex-grow-0 items-center justify-center gap-1 rounded border border-sky-600 px-2.5 pt-1 text-sky-600 hover:bg-sky-600 hover:text-white"
                >
                    রশিদগুলা
                </Link>
                <Link
                    :href="route('staff.salaries.create', data.staff.id)"
                    class="flex flex-shrink-0 flex-grow-0 items-center justify-center gap-1 rounded border border-sky-600 px-2.5 pt-1 text-sky-600 hover:bg-sky-600 hover:text-white"
                >
                    বেতন দিন
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
