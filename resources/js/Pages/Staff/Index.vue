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
                <Link
                    :href="route('staff.id-card')"
                    class="flex flex-shrink-0 flex-grow-0 items-center justify-center gap-1 rounded border border-sky-600 px-2.5 pt-1 text-sky-600 hover:bg-sky-600 hover:text-white"
                >
                    পরিচয় পত্র
                </Link>
            </div>
        </div>
        <div class="w-full grid gap-2 md:grid-cols-2 md:gap-4 lg:grid-cols-3">
            <div
                v-for="staff in data.staff"
                :key="staff.id"
                class="relative rounded-md border bg-white"
                :class="{
                    'grayscale': !staff.active
                }"
            >
                <div v-if="staff.loading" role="status" class="absolute -translate-x-1/2 -translate-y-1/2 top-2/4 left-1/2">
                    <svg aria-hidden="true" class="w-8 h-8 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/></svg>
                </div>
                <div
                    class="flex items-center gap-2 p-2 hover:shadow md:gap-4 md:p-3"
                    :class="{ 'opacity-5':staff.loading }"
                >
                    <div
                        class="flex flex-col gap-2 w-12 shrink-0 grow-0 items-center justify-center text-2xl font-bold text-blue-800 md:text-4xl"
                    >
                        <AvatarView
                            class="h-12 w-12 bg-gray-200 border"
                            :imageUrl="staff.imageUrl"
                            :firstLatter="staff.name[0]"
                        />
                        
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" value="" class="sr-only peer" v-model="staff.active" @change="toggleActiveHandler(staff)">
                            <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                        </label>

                    </div>
                    <div class="shrink grow">
                        <div class="text-md font-bold text-sky-600 md:text-2xl">
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
                                {{ staff.designationTitle }}
                            </span>
                        </div>
                        <div
                            class="flex flex-col md:flex-row md:items-center md:justify-between"
                        >
                            <div class="flex items-center gap-2 py-0.5">
                                <span class="text-gray-600">ফোন: </span>
                                <span class="font-bold text-gray-800">
                                    {{ staff.phone }}
                                </span>
                            </div>
                            <div class="flex items-center gap-2">
                                <Link
                                    v-if="staff.active"
                                    :href="route('staff.salaries.create', staff.id)"
                                    class="rounded bg-orange-100 px-3 py-0.5 text-sm text-orange-500"
                                >
                                    বেতন দিন
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
import ActionButtonDelete from "@/Components/ActionButtonDelete.vue";
import AvatarView from "@/Components/AvatarView.vue";
import axios from "axios";

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
    methods: {
        toggleActiveHandler(staff) {
            staff.loading = true;

            const formData = new FormData();
            formData.append("step", "current_appointment_active_status");
            formData.append("_method", "PUT");
            formData.append("active", staff.active ? 1 : 0);

            axios
                .post(this.route("staff.update", staff.id), formData)
                .then((response) => {
                    staff.active = response.data.active;
                })
                .catch((error) => {
                    staff.active = !staff.active;
                    
                    console.log(error);
                })
                .finally(() => {
                    setTimeout(() => {
                        staff.loading = false;
                    }, 500);
                });
        },
    },
};
</script>
