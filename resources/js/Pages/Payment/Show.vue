<template>
    <Head title="Payment" />

    <app-layout>
        <div class="flex max-w-3xl items-center justify-end print:hidden">
            <div
                class="flex-shrink flex-grow text-xl font-bold leading-5 text-gray-700"
            >
                টাকা জমার রশিদ
            </div>
            <print-button />
        </div>

        <payment-templete :data="data" class="max-w-3xl" />
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/App.vue";
import { Head } from "@inertiajs/inertia-vue3";
import ActionButtonEdit from "@/Components/ActionButtonEdit.vue";
import FormHeading from "@/Components/FormHeading.vue";
import InlineData from "@/Components/InlineData.vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import Button from "@/Components/Button.vue";
import PaymentTemplete from "@/Templete/Payment.vue";
import PrintButton from "@/Components/PrintButton.vue";

export default {
    components: {
        AppLayout,
        Head,
        ActionButtonEdit,
        FormHeading,
        InlineData,
        ApplicationLogo,
        Button,
        PaymentTemplete,
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
