<template>
    <Head title="Student" />

    <app-layout>
        <div
            v-for="n in total"
            :key="n"
            class="flex flex-col items-center justify-around pb-10 print:break-before-page print:border-0 print:pb-0"
        >
            <AdmitCard
                v-if="n * 2 - 2 < data.students.length"
                :data="data"
                :student="data.students[n * 2 - 2]"
            />
            <div class="my-6"></div>
            <AdmitCard
                v-if="n * 2 - 1 < data.students.length"
                :data="data"
                :student="data.students[n * 2 - 1]"
            />
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
    created() {
        this.total = Math.ceil(this.data.students.length / 2);
    },
    data() {
        return {
            total: 0,
            index: 0,
        };
    },
};
</script>
