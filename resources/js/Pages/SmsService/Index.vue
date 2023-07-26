<template>
    <Head title="SMS Service" />

    <app-layout>
        <simple-table
            :collections="data.collections"
            :filters="data.filters"
            :columns="columns"
        >
            <template #default="{ item: sms }">
                <table-td class="text-center">
                    <Link
                        :href="route('sms-services.show', sms.id)"
                        class="text-sky-600 hover:underline"
                    >
                        {{ sms.date }}
                    </Link>
                </table-td>
                <table-td class="text-center">
                    <div
                        class=""
                    >
                        {{ sms.title === 'সাধারণ বার্তা' ? 'সাধারণ বার্তা' : 'ফিনানশিয়াল বার্তা' }}
                    </div>
                </table-td>
                <table-td class="text-center">
                    <div
                        class=""
                    >
                        {{ sms.status_text }}
                    </div>
                </table-td>
                <table-td class="text-center">
                    <div
                        class=""
                    >
                        {{ $e2bnumber(Object.keys(sms.receivers).length) }}
                    </div>
                </table-td>
                <table-td class="text-left">
                    <div
                        class="overflow-hidden whitespace-normal break-all line-clamp-1"
                    >
                        {{ sms.body }}
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
                { title: "Date", align: "center" },
                { title: "Type", align: "center" },
                { title: "Status", align: "center" },
                { title: "প্রাপক", align: "center" },
                { title: "sms", align: "left" },
            ],
        };
    },
};
</script>
