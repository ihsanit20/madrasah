<template>
    <Head title="আয় তালিকা" />

    <app-layout pageTitle="আয় তালিকা" :addNewHref="route('incomes.create')">
        <simple-table
            :collections="data.collections"
            :filters="data.filters"
            :columns="columns"
        >
            <template #default="{ item: income }">
                <table-td class="text-left">
                    <div
                        class="overflow-hidden whitespace-normal break-all line-clamp-6"
                    >
                        <Link
                            :href="route('incomes.edit', income.id)"
                            class="text-sky-600 hover:underline"
                        >
                            {{ income.id }}
                        </Link>
                    </div>
                </table-td>
                <table-td class="text-left">
                    {{ income.date }}
                </table-td>
                <table-td class="text-left">
                    {{ income.categoryName }}
                </table-td>
                <table-td class="text-left">
                    {{ income.staffName }}
                </table-td>
                <table-td class="text-right">
                    {{ income.amount }}
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
                { title: "তারিখ", align: "left" },
                { title: "খাত", align: "left" },
                { title: "আদায়কারী", align: "left" },
                { title: "টাকা", align: "right" },
            ],
        };
    },
};
</script>
