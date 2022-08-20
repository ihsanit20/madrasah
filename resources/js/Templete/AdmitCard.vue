<template>
    <div
        class="w-full bg-white bg-[url('/images/wmlogo.png')] bg-center bg-no-repeat px-12 py-4 print:py-0 print:px-4"
    >
        <letter-head :photoUrl="student.imageUrl || '/images/hijab-icon.jpg'" />

        <div
            class="mt-2 flex items-center justify-center gap-4 text-lg font-bold"
        >
            <div>{{ data.exam.name }}</div>
            <div>{{ data.exam.session }} হিজরি</div>
        </div>

        <div class="mt-1.5 mb-2 flex items-center justify-center">
            <div
                class="rounded-md border px-4 py-0.5 text-center text-2xl font-bold print:border-black print:text-black"
            >
                প্রবেশ পত্র
            </div>
        </div>

        <div class="grid grid-cols-5">
            <div class="col-span-3 flex gap-2">
                <div class="w-24 text-gray-500 print:text-black">
                    শিক্ষার্থীর নাম
                </div>
                <span>:</span>
                <div>{{ student.name }}</div>
            </div>
            <div class="col-span-2 flex gap-2">
                <div class="w-20 text-gray-500 print:text-black">রেজি. নং</div>
                <span>:</span>
                <div>{{ $e2bnumber(student.registration) }}</div>
            </div>
            <div class="col-span-3 flex gap-2">
                <div class="w-24 text-gray-500 print:text-black">শ্রেণী</div>
                <span>:</span>
                <div>{{ student.currentClassName }}</div>
            </div>
            <div class="col-span-2 flex gap-2">
                <div class="w-20 text-gray-500 print:text-black">
                    শ্রেণী রোল
                </div>
                <span>:</span>
                <div>{{ $e2bnumber(student.currentClassRoll) }}</div>
            </div>
            <div class="col-span-3 flex gap-2">
                <div class="w-24 text-gray-500 print:text-black">অভিভাবক</div>
                <span>:</span>
                <div>{{ student.guardianInfo.name }}</div>
            </div>
            <div class="col-span-2 flex gap-2">
                <div class="w-20 text-gray-500 print:text-black">আসন নং</div>
                <span>:</span>
                <div v-if="student.seatNumber">
                    {{
                        $e2bnumber(String(student.seatNumber).padStart(3, "0"))
                    }}
                </div>
            </div>
        </div>

        <hr class="mt-1" />

        <div class="grid py-1">
            <div class="text-md font-bold">বিষয় কোডসহ পরীক্ষার বিষয়সমূহ :</div>
            <div class="grid grid-cols-3 gap-x-3 px-3">
                <div
                    v-for="subject in data.class.subjects"
                    :key="subject.id"
                    class="text-sm font-semibold"
                >
                    {{ $e2bnumber(subject.code) }} - {{ subject.name }}
                </div>
            </div>
        </div>

        <hr class="mb-1" />

        <div class="flex items-end justify-between gap-4 py-2">
            <div class="">
                <div class="text-xs">পরীক্ষার্থীদের জন্য জ্ঞতব্য বিষয়</div>
                <div class="whitespace-pre-wrap text-xs print:px-4 md:px-6">
                    {{ $page.props.settings.admitCardText }}
                </div>
            </div>
            <div class="flex min-w-max flex-col items-center justify-center">
                <img :src="data.signature" class="w-28" />
                <div>অধ্যক্ষের স্বাক্ষর</div>
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
