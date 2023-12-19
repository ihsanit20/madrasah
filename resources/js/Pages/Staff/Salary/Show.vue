<template>
    <Head title="Payment" />

    <app-layout>
        <div class="flex max-w-lg items-center justify-end print:hidden">
            <print-button />
        </div>

        <div
            class="grid w-full max-w-lg gap-4 rounded-lg border bg-white p-4 print:border-none"
        >
            <LetterHead />
            <div class="grid w-full grid-cols-2 gap-4 print:grid-cols-2">
                <div class="text-left">
                    রশিদ নং: <b>{{ $e2bnumber(salary.id) }}</b>
                </div>
                <div class="text-right">
                    তারিখ: <b>{{ $e2bnumber(salary.created_at_as_text) }}</b>
                </div>
                <div class="text-left">
                    নাম: <b>{{ salary?.staff?.name }}</b>
                </div>
                <div class="text-right">
                    পদবি:
                    <b>
                        {{
                            salary?.staff?.current_appointment?.designation
                                ?.name
                        }}
                    </b>
                </div>
                <div class="col-span-full flex items-center justify-center">
                    <div
                        class="col-span-full rounded-full border bg-gray-200 px-3 pt-1 text-center font-bold"
                    >
                        {{ salary?.purpose_text }}
                    </div>
                </div>
            </div>
            <div class="grid w-full">
                <div
                    class="flex justify-between bg-gray-200 py-2 px-3 font-bold"
                >
                    <div>বেতনের বিবরণ</div>
                    <div>নির্ধারিত টাকা</div>
                </div>
                <template v-for="salaryDetails in salary.salaries">
                    <div class="flex justify-between py-2 px-3 font-bold">
                        <div>{{ salaryDetails.title }}</div>
                        <div>{{ $e2bnumber(salaryDetails.amount) }}</div>
                    </div>
                </template>
                <div
                    class="flex justify-end gap-2 border-t py-2 px-3 font-bold"
                >
                    <div>মোট:</div>
                    <div>{{ $e2bnumber(salary.total) }}</div>
                </div>
                <div
                    class="flex justify-end gap-2 border-t py-2 px-3 font-bold"
                >
                    <div>কর্তন:</div>
                    <div>{{ $e2bnumber(salary.cut) }}</div>
                </div>
                <div
                    class="flex justify-end gap-2 border-t py-2 px-3 font-bold"
                >
                    <div>প্রদান:</div>
                    <div>{{ $e2bnumber(salary.paid) }}</div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/GridApp.vue";
import { Head } from "@inertiajs/vue3";
import PrintButton from "@/Components/PrintButton.vue";
import LetterHead from "../../../Templete/LetterHead.vue";

export default {
    components: {
        AppLayout,
        Head,
        PrintButton,
        LetterHead,
    },
    props: {
        salary: {
            type: Object,
            default: {},
        },
    },
};
</script>
