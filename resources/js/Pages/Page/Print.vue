<template>
    <Head title="Notice" />

    <app-layout :hasFooter="false">
        <div
            class="mx-auto mt-4 flex max-w-3xl items-center justify-end print:hidden"
        >
            <Link
                :href="route('home')"
                class="flex-shrink flex-grow text-xl font-bold leading-5 text-gray-700"
            >
                &#8592; Back to Home
            </Link>
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
        <NoticeTemplete :data="data" class="mx-auto max-w-3xl" />
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/Master.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import ActionButtonEdit from "@/Components/ActionButtonEdit.vue";
import FormHeading from "@/Components/FormHeading.vue";
import InlineData from "@/Components/InlineData.vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import Button from "@/Components/Button.vue";
import NoticeTemplete from "@/Templete/Notice.vue";

export default {
    components: {
        AppLayout,
        Head,
        Link,
        ActionButtonEdit,
        FormHeading,
        InlineData,
        ApplicationLogo,
        Button,
        NoticeTemplete,
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
