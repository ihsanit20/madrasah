<template>
    <div class="bg-white p-4 print:py-0">
        <div class="relative">
            <div class="mx-auto flex items-center justify-center gap-4">
                <application-logo class="w-14 print:w-12" />
                <div
                    class="flex flex-col items-center justify-end space-y-1 print:space-y-0"
                >
                    <h1
                        class="text-2xl font-bold text-blue-900 print:text-lg print:text-black"
                    >
                        {{ $page.props.settings.siteName }}
                    </h1>
                    <p class="text-[11px] print:text-[8px] print:text-black">
                        {{ $page.props.settings.siteAddress }}
                    </p>
                </div>
            </div>

            <div
                class="my-1 border border-b-0 border-gray-400 print:border-black"
            ></div>
        </div>
        <div class="my-2">
            <div class="flex items-center justify-between gap-x-2">
                <div>
                    <inline-data
                        class="print:text-xs"
                        title="রশিদ নং:"
                        :value="$e2bnumber(data.payment.id)"
                    />
                </div>
                <div>
                    <inline-data
                        class="print:text-xs"
                        title="তারিখ:"
                        :value="$e2bnumber(data.payment.date)"
                    />
                </div>
            </div>
            <div class="flex items-center justify-between gap-x-2">
                <div>
                    <inline-data
                        class="print:text-xs"
                        title="শিক্ষার্থীর নাম:"
                        :value="data.payment.admission.studentName"
                    />
                </div>
                <div>
                    <inline-data
                        class="print:text-xs"
                        title="রোল:"
                        :value="$e2bnumber(data.payment.admission.roll)"
                    />
                </div>
            </div>
            <div class="flex items-center justify-between gap-x-2">
                <div>
                    <inline-data
                        class="print:text-xs"
                        title="ক্লাস/বিভাগ:"
                        :value="data.payment.admission.className"
                    />
                </div>
                <div>
                    <inline-data
                        class="print:text-xs"
                        title="রেজি. নং:"
                        :value="
                            $e2bnumber(
                                data.payment.admission.student.registration
                            )
                        "
                    />
                </div>
            </div>

            <div
                class="my-1 border border-b-0 border-gray-400 print:border-black"
            ></div>

            <div class="flex items-center justify-center">
                <span
                    class="rounded-full bg-sky-600 px-8 pt-1.5 pb-0.5 text-center text-base font-bold text-white print:bg-gray-500 print:text-sm"
                >
                    টাকা জমার রশিদ
                </span>
            </div>
            <div class="flex items-center justify-center gap-4 py-1">
                <div class="print:text-sm">
                    <inline-data
                        title="বাবদ:"
                        :value="data.payment.purposeText"
                    />
                </div>
            </div>
            <div class="col-span-full">
                <div
                    class="flex items-center justify-between bg-gray-300 px-3 pt-1 font-semibold"
                >
                    <div class="w-10 shrink-0 grow-0 print:text-xs">ক্রম</div>
                    <div class="shrink grow text-left print:text-xs">
                        ফি বিবরণ
                    </div>
                    <div class="w-24 shrink-0 grow-0 text-right print:text-xs">
                        টাকা
                    </div>
                </div>
                <div
                    v-for="(fee, index) in data.payment.details"
                    :key="index"
                    class="flex items-center justify-between px-3 pt-1 print:text-black"
                    :class="{ 'bg-gray-100': index % 2 }"
                >
                    <div
                        class="w-10 shrink-0 grow-0 print:text-xs print:text-black"
                    >
                        {{ $e2bnumber(index + 1).padStart(2, $e2bnumber(0)) }}.
                    </div>
                    <div
                        class="shrink grow text-left print:text-xs print:text-black"
                    >
                        {{ fee.title }}
                    </div>
                    <div class="w-24 shrink-0 grow-0 text-right print:text-xs">
                        <div class="flex items-center justify-end gap-2">
                            <span
                                v-if="fee.concession"
                                class="text-gray-400 line-through print:text-black"
                            >
                                {{ $e2bnumber(fee.amount + fee.concession) }}
                            </span>
                            <span class="print:text-black">{{
                                $e2bnumber(fee.amount)
                            }}</span>
                        </div>
                    </div>
                </div>

                <div
                    class="my-1 border border-b-0 border-gray-400 print:border-black"
                ></div>

                <div
                    class="flex items-center justify-between px-3 font-semibold print:text-sm"
                >
                    <div class="shrink grow text-right">মোট:</div>
                    <div class="w-16 shrink-0 grow-0 text-right">
                        {{ $e2bnumber(data.payment.total) }}
                    </div>
                </div>
                <div
                    class="flex items-center justify-between px-3 font-semibold print:text-sm"
                >
                    <div class="shrink grow text-right">বাকী:</div>
                    <div class="w-16 shrink-0 grow-0 text-right">
                        {{ $e2bnumber(data.payment.due) }}
                    </div>
                </div>
                <div
                    class="flex items-center justify-end font-semibold print:text-sm"
                >
                    <div class="shrink-0 grow-0 bg-gray-100 px-3 text-right">
                        জমা:
                    </div>
                    <div
                        class="w-16 shrink-0 grow-0 bg-gray-100 pr-3 text-right"
                    >
                        {{ $e2bnumber(data.payment.paid) }}
                    </div>
                </div>

                <div
                    class="my-1 border border-b-0 border-gray-400 print:border-black"
                ></div>

                <div class="py-1 print:text-[10px]">
                    আমি শিক্ষার্থী/অভিভাবকের কাছ থেকে উপরোক্ত পরিমাণ টাকা বুঝে
                    পেয়েছি ।
                </div>
                <div class="mt-10 flex items-center justify-between gap-x-2">
                    <div>
                        <inline-data
                            class="print:text-xs"
                            title="গ্রহিতার নাম:"
                            :value="data.payment.collectorName"
                        />
                    </div>
                    <div>
                        <inline-data
                            class="print:text-xs"
                            title="গ্রহিতার স্বাক্ষর"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import InlineData from "@/Components/InlineData.vue";
import LetterHead from "./LetterHead.vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
export default {
    components: {
        LetterHead,
        InlineData,
        ApplicationLogo,
    },
    props: {
        data: {
            type: Object,
            default: {},
        },
    },
};
</script>
