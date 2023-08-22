<template>
    <Head title="শিক্ষার্থী তালিকা" />

    <app-layout
        :pageTitle="`${
            data.classes ? data.classes.name + ' এর' : 'সকল'
        } শিক্ষার্থী তালিকা`"
    >
        <div v-if="!data.paidStudents" class="rounded py-4">
            <div
                class="flex flex-wrap items-end justify-start gap-4 print:hidden"
            >
                <Link
                    v-if="data?.classes?.id"
                    :href="route('students.class.id-card', data.classes.id)"
                    class="flex flex-shrink-0 flex-grow-0 items-center justify-center gap-1 rounded border border-brand-600 px-2.5 pt-1 text-brand-600 hover:bg-brand-600 hover:text-white"
                >
                    পরিচয় পত্র
                </Link>
                <Link
                    v-else
                    :href="route('students.all-id-card')"
                    class="flex flex-shrink-0 flex-grow-0 items-center justify-center gap-1 rounded border border-brand-600 px-2.5 pt-1 text-brand-600 hover:bg-brand-600 hover:text-white"
                >
                    পরিচয় পত্র
                </Link>
                <Link
                    v-if="data?.classes?.id"
                    :href="
                        route('students.class.attendance-page', data.classes.id)
                    "
                    class="flex flex-shrink-0 flex-grow-0 items-center justify-center gap-1 rounded border border-brand-600 px-2.5 pt-1 text-brand-600 hover:bg-brand-600 hover:text-white"
                >
                    হাজিরা খাতা
                </Link>
            </div>
        </div>

        <div class="w-full grid gap-2 md:grid-cols-2 lg:grid-cols-3 md:gap-4">
            <div
                v-for="student in data.students"
                :key="student.id"
                class="flex items-center gap-2 rounded-md border bg-white p-2 hover:shadow md:gap-4 md:p-4"
            >
                <div
                    class="flex h-10 w-10 shrink-0 grow-0 items-center justify-center rounded-full bg-gray-200 text-xl font-bold text-gray-500 md:h-12 md:w-12 md:text-2xl"
                >
                    {{ $e2bnumber(student.currentClassRoll) }}
                </div>
                <div class="shrink grow">
                    <Link
                        :href="route('students.show', student.id)"
                        class="text-md font-bold text-brand-600 hover:underline md:text-xl"
                    >
                        {{ student.name }}
                    </Link>
                    <div
                        class="flex flex-wrap justify-center gap-2 md:items-center md:justify-between"
                    >
                        <div class="flex items-center gap-2">
                            <span class="text-gray-600">রেজি: </span>
                            <span class="font-bold text-gray-800">
                                {{ $e2bnumber(student.registration) }}
                            </span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-gray-600">বকেয়া: </span>
                            <span class="font-bold text-gray-800">
                                {{ $e2bnumber(student.due) }}
                            </span>
                        </div>
                        <div>
                            <Link
                                :href="
                                    route('payments.create') +
                                    '?registration=' +
                                    student.registration +
                                    (data.purposeId
                                        ? '&purpose=' + data.purposeId
                                        : '')
                                "
                                class="rounded bg-brand-100 px-3 py-1 text-sm text-brand-600"
                            >
                                টাকা জমা নিন
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="data.paidStudents" class="pt-12 text-2xl font-bold">
            আদায় তালিকা
        </div>
        <div class="w-full grid gap-2 md:grid-cols-2 md:gap-4">
            <div
                v-for="student in data.paidStudents"
                :key="student.id"
                class="flex items-center gap-2 rounded-md border bg-white p-2 hover:shadow md:gap-4 md:p-4"
            >
                <div
                    class="flex h-10 w-10 shrink-0 grow-0 items-center justify-center rounded-full bg-gray-200 text-xl font-bold text-gray-500 md:h-12 md:w-12 md:text-2xl"
                >
                    {{ $e2bnumber(student.currentClassRoll) }}
                </div>
                <div class="shrink grow">
                    <Link
                        :href="route('students.show', student.id)"
                        class="text-md font-bold text-brand-600 hover:underline md:text-xl"
                    >
                        {{ student.name }}
                    </Link>
                    <div
                        class="flex flex-wrap justify-center gap-2 md:items-center md:justify-between"
                    >
                        <div class="flex items-center gap-2">
                            <span class="text-gray-600">রেজি: </span>
                            <span class="font-bold text-gray-800">
                                {{ $e2bnumber(student.registration) }}
                            </span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-gray-600">বকেয়া: </span>
                            <span class="font-bold text-gray-800">
                                {{ $e2bnumber(student.due) }}
                            </span>
                        </div>
                        <div>
                            <Link
                                :href="
                                    route('payments.create') +
                                    '?registration=' +
                                    student.registration +
                                    (data.purposeId
                                        ? '&purpose=' + data.purposeId
                                        : '')
                                "
                                class="rounded bg-brand-100 px-3 py-1 text-sm text-brand-600"
                            >
                                টাকা জমা নিন
                            </Link>
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
import { ClassSvg } from "@/Layouts/Navigation/SvgIcon";

export default {
    components: {
        AppLayout,
        Head,
        Link,
        ClassSvg,
    },
    props: {
        data: {
            type: Object,
            default: {},
        },
    },
};
</script>
