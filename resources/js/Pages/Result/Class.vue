<template>
    <Head :title="`${data.exam.name} এর ক্লাস সমুহ`" />

    <app-layout :pageTitle="`${data.exam.name} এর ক্লাস সমুহ`">
        <div class="w-full flex items-center justify-start py-2">
            <Link
                :href="
                    route('results.exams') +
                    '?session=' +
                    $page.props.current_academic_session.value
                "
                class="flex items-center justify-center gap-2 rounded-md bg-gray-600 px-4 py-1 text-white"
            >
                <ArrowLeftIcon class="w-5" />
                <span>পূর্বের পেজ</span>
            </Link>
        </div>
        <div class="w-full grid gap-2 md:grid-cols-2 lg:grid-cols-3 md:gap-4">
            <Link
                v-for="classes in data.classes"
                :key="classes.id"
                :href="
                    route('results.subjects', [data.exam.id, classes.id]) +
                    '?session=' +
                    $page.props.current_academic_session.value
                "
                class="flex items-center gap-2 rounded-md border bg-white p-2 hover:shadow md:gap-4 md:p-4"
            >
                <div
                    class="flex h-10 w-10 shrink-0 grow-0 items-center justify-center rounded-full bg-gray-200 text-xl font-bold text-gray-500 md:h-12 md:w-12 md:text-2xl"
                >
                    {{ $e2bnumber(classes.code).padStart(2, $e2bnumber("0")) }}
                </div>
                <div class="shrink grow">
                    <div class="text-md font-bold text-brand-600 md:text-xl">
                        {{ classes.name }}
                    </div>
                    <div class="flex items-center gap-2">
                        <ClassSvg class="w-5 text-gray-400" />
                        <span class="text-gray-600"> বিষয়: </span>
                        <span class="font-bold text-gray-800">
                            {{ $e2bnumber(classes.totalSubject) }} টি
                        </span>
                    </div>
                </div>
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 40 40"
                    class="h-10 w-10 shrink-0 grow-0 fill-brand-600"
                >
                    <g id="right_arrow" transform="translate(-0.287 0)">
                        <path
                            id="circle"
                            d="M20,1.379A18.593,18.593,0,0,0,1.429,20,18.554,18.554,0,1,0,27.212,2.835,18.411,18.411,0,0,0,20,1.379M20,0A20,20,0,1,1,0,20,20,20,0,0,1,20,0Z"
                            transform="translate(0.287 0)"
                        />
                        <path
                            id="arrow_icn"
                            d="M1048.294,2575.52h18.868l-7.145-7.146a.918.918,0,0,1,1.3-1.3l8.711,8.712a.92.92,0,0,1,0,1.3l-8.711,8.708a.918.918,0,0,1-1.3-1.3l7.145-7.144h-18.867a.918.918,0,1,1,0-1.835Z"
                            transform="translate(-1038.832 -2556.308)"
                        />
                    </g>
                </svg>
            </Link>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/GridApp.vue";
import { ClassSvg } from "@/Layouts/Navigation/SvgIcon";
import { Head, Link } from "@inertiajs/vue3";
import { ArrowLeftIcon } from "@heroicons/vue/outline";

export default {
    components: {
        AppLayout,
        Head,
        Link,
        ClassSvg,
        ArrowLeftIcon,
    },
    props: {
        data: {
            type: Object,
            default: {},
        },
    },
};
</script>
