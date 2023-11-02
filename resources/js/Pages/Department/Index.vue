<template>
    <Head title="Department তালিকা" />

    <app-layout
        pageTitle="Department তালিকা"
        :addNewHref="route('departments.create')"
    >
        <div class="grid w-full gap-2 md:grid-cols-2">
            <Link
                v-for="Department in data.collections.data"
                :key="Department.id"
                class="space-y-2 rounded bg-white p-4 shadow transition-all ease-out hover:scale-105"
                :href="route('departments.show', Department.id)"
            >
                <div class="text-brand-600 text-xl md:text-3xl">
                    {{ Department.name }}
                </div>
                <div class="line-clamp-1 text-xs text-gray-700 md:text-sm">
                    {{ Department.description }}
                </div>
            </Link>
        </div>
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
                { title: "ভাউচার নং", align: "left" },
                { title: "তারিখ", align: "left" },
                { title: "খাত", align: "left" },
                { title: "ব্যয়কারী", align: "left" },
                { title: "টাকা", align: "right" },
            ],
        };
    },
};
</script>
