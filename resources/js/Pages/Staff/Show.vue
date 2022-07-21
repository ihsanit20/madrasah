<template>
    <Head title="শিক্ষক/স্টাফ" />

    <app-layout pageTitle="শিক্ষক/স্টাফ">
        <div class="max-w-xl rounded border bg-white p-3 shadow md:p-4">
            <div class="flex items-end justify-end">
                <div class="flex items-center gap-2">
                    <action-button-edit
                        :href="route('staff.edit', data.staff.id)"
                    />
                </div>
            </div>
            <form-heading class="mb-2">Basic Information</form-heading>
            <div class="flex gap-2">
                <label class="shrink-0 grow-0 text-gray-700">ছবি :</label>
                <div class="w-full">
                    <image-previe-with-save
                        class="w-44"
                        ratioClass="aspect-[40/48]"
                        option="staff"
                        :imageUrl="data.staff.imageUrl"
                        :id="data.staff.id"
                    />
                </div>
            </div>
            <div class="grid">
                <inline-data title="নাম :" :value="data.staff.name" />
                <inline-data
                    title="পদবি :"
                    :value="data.staff.designationTitle"
                />
                <inline-data title="ফোন :" :value="data.staff.phone" />
            </div>
            <div class="flex gap-2">
                <label class="shrink-0 grow-0 text-gray-700">সাক্ষর :</label>
                <div class="w-full">
                    <image-previe-with-save
                        class="w-60"
                        ratioClass="aspect-[16/9]"
                        option="staff"
                        :imageUrl="data.staff.signatureUrl"
                        :id="data.staff.id"
                        :type="2"
                    />
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/App.vue";
import { Head } from "@inertiajs/inertia-vue3";
import ActionButtonEdit from "@/Components/ActionButtonEdit.vue";
import FormHeading from "@/Components/FormHeading.vue";
import InlineData from "@/Components/InlineData.vue";
import ImagePrevieWithSave from "@/Components/ImagePrevieWithSave.vue";

export default {
    components: {
        AppLayout,
        Head,
        ActionButtonEdit,
        FormHeading,
        InlineData,
        ImagePrevieWithSave,
    },
    props: {
        data: {
            type: Object,
            default: {},
        },
    },
};
</script>
