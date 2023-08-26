<template>
    <Head title="পদবি তালিকা" />

    <app-layout
        pageTitle="পদবি তালিকা"
        :addNewHref="route('designations.create')"
    >
        <simple-table
            :collections="data.collections"
            :filters="data.filters"
            :columns="columns"
        >
            <template #default="{ item: designation }">
                <table-td class="text-left">
                    <div
                        class="overflow-hidden whitespace-normal break-all line-clamp-6"
                    >
                        <Link
                            :href="route('designations.edit', designation.id)"
                            class="text-brand-600 hover:underline"
                        >
                            {{ designation.name }}
                        </Link>
                    </div>
                </table-td>
                <table-td class="text-center">
                    {{ designation.totalTeacher }}
                </table-td>
                <table-td class="w-10 text-right">
                    <action-button-delete
                        v-if="designation.allowDeletion"
                        :href="route('designations.destroy', designation.id)"
                    />
                </table-td>
            </template>
        </simple-table>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/GridApp.vue";
import { Head, Link } from "@inertiajs/vue3";
import SimpleTable from "@/Components/DataTable.vue";
import ActionButtonShow from "@/Components/ActionButtonShow.vue";
import ActionButtonEdit from "@/Components/ActionButtonEdit.vue";
import AddNewButton from "@/Components/AddNewButton.vue";
import TableTd from "@/Components/TableTd.vue";
import ActionButtonDelete from "@/Components/ActionButtonDelete.vue";

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
        ActionButtonDelete,
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
                { title: "পদবি তালিকা", align: "left" },
                { title: "শিক্ষক/স্টাফ সংখ্যা", align: "center" },
                { title: "", align: "right" },
            ],
        };
    },
};
</script>
