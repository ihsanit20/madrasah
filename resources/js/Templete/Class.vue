<template>
    <div class="bg-white px-10 py-8">
        <letter-head class="hidden print:block" />
        <div class="flex flex-col items-center justify-center pt-3">
            <h2 class="text-3xl font-bold text-sky-600 print:text-black">
                {{ data.classes.name }}
            </h2>
            <p class="font-semibold text-gray-500 print:text-black">
                ক্লাস কোড: {{ $e2bnumber(data.classes.code) }}
            </p>
        </div>
        <div
            class="mt-4 text-justify text-base text-gray-700 print:text-black"
            v-html="data.classes.description"
        ></div>

        <form-heading class="mt-4">বিষয় ও পুস্তক তালিকা</form-heading>

        <simple-table
            class="py-3"
            :columns="subjectColumns"
            :collections="data.classes.subjects"
        >
            <template #default="{ item: subject }">
                <table-td class="text-center">
                    {{ $e2bnumber(subject.code) }}
                </table-td>
                <table-td class="text-left">
                    {{ subject.name }}
                </table-td>
                <table-td class="text-left">
                    {{ subject.book }}
                </table-td>
            </template>
        </simple-table>

        <form-heading class="mt-4">প্রদেয় ফি সমূহ</form-heading>

        <div class="flex gap-4">
            <simple-table
                class="flex-1 py-3"
                :columns="feeColumns1"
                :collections="data.classes.fees"
            >
                <template #default="{ item: fee }">
                    <table-td v-if="fee.period == 1" class="text-left">
                        {{ fee.name }}
                    </table-td>
                    <table-td v-if="fee.period == 1" class="text-right">
                        {{ $e2bnumber(fee.amount) }} &nbsp;টাকা
                    </table-td>
                </template>
            </simple-table>

            <simple-table
                class="flex-1 py-3"
                :columns="feeColumns2"
                :collections="data.classes.fees"
            >
                <template #default="{ item: fee }">
                    <table-td v-if="fee.period == 2" class="text-left">
                        {{ fee.name }}
                    </table-td>
                    <table-td v-if="fee.period == 2" class="text-right">
                        {{ $e2bnumber(fee.amount) }} &nbsp;টাকা
                    </table-td>
                </template>
            </simple-table>
        </div>
    </div>
</template>

<script>
import AppLayout from "@/Layouts/App.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import ShowTableRow from "@/Components/ShowTableRow.vue";
import ActionButtonEdit from "@/Components/ActionButtonEdit.vue";
import SimpleTable from "@/Components/SimpleTable.vue";
import TableTd from "@/Components/TableTd.vue";
import LetterHead from "@/Templete/LetterHead.vue";
import PrintButton from "@/Components/PrintButton.vue";
import { PencilAltIcon } from "@heroicons/vue/solid";
import FormHeading from "@/Components/FormHeading.vue";

export default {
    components: {
        AppLayout,
        Head,
        Link,
        ShowTableRow,
        ActionButtonEdit,
        SimpleTable,
        TableTd,
        LetterHead,
        PrintButton,
        PencilAltIcon,
        FormHeading,
    },
    props: {
        data: {
            type: Object,
            default: {},
        },
    },
    data() {
        return {
            subjectColumns: [
                { title: "বিষয় কোড", align: "center" },
                { title: "বিষয়ের নাম", align: "left" },
                { title: "বইয়ের তালিকা", align: "left" },
            ],
            feeColumns1: [
                { title: "ভর্তিকালীন প্রদেয়", align: "left" },
                { title: "পরিমাণ", align: "right" },
            ],
            feeColumns2: [
                { title: "মাসিক প্রদেয়", align: "left" },
                { title: "পরিমাণ", align: "right" },
            ],
        };
    },
};
</script>
