<template>
    <Head title="ভর্তির আবেদন তালিকা" />

    <app-layout>
        <div
            class="w-full flex flex-wrap items-end justify-between gap-4 print:hidden"
        >
            <h2
                class="flex-shrink flex-grow text-xl font-bold leading-5 text-gray-700"
            >
                Online ভর্তির আবেদন তালিকা
            </h2>
        </div>

        <simple-table
            :collections="data.collections"
            :filters="data.filters"
            :columns="columns"
        >
            <template #default="{ item: admission_form }">
                <table-td class="text-left">
                    <Link
                        :href="route('admissions.online-forms.show', admission_form.id)"
                        class="text-brand-600 hover:underline"
                    >
                        {{ (admission_form.id) }}
                    </Link>
                </table-td>
                <table-td class="text-left">
                    {{ admission_form.name }}
                </table-td>
                <table-td class="text-left">
                    {{ admission_form.fathers_info?.name }}
                </table-td>
                <table-td class="text-left">
                    {{ admission_form.choice_class?.name }}
                </table-td>
            </template>
        </simple-table>
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
import AdmissionFormBlankTemplete from "@/Templete/AdmissionFormBlank.vue";

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
        AdmissionFormBlankTemplete,
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
