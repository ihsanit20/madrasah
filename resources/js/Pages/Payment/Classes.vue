<template>
    <Head title="ক্লাস/বিভাগ সমুহ" />

    <app-layout :pageTitle="`ক্লাস/বিভাগ সমুহ (${data.purpose.title})`">
        <div class="grid gap-2 md:grid-cols-2 md:gap-4">
            <div
                v-for="classes in data.classes"
                :key="classes.id"
                class="flex items-center gap-2 rounded-md border bg-white p-2 hover:shadow md:gap-4 md:p-4"
            >
                <div
                    class="flex h-10 w-10 shrink-0 grow-0 items-center justify-center rounded-full bg-gray-200 text-xl font-bold text-gray-500 md:h-12 md:w-12 md:text-2xl"
                >
                    {{ $e2bnumber(classes.code).padStart(2, $e2bnumber("0")) }}
                </div>
                <div class="shrink grow">
                    <div class="text-md font-bold text-sky-600 md:text-xl">
                        {{ classes.name }}
                    </div>
                    <div class="flex items-center gap-2">
                        <MoneyReceiptSvg class="w-5 text-gray-400" />
                        <span class="text-gray-600"> আদায়: </span>
                        <span class="font-bold text-gray-800">
                            {{ $e2bnumber(data.totalPayment[classes.id]) }} /
                            {{ $e2bnumber(classes.totalStudent) }}
                        </span>
                    </div>
                </div>
                <nav-link
                    :href="
                        route('payments.purpose.class', [
                            data.purposeId,
                            classes.id,
                        ])
                    "
                    class="border bg-rose-600/70 px-3 pt-2 pb-1 text-white"
                >
                    বিস্তারিত
                </nav-link>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/App.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import { MoneyReceiptSvg } from "@/Layouts/Navigation/SvgIcon";

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
