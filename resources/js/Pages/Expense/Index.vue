<template>
    <Head title="ব্যয়ের তালিকা" />

    <app-layout
        pageTitle="ব্যয়ের তালিকা"
        :addNewHref="route('expenses.create')"
    >
        <simple-table
            :collections="data.collections"
            :filters="data.filters"
            :columns="columns"
        >
            <template #default="{ item: expense }">
                <table-td class="text-left">
                    <div
                        class="overflow-hidden whitespace-normal break-all line-clamp-6"
                    >
                        <Link
                            :href="route('expenses.edit', expense.id)"
                            class="text-sky-600 hover:underline"
                        >
                            {{ expense.id }}
                        </Link>
                    </div>
                </table-td>
                <table-td class="text-left">
                    {{ expense.date }}
                </table-td>
                <table-td class="text-left">
                    {{ expense.categoryName }}
                </table-td>
                <table-td class="text-left">
                    {{ expense.staffName }}
                </table-td>
                <table-td class="text-right">
                    {{ expense.amount }}
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
                { title: "ভাউচার নং", align: "left" },
                { title: "তারিখ", align: "left" },
                { title: "খাত", align: "left" },
                { title: "ব্যয়কারী", align: "left" },
                { title: "টাকা", align: "right" },
            ],
        };
    },
};
</script>
