<template>
    <Head title="Student" />

    <app-layout>
        <h2
            class="flex-shrink flex-grow text-xl font-bold leading-5 text-gray-700"
        >
            আইডি কার্ড
        </h2>
        <div class="w-full max-w-3xl rounded bg-white px-8 py-6">
            <div class="flex flex-wrap gap-8">
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
                    <div class="h-[375px] border bg-white"></div>
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
