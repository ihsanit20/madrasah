<template>
    <div class="bg-white p-10">
        <letter-head />
        <div class="my-3 space-y-3">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <inline-data title="রশিদ নং:" :value="data.payment.id" />
                </div>
                <div>
                    <inline-data title="তারিখ:" :value="data.payment.date" />
                </div>
            </div>
            <div class="flex items-center justify-between gap-4">
                <div>
                    <inline-data
                        title="শিক্ষার্থীর নাম:"
                        :value="data.payment.admission.studentName"
                    />
                </div>
                <div>
                    <inline-data
                        title="Reg. No:"
                        :value="data.payment.admission.student.registration"
                    />
                </div>
            </div>
            <div class="flex items-center justify-between gap-4">
                <div>
                    <inline-data
                        title="ক্লাস/বিভাগ:"
                        :value="data.payment.admission.className"
                    />
                </div>
                <div>
                    <inline-data
                        title="রোল:"
                        :value="data.payment.admission.roll"
                    />
                </div>
            </div>
            <div class="flex items-center justify-between gap-4">
                <div>
                    <inline-data
                        title="জমার রশিদ ধরণ:"
                        :value="data.payment.periodName"
                    />
                </div>
                <div v-if="data.payment.month">
                    <inline-data title="মাস:" :value="data.payment.month" />
                </div>
            </div>
            <div class="col-span-full border">
                <div
                    v-for="(fee, index) in data.payment.details"
                    :key="index"
                    class="flex items-center justify-between border-b"
                >
                    <div class="shrink grow p-3">
                        {{ fee.title }}
                    </div>
                    <div class="w-24 shrink-0 grow-0 border-l p-3 text-right">
                        {{ fee.amount }}
                    </div>
                </div>
                <div class="flex items-center justify-between border-b">
                    <div class="shrink grow p-3 text-right">মোট</div>
                    <div class="w-24 shrink-0 grow-0 border-l p-3 text-right">
                        {{ data.payment.total }}
                    </div>
                </div>
                <div class="flex items-center justify-between border-b">
                    <div class="shrink grow p-3 text-right">জমা</div>
                    <div class="w-24 shrink-0 grow-0 border-l p-3 text-right">
                        {{ data.payment.paid }}
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <div class="shrink grow p-3 text-right">বকেয়া</div>
                    <div class="w-24 shrink-0 grow-0 border-l p-3 text-right">
                        {{ data.payment.due }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import InlineData from "@/Components/InlineData.vue";
import LetterHead from "./LetterHead.vue";
export default {
    components: {
        LetterHead,
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
