<template>
    <Head title="ভর্তি আবেদন" />

    <AppLayout>
        <div class="mx-auto mt-5 w-full max-w-3xl rounded bg-white p-4">
            <h2
                class="text-brand-600 mb-2 select-none text-center text-2xl font-bold print:text-black"
            >
                ভর্তি আবেদন ফর্ম নাম্বার
            </h2>
            <div class="flex items-center justify-center">
                <div class="select-all text-center text-4xl">{{ data.id }}</div>
            </div>
            <div class="flex items-center justify-between">
                <Link
                    method="delete"
                    as="button"
                    :href="route('admissions.online-forms.destroy', [data.id])"
                    class="flex flex-shrink-0 flex-grow-0 items-center justify-center gap-1 rounded bg-red-600 px-3 pt-1 text-white"
                >
                    <span class="hidden md:block">বাতিল করুন</span>
                    <span>&times;</span>
                </Link>
                <Link
                    :href="
                        route('admissions.create', {
                            type: data.type,
                            'online-form': data.id,
                        })
                    "
                    class="bg-brand-600 flex flex-shrink-0 flex-grow-0 items-center justify-center gap-1 rounded px-3 pt-1 text-white"
                >
                    <span class="hidden md:block">ভর্তি করুন</span>
                    <span>&rarr;</span>
                </Link>
            </div>
        </div>
        <div class="mx-auto max-w-3xl overflow-hidden rounded">
            <AdmissionFormPreview :data="data" />
        </div>
        <br />
    </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/Master.vue";
import { Head, Link } from "@inertiajs/vue3";
import AdmissionFormPreview from "../../Templete/AdmissionFormPreview.vue";

export default {
    components: {
        Head,
        Link,
        AppLayout,
        AdmissionFormPreview,
    },
    props: {
        data: Object,
    },
};
</script>
