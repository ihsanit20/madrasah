<template>
    <Head title="Classes" />

    <app-layout :pageTitle="classes.name">
        <div class="overflow-auto">
            <table class="table-auto rounded border bg-white shadow">
                <show-table-row heading="ID">
                    {{ classes.id }}
                </show-table-row>
                <show-table-row heading="Name">
                    {{ classes.name }}
                </show-table-row>
                <show-table-row heading="Action">
                    <div class="flex items-center justify-start gap-1 md:gap-2">
                        <action-button-edit
                            :href="route('classes.edit', classes.id)"
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
        classes: {
            type: Object,
            default: {},
        },
    },
};
</script>
