<template>
    <div class="space-y-1" dir="rtl">
        <div class="flex items-center justify-center gap-4 font-bold">
            <div>{{ data.questionPaper.exam.arabic }}</div>
            <div>{{ $e2anumber(data.questionPaper.exam.session) }} ه</div>
        </div>
        <div class="grid grid-cols-2 gap-8">
            <inline-data
                title="الصف:"
                :value="data.questionPaper.class.arabic"
                class="justify-end"
            />
            <inline-data title="الموضوع:" :value="data.subject.arabic" />
        </div>
        <div dir="rtl" class="flex items-center justify-center gap-4">
            <div>{{ data.questionPaper.book_name }}</div>
        </div>
        <div class="grid grid-cols-2 gap-8">
            <inline-data
                title="القيمة الكاملة:"
                :value="$e2anumber(data.questionPaper.mark)"
                class="justify-start"
            />
            <inline-data
                class="justify-end"
                title="الوقت:"
                :value="`${
                    data.questionPaper.hour
                        ? $e2anumber(data.questionPaper.hour) + ' الساعات'
                        : ''
                } ${
                    data.questionPaper.minute
                        ? $e2anumber(data.questionPaper.minute) + ' الدقائق'
                        : ''
                }`"
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
