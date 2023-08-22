<template>
    <Head title="Attendance Page" />

    <app-layout>
        <div class="w-full max-w-xl rounded py-2 print:hidden">
            <print-button class="" />
        </div>
        <div class="min-w-max mx-auto scale-x-90 print:scale-100 px-2 print:px-0 bg-white relative -z-20 overflow-hidden">
            <div class="absolute inset-0 w-full h-full -z-10 flex justify-center items-center">
                <img 
                    class="opacity-10"
                    :src="$page.props.settings.logoLink"
                />
            </div>

            <letter-head></letter-head>
            <h2
                class="text-center text-xl font-bold leading-5 text-gray-700 mt-2"
            >
                দৈনিক শিক্ষার্থী হাজিরা
            </h2>
            <div class="flex items-center justify-center gap-6 text-sm font-bold">
                <div>শ্রেণী : {{ data.class_info.name }}</div>
                <div>মাস : ... ... ... ... ... ... ...</div>
            </div>
            <table class="min-w-max mx-auto">
                <thead>
                    <tr>
                        <th
                            class="border border-black px-1 text-center text-xs text-black"
                        >
                            রোল
                        </th>
                        <th
                            class="border border-black px-1 text-left text-xs text-black"
                        >
                            নাম
                        </th>
                        <th
                            class="border border-black px-1 text-center text-xs text-black"
                        >
                            ধরণ
                        </th>
                        <th
                            class="w-5 border border-black text-center text-xs text-black"
                            v-for="n in 31"
                            :key="n"
                        >
                            {{ $e2bnumber(n) }}
                        </th>
                        <th
                            class="border border-black px-1 text-center text-xs text-black"
                        >
                            উপস্থিতি
                        </th>
                        <th
                            class="border border-black px-1 text-center text-xs text-black"
                        >
                            অনুপস্থিতি
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="(admission, index) in data.admissions"
                        :key="admission.id"
                    >
                        <td
                            class="border border-black px-1 text-center text-xs text-black"
                        >
                            {{ $e2bnumber(index + 1) }}
                        </td>
                        <td
                            class="min-w-max border border-black px-1 text-xs text-black"
                        >
                            {{ admission.student.name }}
                        </td>
                        <td
                            class="min-w-max border border-black px-1 text-center text-xs text-black"
                        >
                            {{ admission.student.resident_text }}
                        </td>
                        <td
                            class="border border-black text-center text-xs text-black"
                            v-for="n in 31"
                            :key="n"
                        ></td>
                        <td
                            class="min-w-max border border-black px-1 text-center text-xs text-black"
                        ></td>
                        <td
                            class="min-w-max border border-black px-1 text-center text-xs text-black"
                        ></td>
                    </tr>
                    <tr>
                        <td
                            class="border border-black px-1 text-center text-xs text-black"
                        ></td>
                        <td
                            class="h-12 border border-black px-1 text-center text-xs text-black"
                        >
                            শিক্ষকের সাক্ষর
                        </td>
                        <td
                            class="border border-black px-1 text-center text-xs text-black"
                        ></td>
                        <td
                            class="border border-black text-center text-xs text-black"
                            v-for="n in 31"
                            :key="n"
                        ></td>
                        <td
                            class="min-w-max border border-black px-1 text-center text-xs text-black"
                        ></td>
                        <td
                            class="min-w-max border border-black px-1 text-center text-xs text-black"
                        ></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </app-layout>
</template>

<script>
import { Head, Link } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/GridApp.vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import PrintButton from "@/Components/PrintButton.vue";
import LetterHead from "@/Templete/LetterHead.vue";

export default {
    components: {
        Head,
        Link,
        AppLayout,
        ApplicationLogo,
        PrintButton,
        LetterHead,
    },
    props: {
        data: {
            type: Object,
            default: {},
        },
    },
    data() {
        return {
            columns: [
                { title: "রোল", align: "center" },
                { title: "নাম", align: "left" },
            ],
        };
    },
};
</script>
