<template>
    <Head title="শিক্ষক/স্টাফ" />

    <app-layout pageTitle="শিক্ষক/স্টাফ">
        <div class="rounded py-4">
            <div
                class="flex flex-wrap items-end justify-start gap-4 print:hidden"
            >
                <Link
                    :href="route('staff-attendance-page')"
                    class="flex flex-shrink-0 flex-grow-0 items-center justify-center gap-1 rounded border border-sky-600 px-2.5 pt-1 text-sky-600 hover:bg-sky-600 hover:text-white"
                >
                    হাজিরা খাতা
                </Link>
            </div>
        </div>
        <div class="grid gap-2 md:grid-cols-2 md:gap-4">
            <div
                v-for="staff in data.staff"
                :key="staff.id"
                class="flex items-center gap-2 rounded-md border bg-white p-2 hover:shadow md:gap-4 md:p-4"
            >
                <div
                    class="flex h-14 w-14 shrink-0 grow-0 items-center justify-center overflow-hidden rounded-full bg-gray-200 text-2xl font-bold text-gray-500 md:h-16 md:w-16 md:text-4xl"
                >
                    <AvatarView
                        :class="`h-14 w-14 md:h-16 md:w-16`"
                        :imageUrl="staff.imageUrl"
                        :firstLatter="staff.name[0]"
                    />
                </div>
                <div class="shrink grow">
                    <div class="text-md font-bold text-sky-600 md:text-xl">
                        <Link
                            :href="route('staff.show', staff.id)"
                            class="text-sky-600 hover:underline"
                        >
                            {{ staff.name }}
                        </Link>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-gray-600">পদবি: </span>
                        <span class="font-bold text-gray-800">
                            {{ staff.designation.name }}
                        </span>
                    </div>
                    <div
                        class="flex flex-col md:flex-row md:items-center md:justify-between"
                    >
                        <div class="flex items-center gap-2">
                            <span class="text-gray-600">ফোন: </span>
                            <span class="font-bold text-gray-800">
                                {{ staff.phone }}
                            </span>
                        </div>
                        <div class="flex items-center gap-2">
                            <Link
                                :href="route('staff.salaries.create', staff.id)"
                                class="rounded bg-orange-100 px-3 py-1 text-sm text-orange-500"
                            >
                                বেতন দিন
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
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
import ActionButtonDelete from "@/Components/ActionButtonDelete.vue";
import AvatarView from "@/Components/AvatarView.vue";

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
        AvatarView,
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
                { title: "নাম", align: "left" },
                { title: "পদবি", align: "left" },
                { title: "Phone", align: "left" },
                { title: "", align: "right" },
            ],
        };
    },
};
</script>
