<template>
    <Head title="Student" />

    <app-layout>
        <div class="max-w-3xl rounded p-3 md:p-4">
            <div class="flex items-end justify-between gap-4 print:hidden">
                <h2
                    class="flex-shrink flex-grow text-xl font-bold leading-5 text-gray-700"
                >
                    আবেদন ফরম প্রিভিউ
                </h2>
                <print-button />
                <Link
                    :href="route('admissions.edit', data.admission.id)"
                    class="flex flex-shrink-0 flex-grow-0 items-center justify-center gap-1 rounded bg-green-600 px-2.5 py-0.5 text-white"
                >
                    <PencilAltIcon class="w-5" />
                    <span class="hidden md:block">সম্পাদনা</span>
                </Link>
            </div>
        </div>
        <div class="max-w-3xl rounded border bg-white print:border-0">
            <admission-form-templete :data="data" />
        </div>
        <div class="flex items-center justify-center pt-2 print:hidden">
            <Link
                :href="
                    route('admissions.show', data.admission.id) + '?next=true'
                "
                class="flex flex-shrink-0 flex-grow-0 items-center justify-center gap-1 rounded bg-green-600 px-2.5 py-0.5 text-white"
            >
                পরবর্তী ধাপে যান &#8594;
            </Link>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/App.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import ActionButtonEdit from "@/Components/ActionButtonEdit.vue";
import FormHeading from "@/Components/FormHeading.vue";
import InlineData from "@/Components/InlineData.vue";
import LetterHead from "@/Templete/LetterHead.vue";
import PrintButton from "@/Components/PrintButton.vue";
import { PencilAltIcon } from "@heroicons/vue/outline";
import AdmissionFormTemplete from "@/Templete/AdmissionForm.vue";

export default {
    components: {
        AppLayout,
        Head,
        Link,
        ActionButtonEdit,
        FormHeading,
        InlineData,
        LetterHead,
        PrintButton,
        PencilAltIcon,
        AdmissionFormTemplete,
    },
    props: {
        data: {
            type: Object,
            default: {},
        },
    },
    data() {
        return {
            columns: [
                { title: "Code", align: "left" },
                { title: "Name", align: "left" },
            ],
        };
    },
};
</script>
