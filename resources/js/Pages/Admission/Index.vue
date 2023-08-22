<template>
    <Head title="ভর্তির আবেদন তালিকা" />

    <app-layout>
        <div
            class="w-full flex flex-wrap items-end justify-between gap-4 print:hidden"
        >
            <h2
                class="flex-shrink flex-grow text-xl font-bold leading-5 text-gray-700"
            >
                ভর্তির আবেদন তালিকা
            </h2>
            <a
                target="_blank"
                href="/images/admission-blank-form.pdf"
                class="flex items-center justify-center gap-2 rounded border border-brand-600 px-4 py-0.5 text-brand-600"
            >
                ব্লাঙ্ক ফরম
            </a>
            <Link
                :href="route('admissions.create')"
                class="flex flex-shrink-0 flex-grow-0 items-center justify-center gap-1 rounded bg-brand-600 px-2.5 py-0.5 text-white"
            >
                <span>+</span>
                <span class="hidden md:block">নতুন যোগ করুন</span>
            </Link>
        </div>

        <simple-table
            :collections="data.collections"
            :filters="data.filters"
            :columns="columns"
        >
            <template #default="{ item: admission }">
                <table-td class="text-left">
                    <Link
                        :href="route('admissions.show', admission.id)"
                        class="text-brand-600 hover:underline"
                    >
                        {{ $e2bnumber(admission.id) }}
                    </Link>
                </table-td>
                <table-td class="text-left">
                    {{ admission.studentName }}
                </table-td>
                <table-td class="text-left">
                    {{ admission.student.fatherInfo.name }}
                </table-td>
                <table-td class="text-left">
                    {{ admission.className }}
                </table-td>
            </template>
        </simple-table>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/GridApp.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import SimpleTable from "@/Components/DataTable.vue";
import ActionButtonShow from "@/Components/ActionButtonShow.vue";
import ActionButtonEdit from "@/Components/ActionButtonEdit.vue";
import AddNewButton from "@/Components/AddNewButton.vue";
import TableTd from "@/Components/TableTd.vue";
import AdmissionFormBlankTemplete from "@/Templete/AdmissionFormBlank.vue";

export default {
    components: {
        AppLayout,
        SimpleTable,
        Head,
        Link,
        ActionButtonShow,
        ActionButtonEdit,
        AddNewButton,
        TableTd,
        AdmissionFormBlankTemplete,
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
                { title: "ফরম নাম্বার", align: "left", sticky: true },
                { title: "শিক্ষার্থীর নাম", align: "left" },
                { title: "পিতার নাম", align: "left" },
                { title: "ভর্তিচ্ছু বিভাগ/শ্রেণী", align: "left" },
            ],
        };
    },
};
</script>
