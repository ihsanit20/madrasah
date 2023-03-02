<template>
    <Head title="Attendance Page" />

    <app-layout>
        <div class="w-full max-w-xl rounded py-2 print:hidden">
            <print-button class="" />
        </div>
        <div
            class="mx-auto min-w-max scale-x-90 bg-white bg-[url('/images/wmlogo.png')] bg-center bg-no-repeat px-2 print:scale-100 print:px-0"
        >
            <letter-head></letter-head>
            <h2
                class="mt-2 text-center text-xl font-bold leading-5 text-gray-700"
            >
                দৈনিক শিক্ষক/স্টাফ হাজিরা
            </h2>
            <div
                class="flex items-center justify-center gap-6 text-sm font-bold"
            >
                <div>মাস : ... ... ... ... ... ... ...</div>
                <div>শিক্ষাবর্ষ : ... ... ... ... ... ... ...</div>
            </div>
            <table class="mx-auto min-w-max">
                <thead>
                    <tr>
                        <th
                            class="border border-black px-1 text-center text-xs text-black"
                        >
                            ক্রম
                        </th>
                        <th
                            class="border border-black px-1 text-left text-xs text-black"
                        >
                            শিক্ষক/স্টাফের নাম ও পদবি
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
                    <tr v-for="(staff, index) in data.staff" :key="staff.id">
                        <td
                            class="border border-black px-1 text-center text-xs text-black"
                        >
                            {{ $e2bnumber(index + 1) }}
                        </td>
                        <td
                            class="h-12 min-w-max border border-black px-1 text-xs text-black"
                        >
                            <div
                                class="flex flex-col items-start justify-center"
                            >
                                <div>
                                    {{ staff.name }}
                                </div>
                                <div>
                                    {{ staff.designationTitle }}
                                </div>
                            </div>
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
import AppLayout from "@/Layouts/App.vue";
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
