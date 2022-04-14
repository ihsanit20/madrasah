<template>
    <Head title="Staff" />

    <app-layout pageTitle="View Staff">
        <div class="max-w-xl rounded border bg-white p-3 shadow md:p-4">
            <div class="flex items-end justify-end">
                <div class="flex items-center gap-2">
                    <action-button-edit
                        :href="route('staff.edit', data.staff.id)"
                    />
                </div>
            </div>
            <form-heading class="mb-2">Basic Information</form-heading>
            <div class="grid">
                <inline-data title="Name :" :value="data.staff.name" />
                <inline-data
                    title="পদবি :"
                    :value="data.staff.designationTitle"
                />
                <inline-data title="Phone :" :value="data.staff.phone" />
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
