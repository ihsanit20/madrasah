<template>
    <Head title="ব্যয়ের খাত" />

    <app-layout pageTitle="ব্যয়ের খাত" :addNewHref="route('categories.create')">
        <simple-table
            :collections="data.collections"
            :filters="data.filters"
            :columns="columns"
        >
            <template #default="{ item: category }">
                <table-td class="text-left">
                    <div
                        class="overflow-hidden whitespace-normal break-all line-clamp-6"
                    >
                        <Link
                            :href="route('categories.edit', category.id)"
                            class="text-sky-600 hover:underline"
                        >
                            {{ category.name }}
                        </Link>
                    </div>
                </table-td>
                <table-td class="w-10 text-right">
                    <action-button-delete
                        v-if="category.allowDeletion"
                        :href="route('categories.destroy', category.id)"
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
            columns: [{ title: "ব্যয়ের খাত", align: "left" }, {}],
        };
    },
};
</script>
