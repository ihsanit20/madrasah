<template>
    <Head title="Student" />

    <app-layout>
        <div class="w-full max-w-xl rounded px-6 py-6 print:hidden">
            <print-button class="mx-auto" />
        </div>
        <div
            v-for="student in students"
            :key="student.id"
            class="border-b border-gray-700 pb-10 print:break-before-page print:border-0 print:pb-0"
        >
            <StudentIdCard :data="{ student }" :signature="signature" />
        </div>
    </app-layout>
</template>

<script>
import { Head, Link } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/GridApp.vue";
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
        students: {
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
