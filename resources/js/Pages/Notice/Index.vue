<template>
    <Head title="Notice" />

    <app-layout pageTitle="Notices" :addNewHref="route('notices.create')">
        <simple-table
            :collections="data.collections"
            :filters="data.filters"
            :columns="columns"
        >
            <template #default="{ item: notice }">
                <table-td class="text-left">
                    <div
                        class="overflow-hidden whitespace-normal break-all line-clamp-6"
                    >
                        {{ notice.formatedDate }}
                    </div>
                </table-td>
                <table-td class="text-left">
                    <Link
                        :href="route('notices.show', notice.id)"
                        class="text-sky-600 hover:underline"
                    >
                        {{ notice.title }}
                    </Link>
                </table-td>
                <table-td class="text-left">
                    <action-button-edit
                        :href="route('notices.edit', notice.id)"
                    />
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
                { title: "প্রকাশের তারিখ", align: "left" },
                { title: "বিষয়", align: "left" },
                { title: "Action", align: "center" },
            ],
        };
    },
};
</script>
