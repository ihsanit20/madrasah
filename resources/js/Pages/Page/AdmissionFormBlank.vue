<template>
    <Head title="ভর্তির আবেদন" />

    <app-layout :hasFooter="false">
        <div
            class="mx-auto mt-4 flex max-w-xl items-center justify-end print:hidden"
        >
            <Link
                :href="route('home')"
                class="flex-shrink flex-grow text-xl font-bold leading-5 text-gray-700"
            >
                &#8592; Back to Home
            </Link>
            <print-button />
        </div>
        <admission-form-blank-templete class="mx-auto max-w-max" />
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
import AdmissionFormBlankTemplete from "@/Templete/AdmissionFormBlank.vue";
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
        AdmissionFormBlankTemplete,
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
