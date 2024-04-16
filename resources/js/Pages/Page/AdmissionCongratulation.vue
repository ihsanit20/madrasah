<template>
    <Head title="ভর্তি আবেদন" />

    <AppLayout>
        <div
            class="mx-auto mt-5 w-full max-w-3xl rounded bg-white p-4"
        >
            <h2
                class="text-brand-600 mb-2 select-none text-center text-2xl font-bold print:text-black"
            >
                ভর্তি আবেদন ফর্ম নাম্বার
            </h2>
            <div class="flex items-center justify-center">
                <div class="text-center text-4xl select-all">{{ data.id }}</div>
            </div>
            <p class="text-center select-none">
                এটি সংরক্ষণ করুন এবং অফিসে যোগাযোগ করুন
            </p>
        </div>
        <div class="mx-auto max-w-3xl rounded overflow-hidden">
            <AdmissionFormPreview :data="data" />
        </div>
        <br />
    </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/Master.vue";
import { Head } from "@inertiajs/vue3";
import AdmissionFormPreview from "../../Templete/AdmissionFormPreview.vue";

export default {
    components: {
        Head,
        AppLayout,
        AdmissionFormPreview,
    },
    props: {
        data: Object,
    },
};
</script>
