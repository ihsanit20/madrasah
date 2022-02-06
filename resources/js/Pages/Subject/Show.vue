<template>
    <Head title="Subject" />

    <app-layout :pageTitle="data.subject.name">
        <div class="overflow-auto">
            <table class="table-auto rounded border bg-white shadow">
                <show-table-row heading="ID">
                    {{ data.subject.id }}
                </show-table-row>
                <show-table-row heading="Class">
                    {{ data.subject.className }}
                </show-table-row>
                <show-table-row heading="Name">
                    {{ data.subject.name }}
                </show-table-row>
                <show-table-row heading="Action">
                    <div class="flex items-center justify-start gap-1 md:gap-2">
                        <action-button-edit
                            :href="route('subjects.edit', data.subject.id)"
                        />
                    </div>
                </show-table-row>
            </table>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/App.vue";
import { Head } from "@inertiajs/inertia-vue3";
import ShowTableRow from "@/Components/ShowTableRow.vue";
import ActionButtonEdit from "@/Components/ActionButtonEdit.vue";

export default {
    components: {
        AppLayout,
        Head,
        ShowTableRow,
        ActionButtonEdit,
    },
    props: {
        data: {
            type: Object,
            default: {},
        },
    },
};
</script>
