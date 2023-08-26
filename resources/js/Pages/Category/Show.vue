<template>
    <Head :title="$page.props.request.type === '2' ? 'ব্যয়ের খাত' : 'আয়ের খাত'" />

    <app-layout :pageTitle="$page.props.request.type === '2' ? 'ব্যয়ের খাত' : 'আয়ের খাত'">
        <div class="max-w-xl rounded border bg-white p-3 shadow md:p-4">
            <div class="flex items-end justify-end">
                <div class="flex items-center gap-2">
                    <action-button-edit
                        :href="route('categories.edit', data.category.id)"
                    />
                </div>
            </div>
            <div class="grid">
                <inline-data :title="$page.props.request.type === '2' ? 'ব্যয়ের খাত :' : 'আয়ের খাত :'" :value="data.category.name" />
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/GridApp.vue";
import { Head } from "@inertiajs/vue3";
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
