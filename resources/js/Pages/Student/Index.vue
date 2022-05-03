<template>
    <Head title="Student" />

    <app-layout pageTitle="Students">
        <simple-table
            :collections="data.collections"
            :filters="data.filters"
            :columns="columns"
        >
            <template #default="{ item: student }">
                <table-td class="text-left">
                    {{ student.id }}
                </table-td>
                <table-td class="text-left">
                    <Link
                        :href="route('students.show', student.id)"
                        class="text-sky-600 hover:underline"
                    >
                        {{ student.name }}
                    </Link>
                </table-td>
                <table-td class="text-left">
                    {{ student.registration }}
                </table-td>
                <table-td class="text-left">
                    {{ student.currentClassName }}
                </table-td>
                <table-td class="text-left">
                    {{ student.currentClassRoll }}
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
                { title: "ID", align: "left", sticky: true },
                { title: "Name", align: "left" },
                { title: "Registration", align: "left" },
                { title: "Class", align: "left" },
                { title: "Roll", align: "left" },
            ],
        };
    },
};
</script>
