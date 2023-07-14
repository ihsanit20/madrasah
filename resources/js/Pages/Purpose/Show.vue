<template>
    <Head title="বাবদ" />

    <app-layout>
        <div class="max-w-xl rounded border bg-white p-3 shadow md:p-4">
            <div class="flex items-end justify-end">
                <div class="flex items-center gap-2">
                    <action-button-edit
                        :href="route('purposes.edit', data.purpose.id)"
                    />
                </div>
            </div>
            <div class="grid gap-2">
                <inline-data title="বাবদ:" :value="data.purpose.title" />
            </div>
            <div class="grid gap-2">
                <inline-data
                    v-for="purpose_fee in data.purpose.purpose_fees"
                    :key="purpose_fee.id"
                    :title="purpose_fee.class_name"
                    :value="purpose_fee.amount + ' TK'"
                />
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/GridApp.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import ActionButtonEdit from "@/Components/ActionButtonEdit.vue";
import FormHeading from "@/Components/FormHeading.vue";
import InlineData from "@/Components/InlineData.vue";

export default {
    components: {
        AppLayout,
        Head,
        Link,
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
