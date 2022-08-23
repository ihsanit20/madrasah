<template>
    <div class="space-y-1">
        <div class="flex items-center justify-center gap-4 font-bold">
            <div>{{ data.questionPaper.exam.english }}</div>
            <div>{{ data.questionPaper.exam.session }} Hijri</div>
        </div>
        <div class="grid grid-cols-2 gap-8">
            <inline-data
                title="Class:"
                :value="data.questionPaper.class.english"
                class="justify-end"
            />
            <inline-data title="Subject:" :value="data.subject.english" />
        </div>
        <div class="grid grid-cols-2 gap-8">
            <inline-data
                title="Time:"
                :value="`${
                    data.questionPaper.hour
                        ? data.questionPaper.hour + ' Hour'
                        : ''
                } ${
                    data.questionPaper.minute
                        ? data.questionPaper.minute + ' Minute'
                        : ''
                }`"
            />
            <inline-data
                title="Full Mark:"
                :value="data.questionPaper.mark"
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
