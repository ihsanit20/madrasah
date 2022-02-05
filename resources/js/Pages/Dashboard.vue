<template>
    <Head title="Dashboard" />

    <AppLayout>
        <template #header> Overview </template>

        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
            <div class="border-b border-gray-200 bg-white p-6">
                You're logged in!
            </div>
        </div>
    </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/App.vue";
import { Head } from "@inertiajs/inertia-vue3";

export default {
    components: {
        AppLayout,
        Head,
    },
};
</script>
