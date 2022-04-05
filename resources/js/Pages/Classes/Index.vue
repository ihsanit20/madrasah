<template>
    <Head title="Classes" />

    <app-layout pageTitle="Classes" :addNewHref="route('classes.create')">
        <data-table
            :collections="data.collections"
            :filters="data.filters"
            :columns="columns"
        >
            <template #default="{ item: classes }">
                <table-td class="text-center">
                    {{ classes.code }}
                </table-td>
                <table-td class="text-left">
                    <Link
                        :href="route('classes.show', classes.id)"
                        class="text-sky-600 hover:underline"
                    >
                        {{ classes.name }}
                    </Link>
                </table-td>
                <table-td class="text-center">
                    {{ classes.totalStudent }}
                </table-td>
                <table-td class="text-center">
                    {{ classes.totalSubject }}
                </table-td>
                <table-td class="text-center">
                    {{ classes.totalFee }}
                </table-td>
            </template>
        </data-table>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/App.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import DataTable from "@/Components/DataTable.vue";
import ActionButtonShow from "@/Components/ActionButtonShow.vue";
import ActionButtonEdit from "@/Components/ActionButtonEdit.vue";
import AddNewButton from "@/Components/AddNewButton.vue";
import TableTd from "@/Components/TableTd.vue";

export default {
    components: {
        AppLayout,
        DataTable,
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
                { title: "Code", align: "center" },
                { title: "Name", align: "left" },
                { title: "Students", align: "center" },
                { title: "Subjects", align: "center" },
                { title: "Fees", align: "center" },
            ],
        };
    },
};
</script>
