<template>
    <Head
        :title="`${data.class.name} ক্লাস এর চূড়ান্ত ফলাফল`"
    />

    <app-layout
        :pageTitle="`${data.class.name} ক্লাস এর চূড়ান্ত ফলাফল`"
    >
        <div class="flex items-center justify-between py-2 print:hidden">
            <Link
                :href="route('results.final.classes')"
                class="flex items-center justify-center gap-2 rounded-md bg-gray-600 px-4 py-1 text-white"
            >
                <ArrowLeftIcon class="w-5" />
                পূর্বের পেজ
            </Link>
            <Link
                :href="route('results.final.result-cards', [data.class.id])"
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

            <div class="mt-1.5 mb-2 flex items-center justify-center">
                <div
                    class="rounded-md border px-4 py-0.5 text-center text-xl font-bold print:border-black print:text-black"
                >
                    চূড়ান্ত ফলাফল : {{ $e2bnumber($page.props.current_academic_session.value) }} হিজরি
                </div>
            </div>

            <div class="flex items-center justify-center gap-1">
                <div class="">শ্রেণী</div>
                <span>:</span>
                <div>{{ data.class.name }}</div>
            </div>

            <table class="w-full table-auto print:text-xs">
                <thead class="">
                    <tr>
                        <th class="border p-2 print:p-1">রোল</th>
                        <th class="border p-2 print:p-1">শিক্ষার্থী</th>
                        <th
                            v-for="exam in data.exams"
                            :key="exam.id"
                            class="border p-2 print:p-1"
                        >
                            <div class="text-center">
                                {{ exam.name }}
                            </div>
                        </th>
                        <th
                            class="border p-2 print:p-1"
                        >
                            <span
                                v-for="(exam, key) in data.exams"
                                :key="exam.id"
                                class="text-center"
                            >
                                <span v-if="key">+</span>
                                {{ $e2bnumber(exam.final_result_parcent) }}%
                            </span>
                        </th>
                    </tr>
                </thead>
                <tbody class="">
                    <tr
                        v-for="(student, index) in data.students"
                        :key="index"
                        class="hover:bg-gray-100 dark:hover:bg-gray-700"
                    >
                        <td class="border p-2 text-center print:p-1">
                            {{ $e2bnumber(student.roll) }}
                        </td>
                        <td class="border p-2 text-left print:p-1">
                            {{ student.name }}
                        </td>
                        <td
                            v-for="exam in data.exams"
                            :key="exam.id"
                            class="border p-2 print:p-1"
                        >
                            <div class="text-center">
                                {{ $e2bnumber(Object.values(student.result[exam.id]).reduce((a, b) => a + b, 0)) }}
                            </div>
                        </td>
                        <td
                            class="border p-2 print:p-1"
                        >
                            <div class="text-center">
                                {{ $e2bnumber(student.total) }}
                            </div>
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
            //
        };
    },
    methods: {
        //
    },
};
</script>
