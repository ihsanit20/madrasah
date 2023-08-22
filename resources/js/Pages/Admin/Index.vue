<template>
    <Head title="Admin" />

    <app-layout pageTitle="Admins" :addNewHref="route('admins.create')">
        <simple-table
            :collections="data.collections"
            :filters="data.filters"
            :columns="columns"
        >
            <template #default="{ item: admin }">
                <table-td class="text-left">
                    <Link
                        :href="route('admins.show', admin.id)"
                        class="text-brand-600 hover:underline"
                    >
                        {{ admin.name }}
                    </Link>
                </table-td>
                <table-td class="text-left">
                    <div
                        class="overflow-hidden whitespace-normal break-all line-clamp-6"
                    >
                        {{ admin.email }}
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
                { title: "Name", align: "left" },
                { title: "Email", align: "left" },
            ],
        };
    },
};
</script>
