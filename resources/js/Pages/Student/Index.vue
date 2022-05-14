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
                    {{ $e2bnumber(student.currentClassRoll) }}
                </table-td>
                <table-td class="text-left">
                    <Link
                        v-if="false"
                        :href="route('students.show', student.id)"
                        class="text-sky-600 hover:underline"
                    >
                        {{ student.name }}
                    </Link>
                    {{ student.name }}
                </table-td>
                <table-td class="text-left">
                    {{ student.currentClassName }}
                </table-td>
                <table-td class="text-left">
                    {{ student.registration }}
                </table-td>
                <table-td class="text-center">
                    <Link
                        :href="
                            route('payments.create') +
                            '?registration=' +
                            student.registration
                        "
                        class="rounded bg-sky-600 px-4 py-1 font-semibold text-white"
                    >
                        টাকা জমা নিন
                    </Link>
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
                { title: "রোল", align: "left", sticky: true },
                { title: "নাম", align: "left" },
                { title: "ক্লাস/বিভাগ", align: "left" },
                { title: "রেজিঃ নং", align: "left" },
                { title: "রশিদ", align: "center" },
            ],
        };
    },
};
</script>
