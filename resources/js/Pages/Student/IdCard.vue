<template>
    <Head title="Student" />

    <app-layout>
        <h2
            class="flex-shrink flex-grow text-xl font-bold leading-5 text-gray-700 print:hidden"
        >
            আইডি কার্ড
        </h2>
        <div class="w-full max-w-xl rounded px-6 py-6">
            <div class="flex flex-wrap gap-8 md:flex-row">
                <div class="w-[236px] space-y-2">
                    <h3 class="text-center font-bold">সামনের অংশ</h3>
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
                        <div class="mt-[70px] h-[139px] bg-green-500">
                            <div
                                class="mx-auto -mb-12 aspect-[40/48] w-[91px] -translate-y-1/2 overflow-hidden border-2 border-orange-500"
                            >
                                <img
                                    :src="data.student.imageUrl"
                                    class="h-full w-full object-cover"
                                />
                            </div>
                            <div
                                class="text-center text-[12px] font-semibold text-white"
                            >
                                <h1 class="pb-1">{{ data.student.name }}</h1>
                                <div
                                    class="flex items-center justify-center gap-2 text-[10px]"
                                >
                                    <div
                                        class="w-20 shrink-0 grow-0 text-right"
                                    >
                                        শ্রেণী :
                                    </div>
                                    <div class="shrink grow text-left">
                                        {{ data.student.currentClassName }}
                                    </div>
                                </div>
                                <div
                                    class="flex items-center justify-center gap-2 text-[10px]"
                                >
                                    <div
                                        class="w-20 shrink-0 grow-0 text-right"
                                    >
                                        রোল :
                                    </div>
                                    <div class="shrink grow text-left">
                                        {{ data.student.currentClassRoll }}
                                    </div>
                                </div>
                                <div
                                    class="flex items-center justify-center gap-2 text-[10px]"
                                >
                                    <div
                                        class="w-20 shrink-0 grow-0 text-right"
                                    >
                                        রেজি. নং :
                                    </div>
                                    <div class="shrink grow text-left">
                                        {{ data.student.registration }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex h-[32px] items-center justify-center">
                            <div></div>
                        </div>
                        <div class="flex items-center justify-center">
                            <p class="text-[10px] font-bold text-blue-900">
                                অধ্যক্ষের স্বাক্ষর
                            </p>
                        </div>
                    </div>
                </div>
                <div class="w-[236px] space-y-2">
                    <h3 class="text-center font-bold">পিছনের অংশ</h3>
                    <div class="relative h-[375px] border bg-white py-4">
                        <div
                            class="flex items-center justify-center gap-1 text-[10px] font-bold"
                        >
                            <div class="shrink-0 grow-0">মেয়াদ :</div>
                            <div class="shrink-0 grow-0">
                                ২৫ রমযান ১৪৪৪ হিজরি
                            </div>
                        </div>
                        <p class="mt-2 text-center text-[9px]">
                            তথ্য যাচাইয়ের জন্য স্ক্যান করুন
                        </p>
                        <div class="mt-1 flex items-center justify-center">
                            <div class="h-[91px] w-[91px]">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                    class="h-full w-full"
                                    viewBox="0 0 91 91"
                                >
                                    <image
                                        class="h-full w-full"
                                        xlink:href="data:image/png;base64,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"
                                    />
                                </svg>
                            </div>
                        </div>
                        <p class="mt-2 px-8 text-center text-[8px]">
                            পরিচয়পত্রটি যদি কোথাও পাওয়া গেলে দয়া করে নিম্নোক্ত
                            যেকোন ঠিকানায় পৌঁছে দিন
                        </p>
                        <h3 class="mt-2.5 text-center text-[10px] font-bold">
                            শিক্ষার্থীর ঠিকানা
                        </h3>
                        <div
                            class="mt-1 min-h-[36px] px-8 text-center text-[8px]"
                        >
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
                        <div
                            class="mt-3 flex items-center justify-center gap-1 text-[8px]"
                        >
                            <div
                                class="w-[73px] border-t border-dashed border-gray-700"
                            ></div>
                        </div>
                        <div
                            class="flex flex-col items-center justify-center gap-1 pt-2 pb-1.5"
                        >
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
                        <div class="absolute bottom-0 left-0 right-0 w-full">
                            <div
                                class="flex flex-col items-center justify-end space-y-2 bg-blue-900 py-3 text-white"
                            >
                                <h2
                                    class="px-6 text-center text-[8px] font-bold text-white"
                                >
                                    {{ $page.props.settings.siteAddress }}
                                </h2>
                                <div
                                    class="flex w-full items-center justify-center gap-1 text-[8px]"
                                >
                                    <div
                                        class="w-20 shrink-0 grow-0 text-right"
                                    >
                                        ফোন :
                                    </div>
                                    <div class="shrink grow text-left">
                                        01923204939, 01833056363
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import { Head } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/App.vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import AvatarView from "@/Components/AvatarView.vue";
export default {
    components: {
        Head,
        AppLayout,
        ApplicationLogo,
        AvatarView,
    },
    props: {
        data: {
            type: Object,
            default: {},
        },
    },
};
</script>
