<template>
    <Head title="Classes" />

    <app-layout pageTitle="View Class">
        <div class="max-w-2xl rounded border bg-white p-3 shadow md:p-4">
            <div class="flex items-end justify-between">
                <h2 class="flex-shrink text-lg font-bold text-sky-600">
                    {{ data.classes.name }}
                </h2>
                <div class="flex items-center gap-2">
                    <p
                        class="flex-shrink-0 rounded border px-2 font-semibold text-gray-500"
                    >
                        Code: {{ data.classes.code }}
                    </p>
                    <action-button-edit
                        :href="route('classes.edit', data.classes.id)"
                    />
                </div>
            </div>
            <hr class="my-1" />
            <p
                class="text-xs text-gray-400 md:text-base"
                v-html="data.classes.description"
            ></p>

            <simple-table
                class="py-3"
                :serialColumn="true"
                :columns="subjectColumns"
                :collections="data.classes.subjects"
            >
                <template #default="{ item: subject }">
                    <table-td class="text-left">
                        {{ subject.code }}
                    </table-td>
                    <table-td class="text-left">
                        {{ subject.name }}
                    </table-td>
                </template>
            </simple-table>

            <simple-table
                class="py-3"
                :serialColumn="true"
                :columns="feeColumns"
                :collections="data.classes.fees"
            >
                <template #default="{ item: fee }">
                    <table-td class="text-left">
                        {{ fee.name }}
                    </table-td>
                    <table-td class="text-center">
                        {{ fee.periodName }}
                    </table-td>
                    <table-td class="text-right">
                        {{ fee.amount }} TK
                    </table-td>
                </template>
            </simple-table>
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
            subjectColumns: [
                { title: "Code", align: "left" },
                { title: "Name", align: "left" },
            ],
            feeColumns: [
                { title: "Fee", align: "left" },
                { title: "Period", align: "center" },
                { title: "Amount", align: "right" },
            ],
        };
    },
};
</script>
