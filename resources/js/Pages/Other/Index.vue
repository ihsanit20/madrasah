<template>
    <Head title="টাকা জমার রশিদ" />

    <app-layout pageTitle="টাকা জমার রশিদ">
        <simple-table
            :collections="data.collections"
            :filters="data.filters"
            :columns="columns"
        >
            <template #default="{ item: payment }">
                <table-td class="text-left">
                    <Link
                        :href="route('payments.show', payment.id)"
                        class="text-brand-600 hover:underline"
                    >
                        {{ $e2bnumber(payment.id) }}
                    </Link>
                </table-td>
                <table-td class="text-left">
                    {{ payment.admission.studentName }}
                </table-td>
                <table-td class="text-left">
                    {{ $e2bnumber(payment.admission.roll) }}
                </table-td>
                <table-td class="text-left">
                    {{ payment.admission.className }}
                </table-td>
                <table-td class="text-left">
                    {{ payment.purposeText }}
                </table-td>
                <table-td class="text-right">
                    {{ $e2bnumber(payment.paid) }} TK
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
                { title: "রোল", align: "left" },
                { title: "ক্লাস", align: "left" },
                { title: "বাবদ", align: "left" },
                { title: "জমা", align: "right" },
            ],
        };
    },
};
</script>
