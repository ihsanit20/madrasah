<template>
    <Head title="প্রদেয় ফি তালিকা" />

    <app-layout pageTitle="প্রদেয় ফি তালিকা" :addNewHref="route('fees.create')">
        <simple-table
            :collections="data.collections"
            :filters="data.filters"
            :columns="columns"
        >
            <template #default="{ item: fee }">
                <table-td class="text-left">
                    <div
                        class="overflow-hidden whitespace-normal break-all line-clamp-6"
                    >
                        <Link
                            :href="route('fees.edit', fee.id)"
                            class="text-sky-600 hover:underline"
                        >
                            {{ fee.name }}
                        </Link>
                    </div>
                </table-td>
                <table-td class="text-left">
                    {{ fee.periodName }}
                </table-td>
                <table-td class="w-10 text-right">
                    <action-button-delete
                        :href="route('fees.destroy', fee.id)"
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
                { title: "প্রদেয় ফি", align: "left" },
                { title: "ফি-এর ধরন", align: "left" },
                { title: "", align: "right" },
            ],
        };
    },
};
</script>
