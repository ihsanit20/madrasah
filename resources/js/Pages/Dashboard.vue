<template>
    <Head title="Dashboard" />

    <app-layout pageTitle="Overview">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
            <div class="border-b border-gray-200 bg-white p-6">
                Now, You're logged in!
            </div>
        </div>
    </app-layout>
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
