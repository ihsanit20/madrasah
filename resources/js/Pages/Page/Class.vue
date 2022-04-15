<template>
    <Head title="Class" />

    <app-layout :hasFooter="false">
        <div
            class="mx-auto mt-4 flex max-w-3xl items-center justify-end print:hidden"
        >
            <Link
                :href="route('home')"
                class="flex-shrink flex-grow text-xl font-bold leading-5 text-gray-700"
            >
                &#8592; Back to Home
            </Link>
            <print-button />
        </div>
        <ClassTemplete :data="data" class="mx-auto max-w-3xl" />
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/Master.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import ActionButtonEdit from "@/Components/ActionButtonEdit.vue";
import FormHeading from "@/Components/FormHeading.vue";
import InlineData from "@/Components/InlineData.vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import Button from "@/Components/Button.vue";
import ClassTemplete from "@/Templete/Class.vue";
import PrintButton from "@/Components/PrintButton.vue";

export default {
    components: {
        AppLayout,
        Head,
        Link,
        ActionButtonEdit,
        FormHeading,
        InlineData,
        ApplicationLogo,
        Button,
        ClassTemplete,
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
