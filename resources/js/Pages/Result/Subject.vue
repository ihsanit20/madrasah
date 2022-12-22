<template>
    <Head
        :title="`${data.exam.name} : ${data.class.name} ক্লাস এর বিষয় সমুহ`"
    />

    <app-layout
        :pageTitle="`${data.exam.name} : ${data.class.name} ক্লাস এর বিষয় সমুহ`"
    >
        <div class="flex items-center justify-between py-2 print:hidden">
            <Link
                :href="route('results.classes', [data.exam.id])"
                class="flex items-center justify-center gap-2 rounded-md bg-gray-600 px-4 py-1 text-white"
            >
                <ArrowLeftIcon class="w-5" />
                পূর্বের পেজ
            </Link>
            <Link
                :href="
                    route('results.result-cards', [data.exam.id, data.class.id])
                "
                class="flex items-center justify-center gap-2 rounded-md bg-sky-600 px-4 py-1 text-white"
            >
                রেজাল্ট কার্ড
            </Link>
            <print-button />
        </div>
        <div
            class="grid w-full space-y-2 bg-white bg-[url('/images/wmlogo.png')] bg-center bg-no-repeat px-6 py-4 print:py-0 print:px-4"
        >
            <letter-head />

            <div
                class="flex items-center justify-center gap-4 text-lg font-bold"
            >
                <div>{{ data.exam.name }}</div>
                <div>{{ $e2bnumber(data.exam.session) }} হিজরি</div>
            </div>

            <div class="flex items-center justify-center gap-1">
                <div class="">শ্রেণী</div>
                <span>:</span>
                <div>{{ data.class.name }}</div>
            </div>

            <div class="mt-1.5 mb-2 flex items-center justify-center">
                <div
                    class="rounded-md border px-4 py-0.5 text-center text-2xl font-bold print:border-black print:text-black"
                >
                    ফলাফল
                </div>
            </div>

            <table class="w-full table-auto print:text-xs">
                <thead class="">
                    <tr class="">
                        <th
                            colspan="3"
                            class="border p-2 print:h-[120px] print:p-1"
                        >
                            কৃতকার্য শিক্ষার্থী তালিকা
                        </th>
                        <th
                            v-for="subject in data.subjects"
                            :key="subject.code"
                            class="max-h-[220px] border p-2 print:h-[120px] print:p-1"
                            style="writing-mode: vertical-rl"
                        >
                            <div class="h-full -rotate-180 break-all text-left">
                                {{ subject.name }}
                            </div>
                        </th>
                        <th colspan="4" class="border p-2 print:p-1"></th>
                    </tr>
                    <tr>
                        <th class="border p-2 print:p-1">মেধাক্রম</th>
                        <th class="border p-2 print:p-1">শিক্ষার্থী</th>
                        <th class="border p-2 print:p-1">রোল</th>
                        <th
                            v-for="subject in data.subjects"
                            :key="subject.code"
                            class="border p-2 print:p-1"
                        >
                            <div class="text-center">
                                <Link
                                    :href="
                                        route('results.create', [
                                            data.exam.id,
                                            data.class.id,
                                            subject.code,
                                        ])
                                    "
                                    class="text-sky-600 underline print:text-black print:no-underline"
                                >
                                    {{ $e2bnumber(subject.code) }}
                                </Link>
                            </div>
                        </th>
                        <th class="border p-2 print:p-1">মোট</th>
                        <th class="border p-2 print:p-1">গড়</th>
                        <th class="border p-2 print:p-1">গ্রেড</th>
                    </tr>
                </thead>
                <tbody class="">
                    <tr
                        v-for="(student, index) in data.students"
                        :key="index"
                        class="hover:bg-gray-100 dark:hover:bg-gray-700"
                        :class="{
                            'hidden': getMeritList(student) === '-'
                        }"
                    >
                        <td class="border p-2 text-center print:p-1">
                            {{ $e2bnumber(getMeritList(student)) }}
                        </td>
                        <td class="border p-2 text-left print:p-1">
                            {{ student.name }}
                        </td>
                        <td class="border p-2 text-center print:p-1">
                            {{ $e2bnumber(student.roll) }}
                        </td>
                        <td
                            v-for="subject in data.subjects"
                            :key="subject.code"
                            class="border p-2 text-center print:p-1"
                        >
                            {{ $e2bnumber(getSubjectMark(student, subject)) }}
                        </td>
                        <td class="border p-2 text-center print:p-1">
                            {{ $e2bnumber(getTotalMark(student)) }}
                        </td>
                        <td class="border p-2 text-center print:p-1">
                            {{ $e2bnumber(getAverageMark(student)) }}
                        </td>
                        <td class="border p-2 text-center print:p-1">
                            {{ $e2bnumber(getGrade(student)) }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <table class="w-full table-auto print:text-xs">
                <thead class="">
                    <tr class="">
                        <th colspan="2">অকৃতকার্য শিক্ষার্থী তালিকা</th>
                    </tr>
                    <tr>
                        <th class="border p-2 print:p-1">মেধাক্রম</th>
                        <th class="border p-2 print:p-1">শিক্ষার্থী</th>
                        <th class="border p-2 print:p-1">রোল</th>
                        <th
                            v-for="subject in data.subjects"
                            :key="subject.code"
                            class="border p-2 print:p-1"
                        >
                            <div class="text-center">
                                <Link
                                    :href="
                                        route('results.create', [
                                            data.exam.id,
                                            data.class.id,
                                            subject.code,
                                        ])
                                    "
                                    class="text-sky-600 underline print:text-black print:no-underline"
                                >
                                    {{ $e2bnumber(subject.code) }}
                                </Link>
                            </div>
                        </th>
                        <th class="border p-2 print:p-1">মোট</th>
                        <th class="border p-2 print:p-1">গড়</th>
                        <th class="border p-2 print:p-1">গ্রেড</th>
                    </tr>
                </thead>
                <tbody class="">
                    <tr
                        v-for="(student, index) in data.students"
                        :key="index"
                        class="hover:bg-gray-100 dark:hover:bg-gray-700"
                        :class="{
                            'hidden': getMeritList(student) !== '-'
                        }"
                    >
                        <td class="border p-2 text-center print:p-1">
                            {{ $e2bnumber(getMeritList(student)) }}
                        </td>
                        <td class="border p-2 text-left print:p-1">
                            {{ student.name }}
                        </td>
                        <td class="border p-2 text-center print:p-1">
                            {{ $e2bnumber(student.roll) }}
                        </td>
                        <td
                            v-for="subject in data.subjects"
                            :key="subject.code"
                            class="border p-2 text-center print:p-1"
                        >
                            {{ $e2bnumber(getSubjectMark(student, subject)) }}
                        </td>
                        <td class="border p-2 text-center print:p-1">
                            {{ $e2bnumber(getTotalMark(student)) }}
                        </td>
                        <td class="border p-2 text-center print:p-1">
                            {{ $e2bnumber(getAverageMark(student)) }}
                        </td>
                        <td class="border p-2 text-center print:p-1">
                            {{ $e2bnumber(getGrade(student)) }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="flex w-full justify-end">
                <div class="mt-2 flex flex-col items-end justify-center">
                    <div
                        class="flex h-[40px] max-w-[100px] items-center justify-center"
                    >
                        <img
                            v-if="signature"
                            :src="signature"
                            class="h-full w-full object-contain"
                        />
                    </div>
                    <div class="flex items-center justify-center">
                        <p class="text-sm font-bold">অধ্যক্ষের স্বাক্ষর</p>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/App.vue";
import { ClassSvg, ExamSvg } from "@/Layouts/Navigation/SvgIcon";
import { Head, Link } from "@inertiajs/inertia-vue3";
import { ArrowLeftIcon } from "@heroicons/vue/outline";
import SimpleTable from "@/Components/SimpleTable.vue";
import TableTd from "@/Components/TableTd.vue";
import PrintButton from "@/Components/PrintButton.vue";
import LetterHead from "@/Templete/LetterHead.vue";

export default {
    components: {
        AppLayout,
        Head,
        Link,
        ClassSvg,
        ExamSvg,
        ArrowLeftIcon,
        SimpleTable,
        TableTd,
        PrintButton,
        LetterHead,
    },
    created() {
        Object.values(this.data.subjects).forEach((subject) => {
            this.columns.push({
                title: `${subject.name} (${this.$e2bnumber(subject.code)})`,
                align: "left",
                class: "-rotate-90 -m-4",
            });
        });
    },
    props: {
        data: {
            type: Object,
            default: {},
        },
        signature: {
            type: String,
            default: "",
        },
    },
    data() {
        return {
            columns: [
                { title: "রোল", align: "right" },
                { title: "শিক্ষার্থী", align: "left" },
            ],
        };
    },
    methods: {
        getSubjectMark(student, subject) {
            let result = Object.values(this.data.results).find(
                (result) => Number(result.subject_code) === Number(subject.code)
            );

            if (!result) {
                return "";
            }

            let mark = result.marks.find(
                (mark) => Number(mark.student_id) === Number(student.id)
            );

            return mark && (mark.speaking !== "" || mark.writing !== "")
                ? Number(mark.speaking || 0) + Number(mark.writing || 0)
                : "";
        },
        getTotalMark(student) {
            let total = 0;

            Object.values(this.data.subjects).forEach((subject) => {
                let result = Object.values(this.data.results).find(
                    (result) =>
                        Number(result.subject_code) === Number(subject.code)
                );

                if (result) {
                    let mark = Object.values(result.marks).find(
                        (mark) => Number(mark.student_id) === Number(student.id)
                    );

                    if (mark) {
                        total += Number(mark.speaking) + Number(mark.writing);
                    }
                }
            });

            return total ? total : "";
        },
        getAverageMark(student) {
            let total = this.getTotalMark(student);

            let subjects_count = 0;

            Object.values(this.data.subjects).forEach((subject) => {
                if (
                    Number(subject.code) ===
                    Number(this.data.class.optional_subject_code)
                ) {
                    return;
                }

                let result = Object.values(this.data.results).find(
                    (result) =>
                        Number(result.subject_code) === Number(subject.code)
                );

                if (result) {
                    let mark = Object.values(result.marks).find(
                        (mark) => Number(mark.student_id) === Number(student.id)
                    );

                    if (mark) {
                        if (mark.speaking !== "" || mark.writing !== "") {
                            subjects_count++;
                        }
                    }
                }
            });

            return subjects_count && total
                ? Number(total / subjects_count).toFixed(2)
                : "";
        },
        getMinSubjectMark(student) {
            const markArray = [];

            Object.values(this.data.subjects).forEach((subject) => {
                if (
                    Number(subject.code) ===
                    Number(this.data.class.optional_subject_code)
                ) {
                    return;
                }

                let result = Object.values(this.data.results).find(
                    (result) =>
                        Number(result.subject_code) === Number(subject.code)
                );

                if (result) {
                    let mark = Object.values(result.marks).find(
                        (mark) => Number(mark.student_id) === Number(student.id)
                    );

                    if (mark) {
                        if (mark.speaking !== "" || mark.writing !== "") {
                            markArray.push(
                                Number(mark.speaking) + Number(mark.writing)
                            );
                        }
                    }
                }
            });

            return Math.min.apply(
                Math,
                markArray.map((mark) => Number(mark))
            );
        },
        getGrade(student) {
            let min = this.getMinSubjectMark(student);

            if (min < 35) {
                return "F";
            }

            let average = this.getAverageMark(student);

            if (average === "") {
                return "";
            }

            if (average >= 80) {
                return "A+";
            }

            if (average >= 70) {
                return "A";
            }

            if (average >= 60) {
                return "A-";
            }

            if (average >= 50) {
                return "B";
            }

            if (average >= 40) {
                return "C";
            }

            if (average >= 33) {
                return "D";
            }

            return "F";
        },
        getMeritList(student) {
            let totalMark = this.getTotalMark(student);

            if (totalMark === "") {
                return "-";
            }

            let markArray = [];

            Object.values(this.data.students).forEach((student) => {
                let total = this.getTotalMark(student);

                total &&
                    this.getGrade(student) !== "F" &&
                    markArray.push(total);
            });

            markArray.sort((a, b) => a - b).reverse();

            let markSet = new Set([...markArray]);

            markArray = [...markSet];

            let meritPosition = markArray.indexOf(totalMark) + 1;

            return this.getMeritTextByPosition(meritPosition);
        },
        getMeritTextByPosition(position) {
            if(parseInt(position) === 0) {
                return "-";
            }

            return position;
        },
    },
};
</script>
