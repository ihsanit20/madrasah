<template>
    <div
        class="w-full bg-white bg-[url('/images/wmlogo.png')] bg-center bg-no-repeat px-12 py-4 print:py-0 print:px-4"
    >
        <letter-head />

        <div
            class="mt-2 flex items-center justify-center gap-4 text-lg font-bold"
        >
            <div>{{ data.exam.name }}</div>
            <div>{{ $e2bnumber(data.exam.session) }} হিজরি</div>
        </div>

        <div class="mt-1.5 mb-2 flex items-center justify-center">
            <div
                class="rounded-md border px-4 py-0.5 text-center text-2xl font-bold print:border-black print:text-black"
            >
                রেজাল্ট কার্ড
            </div>
        </div>

        <div class="grid grid-cols-5">
            <div class="col-span-3 flex gap-2">
                <div class="w-24 text-gray-500 print:text-black">
                    শিক্ষার্থীর নাম
                </div>
                <span>:</span>
                <div>{{ student.name }}</div>
            </div>
            <div class="col-span-2 flex gap-2">
                <div class="w-20 text-gray-500 print:text-black">রেজি. নং</div>
                <span>:</span>
                <div>{{ $e2bnumber(student.registration) }}</div>
            </div>
            <div class="col-span-3 flex gap-2">
                <div class="w-24 text-gray-500 print:text-black">শ্রেণী</div>
                <span>:</span>
                <div>{{ data.class.name }}</div>
            </div>
            <div class="col-span-2 flex gap-2">
                <div class="w-20 text-gray-500 print:text-black">
                    শ্রেণী রোল
                </div>
                <span>:</span>
                <div>{{ $e2bnumber(student.roll) }}</div>
            </div>
        </div>

        <hr class="my-4" />

        <table class="w-full table-auto">
            <thead class="">
                <tr>
                    <th class="border p-2 print:p-1">বিষয় কোড</th>
                    <th class="border p-2 print:p-1">বিষয় নাম</th>
                    <th class="border p-2 print:p-1">মৌখিক</th>
                    <th class="border p-2 print:p-1">লিখিত</th>
                    <th class="border p-2 print:p-1">মোট</th>
                </tr>
            </thead>
            <tbody class="">
                <tr
                    v-for="subject in data.subjects"
                    :key="subject.code"
                    class="hover:bg-gray-100 dark:hover:bg-gray-700"
                >
                    <th class="border p-2 print:p-1">
                        {{ $e2bnumber(subject.code) }}
                    </th>
                    <th class="border p-2 text-left print:p-1">
                        {{ subject.name }}
                    </th>
                    <th class="border p-2 text-center print:p-1">
                        {{ $e2bnumber(getSubjectWritingMark(subject.code)) }}
                    </th>
                    <th class="border p-2 text-center print:p-1">
                        {{ $e2bnumber(getSubjectSpeakingMark(subject.code)) }}
                    </th>
                    <th class="border p-2 text-center print:p-1">
                        {{ $e2bnumber(getSubjectTotalMark(subject.code)) }}
                    </th>
                </tr>
                <tr>
                    <th colspan="2"></th>
                    <th colspan="2" class="border p-2 text-right print:p-1">
                        মোট
                    </th>
                    <th class="border p-2 text-center print:p-1">
                        {{ $e2bnumber(getTotalMark()) }}
                    </th>
                </tr>
                <tr>
                    <th colspan="2"></th>
                    <th colspan="2" class="border p-2 text-right print:p-1">
                        গড়
                    </th>
                    <th class="border p-2 text-center print:p-1">
                        {{ $e2bnumber(getAverageMark()) }}
                    </th>
                </tr>
                <tr>
                    <th colspan="2"></th>
                    <th colspan="2" class="border p-2 text-right print:p-1">
                        গ্রেড
                    </th>
                    <th class="border p-2 text-center print:p-1">
                        {{ $e2bnumber(getGrade()) }}
                    </th>
                </tr>
                <tr>
                    <th colspan="2"></th>
                    <th colspan="2" class="border p-2 text-right print:p-1">
                        মেধাক্রম
                    </th>
                    <th class="border p-2 text-center print:p-1">
                        {{ $e2bnumber(getMeritList()) }}
                    </th>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import LetterHead from "@/Templete/LetterHead.vue";
export default {
    components: {
        LetterHead,
    },

    props: {
        data: {
            type: Object,
            default: {},
        },
        student: {
            type: Object,
            default: {},
        },
    },
    data() {
        return {
            //
        };
    },
    methods: {
        getSubjectMark(subject_code) {
            return this.student.results[Number(subject_code)];
        },
        getSubjectWritingMark(subject_code) {
            let writing = this.getSubjectMark(subject_code)["writing"];

            return writing === null ? "" : writing;
        },
        getSubjectSpeakingMark(subject_code) {
            let speaking = this.getSubjectMark(subject_code)["speaking"];

            return speaking === null ? "" : speaking;
        },
        getSubjectTotalMark(subject_code) {
            return (
                parseInt(this.getSubjectWritingMark(subject_code) || 0) +
                parseInt(this.getSubjectSpeakingMark(subject_code) || 0)
            );
        },
        getTotalMark() {
            let total = 0;

            Object.values(this.student.results).forEach((result) => {
                total += parseInt(result["writing"] || 0);
                total += parseInt(result["speaking"] || 0);
            });

            return total;
        },
        getStudentTotalMark(student) {
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
        getAverageMark() {
            let total = this.getTotalMark();

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
                        (mark) =>
                            Number(mark.student_id) === Number(this.student.id)
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
        getMinSubjectMark() {
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
                        (mark) =>
                            Number(mark.student_id) === Number(this.student.id)
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
        getGrade() {
            let min = this.getMinSubjectMark();

            if (min < 35) {
                return "F";
            }

            let average = this.getAverageMark();

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
        getMeritList() {
            let totalMark = this.getTotalMark();

            if (totalMark === "") {
                return "";
            }

            let markArray = [];

            Object.values(this.data.students).forEach((student) => {
                let total = this.getStudentTotalMark(student);

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
            if (position === 1) {
                return "১ম";
            }

            if (position === 2) {
                return "২য়";
            }

            if (position === 3) {
                return "৩য়";
            }

            return "-";
        },
    },
};
</script>
