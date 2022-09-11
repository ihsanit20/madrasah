<template>
    <Head title="Result" />

    <app-layout pageTitle="ফলাফল">
        <div
            class="flex w-full max-w-2xl items-center justify-between py-2 print:hidden"
        >
            <Link
                :href="
                    route('results.subjects', [
                        data.result.exam_id,
                        data.result.class_id,
                    ])
                "
                class="flex items-center justify-center gap-2 rounded-md bg-gray-600 px-4 py-1 text-white"
            >
                <ArrowLeftIcon class="w-5" />
                পূর্বের পেজ
            </Link>
            <print-button />
        </div>

        <form-component :data="data" module-action="store" />
    </app-layout>
</template>

<script>
import { Head, Link } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/App.vue";
import FormComponent from "./Form.vue";
import { ArrowLeftIcon } from "@heroicons/vue/outline";
import PrintButton from "@/Components/PrintButton.vue";

export default {
    components: {
        Head,
        Link,
        AppLayout,
        FormComponent,
        ArrowLeftIcon,
        PrintButton,
    },
    props: {
        data: {
            type: Object,
            default: {},
        },
    },
};
</script>
