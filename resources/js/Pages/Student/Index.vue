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
                    {{ student.name }}
                </table-td>
                <table-td class="text-left">
                    {{ student.registration }}
                </table-td>
                <table-td class="text-center">
                    <div
                        class="flex items-center justify-center gap-1 md:gap-2"
                    >
                        <action-button-show
                            :href="route('students.show', student.id)"
                        />
                        <action-button-edit
                            :href="route('students.edit', student.id)"
                        />
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
                { title: "ID", align: "left", sticky: true },
                { title: "Name", align: "left" },
                { title: "Registration", align: "left" },
                { title: "Action", align: "center" },
            ],
        };
    },
};
</script>
