<template>
    <Head title="Department" />

    <app-layout>
        <div class="w-full max-w-xl rounded border bg-white p-3 shadow md:p-4">
            <div class="flex items-end justify-end">
                <div class="flex items-center gap-2">
                    <action-button-edit
                        :href="route('departments.edit', data.department.id)"
                    />
                </div>
            </div>
            <div class="mt-4 grid gap-4">
                <div
                    class="rounded-lg border px-4 py-2 font-bold text-gray-800"
                >
                    {{ data.department.name }}
                </div>
                <div
                    v-if="false"
                    class="rounded-lg border px-4 py-2 text-gray-500"
                >
                    {{ data.department.description }}
                </div>
            </div>
        </div>

        <div class="w-full max-w-xl rounded border bg-white p-3 shadow md:p-4">
            <div class="grid grid-cols-2 gap-4">
                <div
                    class="col-span-full flex items-center justify-center rounded border bg-gray-200 p-2"
                >
                    Academic Sessions
                </div>
                <div
                    v-for="academic_session in data.department
                        .academic_sessions"
                    :key="academic_session.value"
                    class="grid gap-4 rounded-xl border p-4"
                >
                    <div class="flex items-center gap-1">
                        <div class="text-gray-400">Session:</div>
                        <div class="font-bold">
                            {{ academic_session.value }}
                        </div>
                    </div>
                    <div class="flex items-center gap-1">
                        <div class="text-gray-400">Bengali:</div>
                        <div class="font-bold">
                            {{ academic_session.bengali }}
                        </div>
                    </div>
                    <div class="flex items-center gap-1">
                        <div class="text-gray-400">English:</div>
                        <div class="font-bold">
                            {{ academic_session.english }}
                        </div>
                    </div>
                    <div class="flex items-center gap-1">
                        <div class="text-gray-400">Arabic:</div>
                        <div class="font-bold">
                            {{ academic_session.arabic }}
                        </div>
                    </div>
                </div>
                <div
                    class="col-span-full flex cursor-pointer items-center justify-center gap-2 rounded-lg border-2 border-dashed border-sky-600 p-3"
                >
                    <PlusCircleIcon class="w-8 text-sky-600" />
                    <div class="text-sky-600 md:text-xl">
                        নতুন সেশন যুক্ত করুণ
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/GridApp.vue";
import { Head, Link } from "@inertiajs/vue3";
import ActionButtonEdit from "@/Components/ActionButtonEdit.vue";
import FormHeading from "@/Components/FormHeading.vue";
import InlineData from "@/Components/InlineData.vue";
import { PlusCircleIcon } from "@heroicons/vue/solid";

export default {
    components: {
        AppLayout,
        Head,
        Link,
        ActionButtonEdit,
        FormHeading,
        InlineData,
        PlusCircleIcon,
    },
    props: {
        data: {
            type: Object,
            default: {},
        },
    },
};
</script>
