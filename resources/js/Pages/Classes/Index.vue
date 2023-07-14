<template>
    <Head title="ক্লাস/বিভাগ সমুহ" />

    <app-layout
        pageTitle="ক্লাস/বিভাগ সমুহ"
        :addNewHref="route('classes.create')"
    >
        <div class="w-full">
            <data-table
                :collections="data.collections"
                :filters="data.filters"
                :columns="columns"
            >
                <template #default="{ item: classes }">
                    <table-td class="text-center">
                        {{ $e2bnumber(classes.code) }}
                    </table-td>
                    <table-td class="text-left">
                        <Link
                            :href="route('classes.show', classes.id)"
                            class="text-sky-600 hover:underline"
                        >
                            {{ classes.name }}
                        </Link>
                    </table-td>
                    <table-td class="text-center">
                        {{ $e2bnumber(classes.totalStudent) }}
                    </table-td>
                </template>
            </data-table>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/GridApp.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import DataTable from "@/Components/DataTable.vue";
import ActionButtonShow from "@/Components/ActionButtonShow.vue";
import ActionButtonEdit from "@/Components/ActionButtonEdit.vue";
import AddNewButton from "@/Components/AddNewButton.vue";
import TableTd from "@/Components/TableTd.vue";

export default {
    components: {
        AppLayout,
        DataTable,
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
                { title: "ক্লাস কোড", align: "center" },
                { title: "ক্লাস/বিভাগের নাম", align: "left" },
                { title: "শিক্ষাথী সংখ্যা", align: "center" },
            ],
        };
    },
};
</script>
