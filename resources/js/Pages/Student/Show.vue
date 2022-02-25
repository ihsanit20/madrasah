<template>
    <Head title="Student" />

    <app-layout pageTitle="View Class">
        <div class="max-w-2xl rounded border bg-white p-3 shadow md:p-4">
            <div class="flex items-end justify-between">
                <h2 class="flex-shrink text-lg font-bold text-sky-600">
                    {{ data.student.name }}
                </h2>
                <div class="flex items-center gap-2">
                    <action-button-edit
                        :href="route('students.edit', data.student.id)"
                    />
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/App.vue";
import { Head } from "@inertiajs/inertia-vue3";
import ShowTableRow from "@/Components/ShowTableRow.vue";
import ActionButtonEdit from "@/Components/ActionButtonEdit.vue";
import SimpleTable from "@/Components/SimpleTable.vue";
import TableTd from "@/Components/TableTd.vue";

export default {
    components: {
        AppLayout,
        Head,
        ShowTableRow,
        ActionButtonEdit,
        SimpleTable,
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
                { title: "Code", align: "left" },
                { title: "Name", align: "left" },
            ],
        };
    },
};
</script>
