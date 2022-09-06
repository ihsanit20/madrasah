<template>
    <Head
        :title="`${data.exam.name} : ${data.class.name} ক্লাস এর বিষয় সমুহ`"
    />

    <app-layout
        :pageTitle="`${data.exam.name} : ${data.class.name} ক্লাস এর বিষয় সমুহ`"
    >
        <div class="flex items-center justify-start py-2">
            <Link
                :href="route('results.classes', [data.exam.id])"
                class="flex items-center justify-center gap-2 rounded-md bg-gray-600 px-4 py-1 text-white"
            >
                <ArrowLeftIcon class="w-5" />
                পূর্বের পেজ
            </Link>
        </div>
        <div class="">
            <simple-table :columns="columns" :collections="data.students">
                <template #default="{ item: student }">
                    <table-td class="text-left">
                        {{ student.name }}
                    </table-td>
                    <table-td class="text-center">
                        {{ $e2bnumber(student.roll) }}
                    </table-td>
                    <table-td
                        v-for="subject in data.subjects"
                        :key="subject.code"
                        class="text-center"
                    >
                        {{ getTotalMark(student, subject) }}
                    </table-td>
                </template>
            </simple-table>
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
    },
    created() {
        Object.values(this.data.subjects).forEach((subject) => {
            this.columns.push({
                title: `${subject.name} (${this.$e2bnumber(subject.code)})`,
                align: "left",
                rotate: "-rotate-90",
            });
        });
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
                { title: "শিক্ষার্থী", align: "left" },
                { title: "রোল", align: "right" },
            ],
        };
    },
    methods: {
        getTotalMark(student, subject) {
            let mark = student.marks.find(
                (mark) => Number(mark.subject_code) === Number(subject.code)
            );

            return mark
                ? Number(mark.speaking || 0) + Number(mark.writing || 0)
                : "";
        },
    },
};
</script>
