<template>
    <Head title="Setting" />

    <app-layout pageTitle="Settings">
        <simple-table
            :collections="data.collections"
            :filters="data.filters"
            :columns="columns"
        >
            <template #default="{ item: setting }">
                <table-td class="text-left">
                    <span
                        v-if="setting.key === 'logo'"
                    >
                        {{ setting.name }}
                    </span>
                    <Link
                        v-else
                        :href="route('settings.edit', setting.id)"
                        class="text-brand-600 hover:underline"
                    >
                        {{ setting.name }}
                    </Link>
                </table-td>
                <table-td class="text-left">
                    <div
                        v-if="setting.key === 'logo'"
                        class="overflow-hidden whitespace-pre-wrap break-all line-clamp-6"
                    >
                        <image-previe-with-save
                            class="w-40"
                            ratioClass="aspect-[1/1]"
                            option="logo"
                            :imageUrl="`/${setting.value}`"
                            :id="setting.id"
                            :width="320"
                            :height="320"
                        />
                    </div>
                    <div
                        v-else
                        class="overflow-hidden whitespace-pre-wrap break-all line-clamp-6"
                    >
                        {{ setting.value }}
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
import ImagePrevieWithSave from "@/Components/ImagePrevieWithSave.vue";

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
        ImagePrevieWithSave,
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
                { title: "Name", align: "left" },
                { title: "Value", align: "left" },
            ],
        };
    },
};
</script>
