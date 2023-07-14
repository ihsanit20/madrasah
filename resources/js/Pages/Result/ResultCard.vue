<template>
    <Head
        :title="`${data.exam.name} : ${data.class.name} ক্লাস এর বিষয় সমুহ`"
    />

    <app-layout
        :pageTitle="`${data.exam.name} : ${data.class.name} ক্লাস এর বিষয় সমুহ`"
    >
        <div class="w-full flex items-center justify-between py-2 print:hidden">
            <Link
                :href="
                    route('results.subjects', [data.exam.id, data.class.id]) +
                    '?session=' +
                    $page.props.current_academic_session.value
                "
                class="flex items-center justify-center gap-2 rounded-md bg-gray-600 px-4 py-1 text-white"
            >
                <ArrowLeftIcon class="w-5" />
                পূর্বের পেজ
            </Link>
            <print-button />
        </div>
        <div
            v-for="student in data.students"
            :key="student.id"
            class="w-full print:break-before-page"
        >
            <ResultCardTemplete
                :student="student"
                :data="data"
                :signature="signature"
            />
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/GridApp.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import { ArrowLeftIcon } from "@heroicons/vue/outline";
import PrintButton from "@/Components/PrintButton.vue";
import ResultCardTemplete from "@/Templete/ResultCard.vue";

export default {
    components: {
        AppLayout,
        Head,
        Link,
        ArrowLeftIcon,
        PrintButton,
        ResultCardTemplete,
    },

    props: {
        data: {
            type: Object,
            default: {},
        },
        signature: {
            type: String,
            default: "",
        },
    },
};
</script>
