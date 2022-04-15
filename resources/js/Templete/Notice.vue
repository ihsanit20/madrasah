<template>
    <div class="bg-white p-10">
        <letter-head />
        <div class="py-3 print:text-black">
            তারিখ: <b>{{ data.notice.formatedDate }}</b>
        </div>
        <h2 class="mt-4 mb-2 text-center text-2xl font-bold print:text-black">
            {{ data.notice.title }}
        </h2>
        <div
            class="whitespace-pre-wrap text-justify print:text-black"
            v-html="data.notice.body"
        ></div>
        <div class="mt-20 flex justify-end">
            <div class="text-center">
                <div class="tex-lg font-bold print:text-black">
                    {{ data.notice.staffName }}
                </div>
                <div class="print:text-black">
                    ({{ data.notice.staff.designationTitle }})
                </div>
                <div class="print:text-black">
                    {{ $page.props.settings.siteName }}
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import LetterHead from "@/Templete/LetterHead.vue";
export default {
    components: {
        LetterHead,
    },
    props: {
        data: {
            type: Object,
            default: {},
        },
    },
};
</script>
