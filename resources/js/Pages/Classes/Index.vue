<template>
    <Head title="Classes" />

    <app-layout pageTitle="Classes" :addNewHref="route('classes.create')">
        <simple-table
            :collections="data.collections"
            :filters="data.filters"
            :columns="columns"
        >
            <template #default="{ item: classes }">
                <td class="px-3 py-2 text-left">{{ classes.id }}</td>
                <td class="px-3 py-2 text-left">{{ classes.name }}</td>
                <td class="px-3 py-1.5">
                    <div
                        class="flex items-center justify-center gap-1 md:gap-2"
                    >
                        <action-button-show
                            :href="route('classes.show', classes.id)"
                        />
                        <action-button-edit
                            :href="route('classes.edit', classes.id)"
                        />
                    </div>
                </td>
            </template>
        </simple-table>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/App.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import SimpleTable from "@/Components/SimpleTable.vue";
import ActionButtonShow from "@/Components/ActionButtonShow.vue";
import ActionButtonEdit from "@/Components/ActionButtonEdit.vue";
import AddNewButton from "@/Components/AddNewButton.vue";

export default {
    components: {
        AppLayout,
        SimpleTable,
        Head,
        Link,
        ActionButtonShow,
        ActionButtonEdit,
        AddNewButton,
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
                { title: "ID", align: "left" },
                { title: "Name", align: "left" },
                { title: "Action", align: "center" },
            ],
        };
    },
};
</script>
