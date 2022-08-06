<template>
    <div class="flex flex-wrap gap-8 md:flex-row">
        <div class="w-[236px] space-y-2">
            <h3 class="text-center font-bold print:hidden">সামনের অংশ</h3>
            <div class="h-[375px] border bg-white">
                <div
                    class="flex flex-col items-center justify-center gap-1 pt-3 pb-1.5"
                >
                    <application-logo class="h-10" />
                    <div
                        class="flex flex-col items-center justify-end space-y-1"
                    >
                        <h2
                            class="text-[14px] font-bold text-blue-900 print:text-black"
                        >
                            {{ $page.props.settings.siteName }}
                        </h2>
                    </div>
                </div>
                <div
                    class="flex h-[27px] items-center justify-center bg-blue-900 text-white"
                >
                    <h2 class="text-[10px]">শিক্ষার্থীর পরিচয়পত্র</h2>
                </div>
                <div class="mt-[65px] h-[135px] bg-green-600">
                    <div
                        class="mx-auto -mb-12 aspect-[40/48] w-[91px] -translate-y-1/2 overflow-hidden border-2 border-orange-500"
                    >
                        <img
                            :src="data.student.imageUrl || '/images/hijab-icon.jpg'"
                            class="h-full w-full object-cover"
                        />
                    </div>
                    <div
                        class="text-center text-[12px] font-semibold text-white"
                    >
                        <h1 class="pb-1 line-clamp-1">
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
                </div>
                <div class="flex h-[40px] items-center justify-center">
                    <img
                        v-if="signature"
                        :src="signature"
                        class="h-full w-full object-contain"
                    />
                </div>
                <div class="flex items-center justify-center">
                    <p class="text-[10px] font-bold text-blue-900">
                        অধ্যক্ষের স্বাক্ষর
                    </p>
                </div>
            </div>
        </div>
        <div class="w-[236px] space-y-2">
            <h3 class="text-center font-bold print:hidden">পিছনের অংশ</h3>
            <div class="relative h-[375px] border bg-white py-4">
                <div
                    class="flex items-center justify-center gap-1 text-[10px] font-bold"
                >
                    <div class="shrink-0 grow-0">মেয়াদ :</div>
                    <div class="shrink-0 grow-0">
                        {{ $page.props.settings.idCardTime }}
                    </div>
                </div>
                <p class="mt-2 text-center text-[9px]">
                    তথ্য যাচাইয়ের জন্য স্ক্যান করুন
                </p>
                <div class="mt-2 flex items-center justify-center">
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
                            class="border border-black p-1"
                            :size="91"
                            level="L"
                        />
                    </Link>
                </div>
                <p class="mt-2 px-8 text-center text-[8px]">
                    পরিচয়পত্রটি যদি কোথাও পাওয়া গেলে দয়া করে নিম্নোক্ত যেকোন
                    ঠিকানায় পৌঁছে দিন
                </p>
                <h3 class="mt-3 text-center text-[10px] font-bold">
                    শিক্ষার্থীর ঠিকানা
                </h3>
                <div class="mt-1 px-8 text-center text-[8px]">
                    {{ data.student.presentAddress.value }},
                    {{ data.student.presentAddress.postoffice }},
                    {{ data.student.presentAddress.areaName }},
                    {{ data.student.presentAddress.districtName }},
                    {{ data.student.presentAddress.divisionName }}
                </div>
                <div
                    class="mt-1 flex items-center justify-center gap-1 text-[8px]"
                >
                    <div class="shrink-0 grow-0">অভিভাবকের ফোন :</div>
                    <div class="shrink-0 grow-0">
                        {{ data.student.guardianInfo.phone }}
                    </div>
                </div>
                <div class="absolute bottom-0 left-0 right-0 z-10 w-full">
                    <div
                        class="flex flex-col items-center justify-end space-y-2 bg-blue-900 py-4 text-white"
                    >
                        <h2 class="text-[14px] font-bold">
                            {{ $page.props.settings.siteName }}
                        </h2>
                        <h2
                            class="px-6 text-center text-[8px] font-bold text-white"
                        >
                            {{ $page.props.settings.siteAddress }}
                        </h2>
                        <div
                            class="flex w-full items-center justify-center gap-1 text-[8px]"
                        >
                            <div class="w-20 shrink-0 grow-0 text-right">
                                ফোন :
                            </div>
                            <div class="shrink grow text-left">
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
import { Head, Link } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/Master.vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import AvatarView from "@/Components/AvatarView.vue";
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
