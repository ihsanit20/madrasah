<template>
    <div class="flex flex-wrap gap-8 md:flex-row font-noto-sans-bengali">
        <div class="w-[204px] space-y-2">
            <h3 class="text-center font-bold print:hidden">সামনের অংশ</h3>
            <div class="h-[324px] border bg-white py-3 flex flex-col justify-between" style="background-image: url(/images/new-bg.svg); background-repeat: no-repeat;">
                
                <div
                    class="flex flex-col items-center justify-center"
                >
                    <application-logo class="h-9" />
                    <!-- <img class="h-9 rounded-full" src="/images/logo-ms.png" alt=""> -->
                    <h2
                        class="text-[13px] font-bold text-white"
                    >
                        {{ $page.props.settings.siteName }}
                    </h2>
                </div>

                
                <div class="flex justify-center">
                   <div :class="[ 'px-2 rounded-full', data.student.resident == 2 ? 'bg-brand-500' : 'bg-orange-600']">
                        <h2 class="text-[10px] mt-[3px] text-center text-white" >{{ data.student.residentText }} শিক্ষার্থীর পরিচয়পত্র</h2>
                    </div> 
                </div>
                <div :class="[ 'mx-auto aspect-square w-[80px] overflow-hidden border-4 border-double bg-white rounded-full', data.student.resident == 2 ? 'border-brand-500' : 'border-orange-600']"
                >
                    <img
                        :src="
                            data.student.imageUrl ||
                            '/images/hijab-icon.jpg'
                        "
                        class="h-full w-full object-cover"
                    />
                </div>

                <div class="text-center text-[13px] font-semibold"
                >
                    <h1 class="pb-[2px] line-clamp-1 mt-[2px] text-brand-700">
                        {{ data.student.name }}
                    </h1>
                    <div
                        class="flex items-center justify-center gap-2 text-[10px]"
                    >
                        <div class="w-20 shrink-0 grow-0 text-right">
                            শ্রেণী :
                        </div>
                        <div class="shrink grow text-left">
                            {{ data.student.currentClassName }}
                        </div>
                    </div>
                    <div
                        class="flex items-center justify-center gap-2 text-[10px]"
                    >
                        <div class="w-20 shrink-0 grow-0 text-right">
                            রোল :
                        </div>
                        <div class="shrink grow text-left">
                            {{ data.student.currentClassRoll }}
                        </div>
                    </div>
                    <div
                        class="flex items-center justify-center gap-2 text-[10px]"
                    >
                        <div class="w-20 shrink-0 grow-0 text-right">
                            রেজি. নং :
                        </div>
                        <div class="shrink grow text-left">
                            {{ data.student.registration }}
                        </div>
                    </div>
                </div>

                <div class="flex h-[35px] items-center justify-center">
                    <img
                        v-if="signature"
                        :src="signature"
                        class="h-full w-full object-contain" />
                    <!-- <img
                        src="/images/sign180X80.jpg"
                        class="h-full w-full object-contain" /> -->
                    
                </div>
                <div class="flex items-center justify-center">
                    <p class="text-[10px] font-bold text-brand-950">
                        অধ্যক্ষের স্বাক্ষর
                    </p>
                </div>
            </div>
        </div>
        <div class="w-[204px] space-y-2">
            <h3 class="text-center font-bold print:hidden">পিছনের অংশ</h3>
            <div class="relative h-[324px] border bg-white py-2.5">
                <div
                    class="flex items-center justify-center gap-1 text-[10px] font-bold"
                >
                    <div class="shrink-0 grow-0">মেয়াদ :</div>
                    <div class="shrink-0 grow-0">
                        {{ $page.props.settings.idCardTime }}
                    </div>
                </div>
                <p class="text-center text-[10px]">
                    তথ্য যাচাইয়ের জন্য স্ক্যান করুন
                </p>
                <div class="mt-1 flex items-center justify-center">
                    <Link
                        :href="
                            route('verifications.student-id-card', [
                                data.student.id,
                                data.student.currentAdmissionId,
                            ])
                        "
                        class="h-[91px] w-[91px]"
                    >
                        <QrcodeVue
                            :value="
                                route('verifications.student-id-card', [
                                    data.student.id,
                                    data.student.currentAdmissionId,
                                ])
                            "
                            class="border border-black p-1 rounded-lg"
                            :size="91"
                            level="L"
                        />
                    </Link>
                </div>
                <p class="mt-2 px-8 text-center text-[9px]">
                    পরিচয়পত্রটি কোথাও পাওয়া গেলে নিম্নোক্ত যেকোন ঠিকানায়
                    পৌঁছে দিন
                </p>
                <h3 class="mt-2 text-center text-[10px] font-bold">
                    শিক্ষার্থীর ঠিকানা
                </h3>
                <div class="px-8 text-center text-[9px]">
                    {{ data.student.presentAddress.value }},
                    {{ data.student.presentAddress.areaName }},
                    {{ data.student.presentAddress.districtName }}
                </div>
                <div
                    class=" flex items-center justify-center gap-1 text-[9px] font-bold"
                >
                    <div class="shrink-0 grow-0">অভিভাবকের ফোন :</div>
                    <div class="shrink-0 grow-0">
                        {{ data.student.guardianInfo.phone }}
                    </div>
                </div>
                <div class="absolute bottom-0 left-0 right-0 z-10 w-full">
                    <div
                        class="flex flex-col items-center justify-end space-y-1 bg-sky-700 py-2 text-white"
                    >
                        <h2 class="text-[12px] font-bold text-yellow-200">
                            {{ $page.props.settings.siteName }}
                        </h2>
                        <h2
                            class="px-6 text-center text-[8px] font-bold text-white"
                        >
                            {{ $page.props.settings.siteAddress }}
                        </h2>
                        <div
                            class="flex items-center justify-center gap-1 text-[9px] font-bold"
                        >
                            <div class="shrink-0 grow-0">
                                ফোন :
                            </div>
                            <div class="shrink-0 grow-0">
                                {{ $page.props.settings.sitePhone }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import AvatarView from "@/Components/AvatarView.vue";
import AppLayout from "@/Layouts/Master.vue";
import { Head, Link } from "@inertiajs/vue3";
import QrcodeVue from "qrcode.vue";
export default {
    components: {
        Head,
        Link,
        AppLayout,
        ApplicationLogo,
        AvatarView,
        QrcodeVue,
    },
    props: {
        data: {
            type: Object,
            default: {},
        },
        signature: {
            type: String,
            default: "",
        },
        qrCode: {
            type: String,
            default: "",
        },
    },
    created() {
        console.log("qr", this.qrCode);
    },
};
</script>
