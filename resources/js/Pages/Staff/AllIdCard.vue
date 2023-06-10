<template>
    <Head title="Staff" />

    <app-layout>
        <div class="w-full max-w-xl rounded px-6 py-6 print:hidden">
            <print-button class="mx-auto" />
        </div>
        <div
            v-for="staff in staffList"
            :key="staff.id"
            class="border-b border-gray-700 pb-10 print:break-before-page print:border-0 print:pb-0"
        >
            <StaffIdCard :staff="staff" :data="data" :signature="signature" />
        </div>
    </app-layout>
</template>

<script>
import { Head, Link } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/App.vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import AvatarView from "@/Components/AvatarView.vue";
import StaffIdCard from "../../Templete/StaffIdCard.vue";
import PrintButton from "@/Components/PrintButton.vue";
export default {
    components: {
        Head,
        Link,
        AppLayout,
        ApplicationLogo,
        AvatarView,
        StaffIdCard,
        PrintButton,
    },
    props: {
        staffList: {
            type: Object,
            default: {},
        },
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
