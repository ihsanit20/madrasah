<template>
    <Head title="ভর্তির আবেদন তালিকা" />

    <app-layout
        pageTitle="ভর্তির আবেদন তালিকা"
        :addNewHref="route('admissions.create')"
    >
        <simple-table
            :collections="data.collections"
            :filters="data.filters"
            :columns="columns"
        >
            <template #default="{ item: admission }">
                <table-td class="text-left">
                    <Link
                        :href="route('admissions.show', admission.id)"
                        class="text-sky-600 hover:underline"
                    >
                        {{ admission.id }}
                    </Link>
                </table-td>
                <table-td class="text-left">
                    {{ admission.studentName }}
                </table-td>
                <table-td class="text-left">
                    {{ admission.student.fatherInfo.name }}
                </table-td>
                <table-td class="text-left">
                    {{ admission.className }}
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
                { title: "ফরম নাম্বার", align: "left", sticky: true },
                { title: "শিক্ষার্থীর নাম", align: "left" },
                { title: "পিতার নাম", align: "left" },
                { title: "ভর্তিচ্ছু বিভাগ/শ্রেণী", align: "left" },
            ],
        };
    },
};
</script>
