<template>
    <div class="space-y-1">
        <div class="flex items-center justify-center gap-4 font-bold">
            <div>{{ data.questionPaper.exam.name }}</div>
            <div>{{ $e2bnumber(data.questionPaper.exam.session) }} হিজরি</div>
        </div>
        <div class="grid grid-cols-2 gap-8">
            <inline-data
                title="শ্রেণী:"
                :value="data.questionPaper.class.name"
                class="justify-end"
            />
            <inline-data title="বিষয়:" :value="data.subject.name" />
        </div>
        <div class="grid grid-cols-2 gap-8">
            <inline-data
                title="সময়:"
                :value="`${
                    data.questionPaper.hour
                        ? $e2bnumber(data.questionPaper.hour) + ' ঘণ্টা'
                        : ''
                } ${
                    data.questionPaper.minute
                        ? $e2bnumber(data.questionPaper.minute) + ' মিনিট'
                        : ''
                }`"
            />
            <inline-data
                title="পূর্ণমান:"
                :value="$e2bnumber(data.questionPaper.mark)"
                class="justify-end"
            />
        </div>
    </div>
</template>

<script>
import InlineData from "@/Components/InlineData.vue";
export default {
    components: {
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
