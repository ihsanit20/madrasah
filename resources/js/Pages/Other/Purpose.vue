<template>
    <Head title="বাবদ সমুহ" />

    <app-layout pageTitle="বাবদ সমুহ">
        <div class="grid gap-2 md:grid-cols-2 md:gap-4">
            <Link
                v-for="(purpose, index) in data.purposes"
                :key="index"
                :href="route('others.purpose.show', purpose.id)"
                class="flex items-center gap-2 rounded-md border bg-white p-2 hover:shadow md:gap-4 md:p-4"
            >
                <div
                    class="flex h-10 w-10 shrink-0 grow-0 items-center justify-center rounded-full bg-gray-200 text-xl font-bold text-gray-500 md:h-12 md:w-12 md:text-2xl"
                >
                    <MoneyReceiptSvg class="w-6 text-sky-600" />
                </div>
                <div class="shrink grow">
                    <div class="text-md font-bold text-sky-600 md:text-xl">
                        {{ purpose.title }}
                    </div>
                    <div v-if="false" class="flex items-center gap-2">
                        <span class="text-gray-600"> আদায়: </span>
                        <span class="font-bold text-gray-800">
                            {{ $e2bnumber(data.totalPayment[purpose.id]) }} /
                            {{ $e2bnumber(data.totalStudent[purpose.id]) }}
                        </span>
                    </div>
                </div>
            </Link>
        </div>
        <div class="hidden">
            <hr class="mb-2" />
            <div hidden class="grid gap-2 md:grid-cols-2 md:gap-4">
                <Link
                    :href="route('purposes.create')"
                    class="flex items-center gap-2 rounded-md border border-dashed border-sky-600 p-2 md:gap-4 md:p-4"
                >
                    <div
                        class="flex h-10 w-10 shrink-0 grow-0 items-center justify-center rounded-full bg-gray-200 text-xl font-bold text-gray-500 md:h-12 md:w-12 md:text-2xl"
                    >
                        <span class="text-2xl text-sky-600">+</span>
                    </div>
                    <div class="shrink grow">
                        <div class="text-md font-bold text-sky-600 md:text-xl">
                            Add New
                        </div>
                    </div>
                </Link>
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
