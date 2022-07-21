<template>
    <Head title="Student" />

    <app-layout>
        <StudentIdCard :data="data" :signature="signature" />
        <div class="w-full max-w-xl rounded px-6 py-6 print:hidden">
            <print-button class="mx-auto" />
        </div>
    </app-layout>
</template>

<script>
import { Head, Link } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/App.vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import AvatarView from "@/Components/AvatarView.vue";
import StudentIdCard from "../../Templete/StudentIdCard.vue";
import PrintButton from "@/Components/PrintButton.vue";
export default {
    components: {
        Head,
        Link,
        AppLayout,
        ApplicationLogo,
        AvatarView,
        StudentIdCard,
        PrintButton,
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
