<template>
    <div class="px-5 py-[17.5px] print:bg-white" :class="bgClorClass">
        <h3 class="text-center text-2xl font-extrabold">
            আসন নং- {{ $e2bnumber(String(seatNo).padStart(3, "0")) }}
        </h3>
        <div class="w-full text-xs">
            <div class="col-span-3 flex gap-2">
                <div class="w-12 text-gray-500">নাম</div>
                <span>:</span>
                <div>{{ data.student_name }}</div>
            </div>
            <div class="col-span-3 flex gap-2">
                <div class="w-12 text-gray-500">শ্রেণী</div>
                <span>:</span>
                <div>{{ data.class_name }}</div>
            </div>
            <div class="col-span-2 flex gap-2">
                <div class="w-12 text-gray-500">রোল</div>
                <span>:</span>
                <div>{{ $e2bnumber(data.class_roll) }}</div>
            </div>
            <div class="col-span-2 flex gap-2">
                <div class="w-12 text-gray-500">রেজি. নং</div>
                <span>:</span>
                <div>{{ $e2bnumber(data.registration) }}</div>
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
        seatNo: {
            type: Number,
            default: 0,
        },
        bgClorClass: {
            type: String,
            default: "bg-gray-200",
        },
    },
    created() {
        if (this.data.class_name == "") {
            this.data.class_name = "অনুরোধ করা হয় নি";
        }
    },
};
</script>
