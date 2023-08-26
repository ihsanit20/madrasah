<template>
    <Head title="ভাউচার তালিকা" />

    <app-layout pageTitle="ভাউচার তালিকা">
        <div class="max-w-xl rounded border bg-white p-3 shadow md:p-4">
            <div class="flex items-end justify-end">
                <div class="flex items-center gap-2">
                    <action-button-edit
                        :href="route('expenses.edit', data.expense.id)"
                    />
                </div>
            </div>
            <div class="grid gap-2">
                <inline-data title="খাত:" :value="data.expense.categoryName" />
                <inline-data
                    title="শিক্ষক/স্টাফ:"
                    :value="data.expense.staffName"
                />
                <inline-data title="টাকা:" :value="data.expense.amount" />
                <inline-data title="তারিখ:" :value="data.expense.date" />
                <inline-data title="বিবরণ:" :value="data.expense.description" />
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/GridApp.vue";
import { Head } from "@inertiajs/vue3";
import ActionButtonEdit from "@/Components/ActionButtonEdit.vue";
import FormHeading from "@/Components/FormHeading.vue";
import InlineData from "@/Components/InlineData.vue";

export default {
    components: {
        AppLayout,
        Head,
        ActionButtonEdit,
        FormHeading,
        InlineData,
    },
    props: {
        data: {
            type: Object,
            default: {},
        },
    },
};
</script>
