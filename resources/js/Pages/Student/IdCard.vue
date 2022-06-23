<template>
    <Head title="Student" />

    <app-layout>
        <h2
            class="flex-shrink flex-grow text-xl font-bold leading-5 text-gray-700"
        >
            আইডি কার্ড
        </h2>
        <div class="w-full max-w-3xl rounded border bg-white px-8 py-6 shadow">
            <div class="flex flex-wrap gap-8">
                <div class="w-60 space-y-2">
                    <h3 class="text-center font-bold">সামনের অংশ</h3>
                    <div class="h-96 border"></div>
                </div>
                <div class="w-60 space-y-2">
                    <h3 class="text-center font-bold">পিছনের অংশ</h3>
                    <div class="h-96 border"></div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import { Head } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/App.vue";
export default {
    components: {
        Head,
        AppLayout,
    },
    props: {
        data: {
            type: Object,
            default: {},
        },
    },
};
</script>
