<template>
    <Head title="Student" />

    <app-layout>
        <div class="max-w-3xl rounded p-3 md:p-4">
            <div
                class="flex flex-wrap items-end justify-between gap-4 print:hidden"
            >
                <h2
                    class="flex-shrink flex-grow text-xl font-bold leading-5 text-gray-700"
                >
                    ক্লাস/বিভাগ প্রিভিউ
                </h2>
                <print-button />
                <!-- <Link
                    :href="route('students.edit', data.student.id)"
                    class="flex flex-shrink-0 flex-grow-0 items-center justify-center gap-1 rounded bg-green-600 px-2.5 py-0.5 text-white"
                >
                    <PencilAltIcon class="w-5" />
                    <span class="hidden md:block">Edit</span>
                </Link> -->
            </div>
        </div>
        <div
            class="max-w-3xl overflow-x-auto rounded border bg-white print:border-0"
        >
            <admission-form-templete :data="data" class="min-w-max" />
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/App.vue";
import { Head } from "@inertiajs/inertia-vue3";
import ActionButtonEdit from "@/Components/ActionButtonEdit.vue";
import FormHeading from "@/Components/FormHeading.vue";
import InlineData from "@/Components/InlineData.vue";
import LetterHead from "@/Templete/LetterHead.vue";
import PrintButton from "@/Components/PrintButton.vue";
import AdmissionFormTemplete from "@/Templete/AdmissionForm.vue";

export default {
    components: {
        AppLayout,
        Head,
        ActionButtonEdit,
        FormHeading,
        InlineData,
        LetterHead,
        PrintButton,
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
