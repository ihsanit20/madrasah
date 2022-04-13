<template>
    <Head title="Setting" />

    <app-layout pageTitle="View Setting">
        <div class="max-w-xl rounded border bg-white p-3 shadow md:p-4">
            <div class="flex items-end justify-end">
                <div class="flex items-center gap-2">
                    <action-button-edit
                        :href="route('settings.edit', data.setting.id)"
                    />
                </div>
            </div>
            <form-heading class="mb-2">{{ data.setting.name }}</form-heading>
            <div class="whitespace-normal">
                {{ data.setting.value }}
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
