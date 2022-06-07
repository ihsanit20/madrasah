<template>
    <Head title="শিক্ষার্থী তালিকা" />

    <app-layout
        :pageTitle="`${
            data.classes ? data.classes.name + ' এর' : 'সকল'
        } শিক্ষার্থী তালিকা`"
    >
        <div class="grid gap-2 md:grid-cols-2 md:gap-4">
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
                        class="text-md font-bold text-sky-600 hover:underline md:text-xl"
                    >
                        {{ student.name }}
                    </Link>
                    <div
                        class="flex flex-col justify-center gap-2 md:flex-row md:items-center md:justify-between"
                    >
                        <div class="flex items-center gap-2">
                            <span class="text-gray-600">রেজি. নং: </span>
                            <span class="font-bold text-gray-800">
                                {{ $e2bnumber(student.registration) }}
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
                                class="rounded bg-orange-100 px-3 py-1 text-sm text-orange-500"
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
import AppLayout from "@/Layouts/App.vue";
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
