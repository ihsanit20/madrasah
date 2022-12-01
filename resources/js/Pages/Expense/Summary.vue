<template>
    <Head title="ব্যয় সামারি" />

    <app-layout pageTitle="ব্যয় সামারি">
        <div
            class="grid gap-2 rounded-md border bg-white p-2 hover:shadow md:gap-4 md:p-4"
        >
            <div
                v-for="category in data.categories"
                :key="category.id"
                class="grid grid-cols-2 items-center gap-3 md:grid-cols-4 md:gap-4"
            >
                <div class="text-right">{{ category.name }} :</div>
                <div>{{ category.total }}</div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/App.vue";
import { MoneyReceiptSvg } from "@/Layouts/Navigation/SvgIcon";
import { Head, Link } from "@inertiajs/inertia-vue3";

export default {
    components: {
        AppLayout,
        Head,
        Link,
        MoneyReceiptSvg,
    },
    props: {
        data: {
            type: Object,
            default: {},
        },
    },
};
</script>
