<template>
    <Head title="টাকা জমার রশিদ" />

    <app-layout
        pageTitle="টাকা জমার রশিদ"
        :addNewHref="route('payments.create')"
    >
        <simple-table
            :collections="data.collections"
            :filters="data.filters"
            :columns="columns"
        >
            <template #default="{ item: payment }">
                <table-td class="text-left">
                    <Link
                        :href="route('payments.show', payment.id)"
                        class="text-sky-600 hover:underline"
                    >
                        {{ payment.id }}
                    </Link>
                </table-td>
                <table-td class="text-left">
                    <div
                        class="overflow-hidden whitespace-normal break-all line-clamp-6"
                    >
                        {{ payment.admission.studentName }}
                        <b>({{ payment.admission.student.registration }})</b>
                    </div>
                </table-td>
                <table-td class="text-right">
                    <div
                        class="overflow-hidden whitespace-normal break-all line-clamp-6"
                    >
                        {{ payment.total }} TK
                    </div>
                </table-td>
                <table-td class="text-right">
                    <div
                        class="overflow-hidden whitespace-normal break-all line-clamp-6"
                    >
                        {{ payment.paid }} TK
                    </div>
                </table-td>
                <table-td class="text-right">
                    <div
                        class="overflow-hidden whitespace-normal break-all line-clamp-6"
                    >
                        {{ payment.due }} TK
                    </div>
                </table-td>
            </template>
        </simple-table>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/App.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import SimpleTable from "@/Components/DataTable.vue";
import ActionButtonShow from "@/Components/ActionButtonShow.vue";
import ActionButtonEdit from "@/Components/ActionButtonEdit.vue";
import AddNewButton from "@/Components/AddNewButton.vue";
import TableTd from "@/Components/TableTd.vue";

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
                { title: "রশিদ নং", align: "left" },
                { title: "শিক্ষার্থী", align: "left" },
                { title: "মোট", align: "right" },
                { title: "জমা", align: "right" },
                { title: "বকেয়া", align: "right" },
            ],
        };
    },
};
</script>
