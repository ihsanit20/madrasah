<template>
    <Head title="Student" />

    <app-layout>
        <div class="mx-auto w-full max-w-xl rounded px-6 py-6">
            <StudentIdCard :data="data" :signature="signature" />
        </div>
    </app-layout>
</template>

<script>
import { Head, Link } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/Master.vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import AvatarView from "@/Components/AvatarView.vue";
import StudentIdCard from "../../Templete/StudentIdCard.vue";
export default {
    components: {
        Head,
        Link,
        AppLayout,
        ApplicationLogo,
        AvatarView,
        StudentIdCard,
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
