<template>
    <Head title="বাবদ সমুহ" />

    <app-layout pageTitle="বাবদ সমুহ">
        <div class="w-full grid gap-2 md:grid-cols-2 md:gap-4">
            <Link
                :href="route('payments.purpose.show', index)"
                v-for="(purpose, index) in data.purposes"
                :key="index"
                class="flex items-center gap-2 rounded-md border bg-white p-2 hover:shadow md:gap-4 md:p-4"
            >
                <div
                    class="flex h-10 w-10 shrink-0 grow-0 items-center justify-center rounded-full bg-gray-200 text-xl font-bold text-gray-500 md:h-12 md:w-12 md:text-2xl"
                >
                    <MoneyReceiptSvg class="w-6 text-brand-600" />
                </div>
                <div class="shrink grow">
                    <div class="text-md font-bold text-brand-600 md:text-xl">
                        {{ $e2bnumber(purpose.title) }}
                    </div>
                    <div v-if="false" class="flex items-center gap-2">
                        <span class="text-gray-600"> আদায়: </span>
                        <span class="font-bold text-gray-800">
                            {{ $e2bnumber(data.totalPayment[index]) }} /
                            {{ $e2bnumber(data.totalStudent) }}
                        </span>
                    </div>
                </div>
            </Link>
        </div>
        <div>
            <hr class="my-3" />
        </div>
        <div v-if="false">
            <div class="w-full grid gap-2 md:grid-cols-2 md:gap-4">
                <Link
                    v-for="otherPurpose in data.otherPurposes"
                    :key="otherPurpose.id"
                    :href="route('others.purpose.show', otherPurpose.id)"
                    class="flex items-center gap-2 rounded-md border bg-white p-2 hover:shadow md:gap-4 md:p-4"
                >
                    <div
                        class="flex h-10 w-10 shrink-0 grow-0 items-center justify-center rounded-full bg-gray-200 text-xl font-bold text-gray-500 md:h-12 md:w-12 md:text-2xl"
                    >
                        <MoneyReceiptSvg class="w-6 text-brand-600" />
                    </div>
                    <div class="shrink grow">
                        <div class="text-md font-bold text-brand-600 md:text-xl">
                            {{ otherPurpose.title }}
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-gray-600"> আদায়: </span>
                            <span class="font-bold text-gray-800">
                                {{
                                    $e2bnumber(
                                        data.totalPayment[otherPurpose.id]
                                    )
                                }}
                                /
                                {{ $e2bnumber(data.totalStudent) }}
                            </span>
                        </div>
                    </div>
                </Link>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/GridApp.vue";
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
