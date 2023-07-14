<template>
    <Head title="Admin" />

    <app-layout pageTitle="View Admin">
        <div class="max-w-xl rounded border bg-white p-3 shadow md:p-4">
            <div class="flex items-end justify-end">
                <div class="flex items-center gap-2">
                    <action-button-edit
                        :href="route('admins.edit', data.admin.id)"
                    />
                </div>
            </div>
            <form-heading class="mb-2">Basic Information</form-heading>
            <div class="grid">
                <inline-data title="Admin's Name :" :value="data.admin.name" />
                <inline-data
                    title="Admin's Email :"
                    :value="data.admin.email"
                />
                <inline-data title="Admin's Password :" value="*****" />
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/GridApp.vue";
import { Head } from "@inertiajs/inertia-vue3";
import ActionButtonEdit from "@/Components/ActionButtonEdit.vue";
import FormHeading from "@/Components/FormHeading.vue";
import InlineData from "@/Components/InlineData.vue";

export default {
    components: {
        AppLayout,
        Head,
        ActionButtonEdit,
        FormHeading,
        InlineData,
    },
    props: {
        data: {
            type: Object,
            default: {},
        },
    },
};
</script>
