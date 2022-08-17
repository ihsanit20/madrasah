<template>
    <Head title="Student" />

    <app-layout>
        <div
            v-for="student in data.students"
            :key="student.id"
            class="pb-10 print:break-before-page print:border-0 print:pb-0"
        >
            <AdmitCard :data="data" :student="student" />
        </div>
        <div class="w-full max-w-5xl rounded py-6 print:hidden">
            <print-button />
        </div>
    </app-layout>
</template>

<script>
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import AvatarView from "@/Components/AvatarView.vue";
import PrintButton from "@/Components/PrintButton.vue";
import AppLayout from "@/Layouts/App.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import AdmitCard from "../../Templete/AdmitCard.vue";
export default {
    components: {
        Head,
        Link,
        AppLayout,
        ApplicationLogo,
        AvatarView,
        AdmitCard,
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
