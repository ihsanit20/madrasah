<template>
    <Head title="টাকা জমার রশিদ" />

    <app-layout pageTitle="টাকা জমার রশিদ">
        <simple-table
            :collections="data.collections"
            :filters="data.filters"
            :columns="columns"
            :serialColumn="false"
        >
            <template #default="{ item: salary }">
                <table-td class="text-left">
                    <Link
                        :href="route('salaries.show', salary.id)"
                        class="text-brand-600 hover:underline"
                    >
                        {{ $e2bnumber(salary.id) }}
                    </Link>
                </table-td>
                <table-td class="text-left">
                    {{ salary?.staff?.name }}
                </table-td>
                <table-td class="text-left">
                    {{ salary.purpose_text }}
                </table-td>
                <table-td class="text-left">
                    {{ salary?.total }}
                </table-td>
                <table-td class="text-left">
                    {{ salary?.cut }}
                </table-td>
                <table-td class="text-right">
                    <b>{{ $e2bnumber(salary.paid) }}</b>
                </table-td>
            </template>
        </simple-table>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/GridApp.vue";
import { Head, Link } from "@inertiajs/vue3";
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
                { title: "স্টাফ", align: "left" },
                { title: "মাস", align: "left" },
                { title: "মোট", align: "left" },
                { title: "কর্তন", align: "left" },
                { title: "প্রদান", align: "right" },
            ],
        };
    },
};
</script>
