<template>
    <Head title="Student" />

    <app-layout>
        <div class="mx-auto w-full max-w-xl rounded px-6 py-6">
            <StaffIdCard :staff="data.staff" :data="data" :signature="signature" />
        </div>
    </app-layout>
</template>

<script>
import { Head, Link } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/Master.vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import AvatarView from "@/Components/AvatarView.vue";
import StaffIdCard from "../../Templete/StaffIdCard.vue";
export default {
    components: {
        Head,
        Link,
        AppLayout,
        ApplicationLogo,
        AvatarView,
        StaffIdCard,
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
