<template>
    <Head title="Notice" />

    <app-layout>
        <div class="flex max-w-3xl items-center justify-end print:hidden">
            <div
                class="flex-shrink flex-grow text-xl font-bold leading-5 text-gray-700"
            >
                View Notice
            </div>
            <button
                @click="print"
                type="button"
                class="flex items-center justify-center gap-2 text-sky-600"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="20.346"
                    height="18.311"
                    viewBox="0 0 20.346 18.311"
                >
                    <path
                        d="M20.294,9.586H6.052A3.048,3.048,0,0,0,3,12.638v6.1H7.069v4.069H19.277V18.742h4.069v-6.1A3.048,3.048,0,0,0,20.294,9.586Zm-3.052,11.19H9.1V15.69h8.138Zm3.052-7.121a1.017,1.017,0,1,1,1.017-1.017A1.02,1.02,0,0,1,20.294,13.656ZM19.277,4.5H7.069V8.569H19.277Z"
                        transform="translate(-3 -4.5)"
                        fill="currentColor"
                    />
                </svg>
                <span class="font-bold">Print Notice</span>
            </button>
        </div>
        <div class="max-w-3xl bg-white p-10">
            <div class="mx-auto flex items-center justify-center gap-4">
                <application-logo class="w-16" />
                <div class="flex flex-col items-center justify-end space-y-1">
                    <h1
                        class="text-4xl font-bold text-blue-900 print:text-black"
                    >
                        মাদরাসা সায়্যিদাতুল জান্নাত (রা.)
                    </h1>
                    <p class="text-sm print:text-black">
                        বাড়ি নং: ৪১/২৫, ব্লক: বি, চাঁনমিয়া হাউজিং, মোহাম্মাদপুর,
                        ঢাকা-১২০৭
                    </p>
                </div>
            </div>
            <div class="mt-6 border border-gray-400 print:border-black"></div>
            <div class="py-3 print:text-black">
                তারিখ: <b>{{ data.notice.formatedDate }}</b>
            </div>
            <h2
                class="mt-4 mb-2 text-center text-2xl font-bold print:text-black"
            >
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
                        মাদরাসা সায়্যিদাতুল জান্নাত (রা.)
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/App.vue";
import { Head } from "@inertiajs/inertia-vue3";
import ActionButtonEdit from "@/Components/ActionButtonEdit.vue";
import FormHeading from "@/Components/FormHeading.vue";
import InlineData from "@/Components/InlineData.vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import Button from "@/Components/Button.vue";

export default {
    components: {
        AppLayout,
        Head,
        ActionButtonEdit,
        FormHeading,
        InlineData,
        ApplicationLogo,
        Button,
    },
    props: {
        data: {
            type: Object,
            default: {},
        },
    },
    methods: {
        print() {
            window.print();
        },
    },
};
</script>
