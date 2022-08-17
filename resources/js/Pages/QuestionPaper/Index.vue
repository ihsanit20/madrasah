<template>
    <Head title="প্রশ্নপত্র" />

    <app-layout pageTitle="প্রশ্নপত্র" :addNewHref="route('question-papers.create')">
        <simple-table
            :collections="data.collections"
            :filters="data.filters"
            :columns="columns"
        >
            <template #default="{ item: questionPaper }">
                <table-td class="text-left">
                    {{ questionPaper.name }}
                </table-td>
                <table-td class="text-left">
                    {{ questionPaper.class_name }}
                </table-td>
                <table-td class="text-left">
                    {{ questionPaper.subject_name }}
                </table-td>
                <table-td class="text-center">
                    {{ questionPaper.mark }}
                </table-td>
                <table-td class="text-center">
                    <div class="flex justify-center gap-2">
                        <action-button-show
                            :href="route('question-papers.show', questionPaper.id)"
                        />
                        <action-button-edit
                            :href="route('question-papers.edit', questionPaper.id)"
                        />
                    </div>
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
                { title: "পরীক্ষার নাম", align: "left" },
                { title: "ক্লাস", align: "left" },
                { title: "বিষয়", align: "left" },
                { title: "পূর্ণমান", align: "center" },
                { title: "Action", align: "center" },
            ],
        };
    },
};
</script>
