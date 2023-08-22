<template>
    <div
        class="w-full bg-white relative -z-20 overflow-hidden px-12 py-4 print:py-0 print:px-4"
    >
        <div class="absolute inset-0 w-full h-full -z-10 flex justify-center items-center">
            <img 
                class="opacity-10"
                :src="$page.props.settings.logoLink"
            />
        </div>

        <letter-head />

        <div class="mt-1.5 mb-2 flex items-center justify-center">
            <div
                class="rounded-md border px-4 py-0.5 text-center text-2xl font-bold print:border-black print:text-black"
            >
                বাৎসরিক চূড়ান্ত নম্বরপত্র
            </div>
        </div>

        <div
            class="mt-2 flex items-center justify-center gap-4 text-lg font-bold"
        >
            শিক্ষাবর্ষ ১৪{{ $e2bnumber($page.props.current_academic_session.value) }} হিজরি
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

        <br />

        <table class="w-full table-auto">
            <thead class="">
                <tr>
                    <th rowspan="2" class="border px-2 print:px-1">
                        বিষয় কোড
                    </th>
                    <th rowspan="2" class="border px-2 print:px-1">
                        বিষয়সমূহ
                    </th>
                    <th :colspan="Object.keys(data.exams).length" class="border px-2 print:px-1">
                        পরীক্ষার নাম ও প্রাপ্ত নাম্বর
                    </th>
                </tr>
                <tr>
                    <th
                        v-for="exam in data.exams"
                        :key="exam.id"
                        class="border px-2 print:px-1"
                    >
                        <div class="text-center">
                            {{ exam.name.replace(' পরীক্ষা', '') }}
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody class="">
                <tr
                    v-for="subject in data.class.subjects"
                    :key="subject.id"
                >
                    <td class="border p-2 text-center print:p-1">
                        {{ $e2bnumber(subject.code) }}
                    </td>
                    <td class="border p-2 text-left  print:p-1">
                        {{ subject.name }}
                    </td>
                    <td
                        v-for="exam in data.exams"
                        :key="exam.id"
                        class="border p-2 text-center  print:p-1"
                    >
                        {{ $e2bnumber(student.result[exam.id] ? (student.result[exam.id][subject.code] || 0) : "") }}
                    </td>
                </tr>
                <tr>
                    <th colspan="2" class="border p-2 text-right print:p-1">
                        মোট নাম্বার
                    </th>
                    <th
                        v-for="exam in data.exams"
                        :key="exam.id"
                        class="border px-2 print:px-1"
                    >
                        <div class="text-center">
                            {{ $e2bnumber(student.result[exam.id] ? student.result[exam.id].exam_total : "") }}
                        </div>
                    </th>
                </tr>
                <tr v-if="false">
                    <th colspan="2" class="border p-2 text-right print:p-1">
                        গড়
                    </th>
                </tr>
                <tr v-if="false">
                    <th colspan="2" class="border p-2 text-right print:p-1">
                        গ্রেড
                    </th>
                </tr>
                <tr v-if="false">
                    <th colspan="2" class="border p-2 text-right print:p-1">
                        মেধাক্রম
                    </th>
                </tr>
            </tbody>
        </table>

        <br />

        <table class="w-full table-auto">
            <thead class="">
                <tr>
                    <th colspan="2" class="border p-2 print:p-1">
                        চূড়ান্ত ফলাফল
                    </th>
                </tr>
            </thead>
            <tbody class="">
                <tr>
                    <td class="border p-2 text-right print:p-1 w-1/2">
                        চূূড়ান্ত নাম্বার
                        (<span
                            v-for="(exam, key) in data.exams"
                            :key="exam.id"
                            class="text-center"
                        >
                            <span v-if="key">+</span>
                            {{ $e2bnumber(exam.final_result_parcent) }}%
                        </span>)
                    </td>
                    <td class="border p-2 text-center print:p-1 w-1/2">
                        {{ $e2bnumber(student.total) }}
                    </td>
                </tr>
                <tr>
                    <td class="border p-2 text-right print:p-1 w-1/2">
                        চূূড়ান্ত মেধাক্রম
                    </td>
                    <td class="border p-2 text-center print:p-1 w-1/2">
                        {{ $e2bnumber(index + 1) }}
                    </td>
                </tr>
            </tbody>
        </table>

        <br />

        <table class="w-full table-auto">
            <thead class="">
                <tr>
                    <th colspan="2" class="border p-2 print:p-1">
                        স্বাক্ষর
                    </th>
                    <th colspan="2" class="border p-2 print:p-1">
                        মন্তব্য
                    </th>
                </tr>
            </thead>
            <tbody class="">
                <tr>
                    <td class="border h-14 px-2 text-right print:p-1 w-1/4">
                        অধ্যক্ষ
                    </td>
                    <td class="border h-14 px-2 text-center print:px-1 w-1/4">
                        <div class="h-12 flex justify-center items-center">
                            <img
                                v-if="signature"
                                :src="signature"
                                class="h-12 w-auto object-contain"
                            />
                        </div>
                    </td>
                    <td colspan="2" class="border h-14 px-2 text-center print:p-1 w-1/2">
                        
                    </td>
                </tr>
                <tr>
                    <td class="border h-14 px-2 text-right print:p-1 w-1/4">
                        শ্রেণী শিক্ষক
                    </td>
                    <td class="border h-14 px-2 text-center print:px-1 w-1/4">
                        <div class="h-12 flex justify-center items-center">
                            
                        </div>
                    </td>
                    <td colspan="2" class="border h-14 px-2 text-center print:p-1 w-1/2">
                        
                    </td>
                </tr>
                <tr>
                    <td class="border h-14 p-2 text-right print:p-1 w-1/4">
                        অভিভাবক
                    </td>

                    <td class="border h-14 px-2 text-center print:px-1 w-1/4">
                        <div class="h-12 flex justify-center items-center">

                        </div>
                    </td>
                    <td colspan="2" class="border h-14 p-2 text-center print:p-1 w-1/2">
                        
                    </td>
                </tr>
            </tbody>
        </table>

        <br />

        <div class="border p-2 print:p-1">
            নির্দেশনা
        </div>
        <div class="pl-6 py-2">
            <ul class="list-disc print:p-1 print:text-black">
                <li>এই নম্বরপত্রে শিক্ষার্থী কলম বা পেন্সিল দিয়ে কোনো দাগ দিবে না।</li>
                <li>অবশ্যই অভিবাবকের স্বাক্ষর নিয়ে ৭ দিনের মধ্যে এক কপি মাদরাসা অফিসে জমা দিতে হবে।</li>
                <li>নম্বরপত্র হারিয়ে গেলে বা নষ্ট হলে নির্দিষ্ট পরিমাণ ফি দিয়ে ডুপ্লিকেট কপি নিতে হবে।</li>
                <li>এই নম্বরপত্রটি উপরোক্ত শিক্ষার্থী ও তার অভিভাবক ব্যতীত হস্তান্তর যোগ্য নয়।</li>
            </ul>
        </div>
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
        signature: {
            type: String,
            default: "",
        },
        index: {
            type: Number,
            default: 0,
        },
    },
    data() {
        return {
            //
        };
    },
    methods: {
        //
    },
};
</script>
