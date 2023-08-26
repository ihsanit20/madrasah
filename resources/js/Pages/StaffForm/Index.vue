<template>
    <Head title="শিক্ষক/স্টাফ ফরম" />

    <app-layout pageTitle="শিক্ষক/স্টাফ ফরম" :addNewHref="route('staff-form.create')">
        <simple-table
            :collections="data.collections"
            :filters="data.filters"
            :columns="columns"
        >
            <template #default="{ item: staffForm }">
                <table-td class="text-left">
                    <Link
                        :href="route('staff-form.show', staffForm.id)"
                        class="text-brand-600 hover:underline"
                    >
                        {{ staffForm.id }}
                    </Link>
                </table-td>
                <table-td class="text-left">
                    <Link
                        :href="route('staff-form.show', staffForm.id)"
                        class="text-brand-600 hover:underline"
                    >
                        {{ staffForm.name }}
                    </Link>
                </table-td>
                <table-td class="text-left">
                    <div
                        class="overflow-hidden whitespace-normal break-all line-clamp-6"
                    >
                        {{ staffForm.designation_title }}
                    </div>
                </table-td>
                <table-td class="text-left">
                    <div
                        class="overflow-hidden whitespace-normal break-all line-clamp-6"
                    >
                        {{ staffForm.phone }}
                    </div>
                </table-td>
                <table-td class="w-10 text-right">
                    <action-button-delete
                        v-if="staffForm.allowDeletion"
                        :href="route('staff-form.destroy', staffForm.id)"
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
                { title: "ফরম নাম্বার", align: "left", sticky: true },
                { title: "নাম", align: "left" },
                { title: "পদবি", align: "left" },
                { title: "ফোন", align: "left" },
                { title: "", align: "right" },
            ],
        };
    },
};
</script>
