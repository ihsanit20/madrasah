<template>
    <div class="bg-white px-6 py-4 print:py-0 print:px-4">
        <letter-head :photoUrl="student.imageUrl || '/images/hijab-icon.jpg'" />
        <div class="mt-4 mb-2 flex items-center justify-center">
            <div
                class="rounded-md border px-4 py-1 text-center text-2xl font-bold print:border-black print:text-black"
            >
                প্রবেশ পত্র
            </div>
        </div>
        <div class="grid gap-2">
            <hr class="print:hidden" />
            <h3
                class="mt-3 text-center text-2xl font-bold print:mt-28 print:text-black"
            >
                শিক্ষার্থীর অঙ্গীকার
            </h3>
            <div>
                আমি অত্র মাদরাসায় ভর্তি হতে ইচ্ছুক। আমি মনে প্রাণে অঙ্গীকার করছি
                যে,
            </div>
            <div class="flex items-center justify-between gap-4">
                <div>
                    <inline-data title="আবেদনকারীর স্বাক্ষর" />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import CheckUncheckIcon from "@/Components/CheckUncheckIcon.vue";
import InlineData from "@/Components/InlineData.vue";
import Input from "@/Components/Input.vue";
import LetterHead from "@/Templete/LetterHead.vue";
export default {
    components: {
        LetterHead,
        Input,
        InlineData,
        CheckUncheckIcon,
    },
    props: {
        data: {
            type: Object,
            default: {},
        },
        student: {
            type: Object,
            default: {},
        },
    },
};
</script>
