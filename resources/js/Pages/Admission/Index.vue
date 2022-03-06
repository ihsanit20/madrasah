<template>
    <Head title="Admission" />

    <app-layout pageTitle="Admissions" :addNewHref="route('admissions.create')">
        <simple-table
            :collections="data.collections"
            :filters="data.filters"
            :columns="columns"
        >
            <template #default="{ item: admission }">
                <table-td class="text-left">
                    {{ admission.id }}
                </table-td>
                <table-td class="text-left">
                    {{ admission.studentName }}
                </table-td>
                <table-td class="text-left">
                    {{ admission.className }}
                </table-td>
                <table-td class="text-center">
                    {{ admission.roll }}
                </table-td>
                <table-td class="text-center">
                    {{ admission.year }}
                </table-td>
                <table-td class="text-center">
                    <div
                        class="flex items-center justify-center gap-1 md:gap-2"
                    >
                        <action-button-show
                            :href="route('admissions.show', admission.id)"
                        />
                        <action-button-edit
                            :href="route('admissions.edit', admission.id)"
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
                { title: "Student Name", align: "left" },
                { title: "Class", align: "left" },
                { title: "Roll", align: "center" },
                { title: "Year", align: "center" },
                { title: "Action", align: "center" },
            ],
        };
    },
};
</script>
