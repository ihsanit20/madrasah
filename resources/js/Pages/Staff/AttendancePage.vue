<template>
    <Head title="Attendance Page" />

    <app-layout>
        <div class="w-full max-w-xl rounded py-2 print:hidden">
            <print-button class="" />
        </div>
        <div class="mx-auto min-w-max bg-white px-2 print:scale-100 print:px-0">
            <div class="break-after-page pt-4 print:pt-0">
                <table class="mx-auto min-w-max">
                    <thead>
                        <tr>
                            <th colspan="35">
                                <div
                                    class="flex flex-col items-center justify-center"
                                >
                                    <h1
                                        class="text-3xl font-bold text-blue-900 print:text-3xl print:text-black"
                                    >
                                        {{ $page.props.settings.siteName }}
                                    </h1>
                                    <h2
                                        class="my-2 text-center text-xl font-bold leading-5 text-gray-700"
                                    >
                                        দৈনিক শিক্ষক/স্টাফ হাজিরা (পুরুষ)
                                    </h2>
                                </div>
                            </th>
                        </tr>
                        <tr>
                            <th
                                class="border border-black px-1 text-center text-xs text-black"
                                rowspan="2"
                            >
                                ক্রম
                            </th>
                            <th
                                class="border border-black px-1 text-center text-xs text-black"
                                rowspan="2"
                            >
                                শিক্ষক/স্টাফদের <br />
                                নাম ও পদবি
                            </th>
                            <th
                                class="border border-black px-1 text-left text-xs text-black"
                                colspan="15"
                            >
                                মাস:
                            </th>
                            <th
                                class="border border-black px-1 text-left text-xs text-black"
                                colspan="16"
                            >
                                শিক্ষাবর্ষ:
                            </th>
                            <th
                                class="border border-black px-1 text-center text-xs text-black"
                                colspan="2"
                            >
                                মোট
                            </th>
                        </tr>
                        <tr>
                            <th
                                class="w-5 border border-black text-center text-xs text-black print:w-6"
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
                            v-for="(staff, index) in data.male_staff"
                            :key="staff.id"
                        >
                            <td
                                class="border border-black px-1 text-center text-xs text-black"
                            >
                                {{ $e2bnumber(index + 1) }}
                            </td>
                            <td
                                class="h-10 min-w-max border border-black px-1 text-xs text-black"
                            >
                                <div
                                    class="flex flex-col items-start justify-center"
                                >
                                    <div class="font-bold">
                                        {{ staff.name }}
                                    </div>
                                    <div>
                                        {{ staff.designation }}
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
            <div class="break-after-page pt-4 print:pt-0">
                <table class="mx-auto min-w-max">
                    <thead>
                        <tr>
                            <th colspan="35">
                                <div
                                    class="flex flex-col items-center justify-center"
                                >
                                    <h1
                                        class="text-3xl font-bold text-blue-900 print:text-3xl print:text-black"
                                    >
                                        {{ $page.props.settings.siteName }}
                                    </h1>
                                    <h2
                                        class="my-2 text-center text-xl font-bold leading-5 text-gray-700"
                                    >
                                        দৈনিক শিক্ষক/স্টাফ হাজিরা (মহিলা)
                                    </h2>
                                </div>
                            </th>
                        </tr>
                        <tr>
                            <th
                                class="border border-black px-1 text-center text-xs text-black"
                                rowspan="2"
                            >
                                ক্রম
                            </th>
                            <th
                                class="border border-black px-1 text-center text-xs text-black"
                                rowspan="2"
                            >
                                শিক্ষক/স্টাফদের <br />
                                নাম ও পদবি
                            </th>
                            <th
                                class="border border-black px-1 text-left text-xs text-black"
                                colspan="15"
                            >
                                মাস:
                            </th>
                            <th
                                class="border border-black px-1 text-left text-xs text-black"
                                colspan="16"
                            >
                                শিক্ষাবর্ষ:
                            </th>
                            <th
                                class="border border-black px-1 text-center text-xs text-black"
                                colspan="2"
                            >
                                মোট
                            </th>
                        </tr>
                        <tr>
                            <th
                                class="w-5 border border-black text-center text-xs text-black print:w-6"
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
                            v-for="(staff, index) in data.female_staff"
                            :key="staff.id"
                        >
                            <td
                                class="border border-black px-1 text-center text-xs text-black"
                            >
                                {{ $e2bnumber(index + 1) }}
                            </td>
                            <td
                                class="h-10 min-w-max border border-black px-1 text-xs text-black"
                            >
                                <div
                                    class="flex flex-col items-start justify-center"
                                >
                                    <div class="font-bold">
                                        {{ staff.name }}
                                    </div>
                                    <div>
                                        {{ staff.designation }}
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
