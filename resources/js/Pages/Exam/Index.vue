<template>
    <Head title="Exam" />

    <app-layout pageTitle="Exams" :addNewHref="route('exams.create')">
        <simple-table
            :collections="data.collections"
            :filters="data.filters"
            :columns="columns"
        >
            <template #default="{ item: exam }">
                <table-td class="text-left">
                    {{ exam.name }}
                </table-td>
                <table-td class="text-left">
                    {{ $e2bnumber(exam.session) }}
                </table-td>
                <table-td class="text-center">
                    <div class="flex justify-center gap-2">
                        <action-button-show
                            :href="route('exams.show', exam.id)"
                        />
                        <action-button-edit
                            :href="route('exams.edit', exam.id)"
                        />
                    </div>
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
                { title: "পরীক্ষার নাম", align: "left" },
                { title: "সেশন", align: "left" },
                { title: "Action", align: "center" },
            ],
        };
    },
};
</script>
