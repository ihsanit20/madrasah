<template>
    <Head title="SMS Service" />

    <app-layout pageTitle="SMS Service" :addNewHref="route('sms-services.create')">
        <simple-table
            :collections="data.collections"
            :filters="data.filters"
            :columns="columns"
        >
            <template #default="{ item: sms }">
                <table-td class="text-left">
                    <div
                        class="overflow-hidden whitespace-normal break-all line-clamp-6"
                    >
                        {{ sms }}
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
import { TrashIcon } from "@heroicons/vue/outline";
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
        TrashIcon,
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
                { title: "sms", align: "left" },
            ],
        };
    },
};
</script>
