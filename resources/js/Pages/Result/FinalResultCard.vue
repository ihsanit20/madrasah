<template>
    <Head
        :title="`${data.class.name} ক্লাস এর চূড়ান্ত ফলাফল`"
    />

    <app-layout
        :pageTitle="`${data.class.name} ক্লাস এর চূড়ান্ত ফলাফল`"
    >
        <div class="w-full flex items-center justify-between py-2 print:hidden">
            <Link
                :href="route('results.final.subjects', [data.class.id])"
                class="flex items-center justify-center gap-2 rounded-md bg-gray-600 px-4 py-1 text-white"
            >
                <ArrowLeftIcon class="w-5" />
                পূর্বের পেজ
            </Link>
            <print-button />
        </div>
        <div
            v-for="(student, index) in data.students"
            :key="student.id"
            class="w-full print:break-before-page"
        >
            <FinalResultCardTemplete
                :student="student"
                :data="data"
                :signature="signature"
                :index="index"
            />
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/GridApp.vue";
import { Head, Link } from "@inertiajs/vue3";
import { ArrowLeftIcon } from "@heroicons/vue/outline";
import PrintButton from "@/Components/PrintButton.vue";
import FinalResultCardTemplete from "@/Templete/FinalResultCard.vue";

export default {
    components: {
        AppLayout,
        Head,
        Link,
        ArrowLeftIcon,
        PrintButton,
        FinalResultCardTemplete,
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
