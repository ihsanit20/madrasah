<template>
    <Head title="বাবদ তালিকা" />

    <app-layout pageTitle="বাবদ তালিকা" :addNewHref="route('purposes.create')">
        <div class="grid md:grid-cols-3">
            <Link
                v-for="purpose in data.collections.data"
                :key="purpose.id"
                class="rounded bg-white p-4 shadow"
                :href="route('purposes.edit', purpose.id)"
            >
                <div class="text-sky-600 hover:underline">
                    {{ purpose.title }}
                </div>
                <div>ফি যুক্ত আছে {{ purpose.purpose_fees_count }} টি</div>
            </Link>
        </div>
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
