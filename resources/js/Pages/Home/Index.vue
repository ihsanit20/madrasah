<template>
    <Head title="Dashboard" />

    <app-layout>
        <div
            class="overflow-hidden bg-rose-600 py-2 text-white"
            behavior="scroll"
            scrollamount="5"
        >
            <div class="mx-auto w-full max-w-6xl overflow-hidden">
                <div
                    class="mx-auto w-full max-w-5xl animate-marquee-20 space-x-8 overflow-hidden whitespace-nowrap md:animate-marquee-40"
                >
                    <span>{{ data.headline.value }}</span>
                </div>
            </div>
        </div>
        <section class="mx-auto grid max-w-6xl gap-4 md:grid-cols-4">
            <div class="grid gap-4 md:col-span-3">
                <div
                    class="relative h-80 w-full overflow-hidden rounded-lg bg-red-600 md:h-96"
                >
                    <img
                        src="/images/mainbanner.jpg"
                        class="h-full w-full object-cover"
                    />
                    <div
                        class="absolute inset-0 z-10 flex flex-col items-start justify-center bg-gradient-to-r from-blue-900 to-blue-900/0 px-4 text-white md:px-12"
                    >
                        <p class="text-base md:text-lg md:font-semibold">
                            আসসালামু আলাইকুম ওয়া রামাতুল্লাহ
                        </p>
                        <p class="text-base md:text-lg md:font-semibold">
                            মাদরাসা সায়্যিদাতুল জান্নাত (রা.)-এর ওয়েব সাইটে
                        </p>
                        <h3 class="mt-2 text-3xl font-bold md:text-5xl">
                            আপনাকে স্বাগতম
                        </h3>
                        <p
                            class="py-2 text-base md:py-4 md:text-lg md:font-semibold"
                        >
                            ১৪৪৩-৪৪ হি. শিক্ষাবর্ষে ভর্তি চলতে । অনলাইনে আবেদন
                            করুন
                        </p>
                        <Link
                            class="rounded-lg bg-orange-500 px-8 py-1.5 text-lg font-semibold text-white"
                        >
                            ভর্তির আবেদন
                        </Link>
                    </div>
                </div>

                <div
                    class="h-80 overflow-y-auto rounded-lg border border-gray-400 bg-white p-4 text-center"
                >
                    <h3 class="text-2xl font-bold text-blue-900">
                        {{ data.principalMessage.name }}
                    </h3>
                    <p class="text-justify text-lg">
                        {{ data.principalMessage.value }}
                    </p>
                </div>
            </div>
            <div class="grid gap-4">
                <div
                    class="h-80 overflow-y-auto rounded-lg border border-gray-400 bg-white text-center md:h-96"
                >
                    <h3
                        class="sticky top-0 z-10 bg-white pt-4 text-2xl font-bold text-blue-900"
                    >
                        নোটিশ বোর্ড
                    </h3>
                    <ul class="divide-y-2 px-4 text-justify text-lg">
                        <li
                            v-for="notice in data.notices"
                            :key="notice.id"
                            class="py-3"
                        >
                            <Link
                                :href="route('page.notice', notice.id)"
                                class="block"
                            >
                                <p class="text-xl font-bold text-orange-500">
                                    {{ notice.formatedDate }}
                                </p>
                                <h3 class="line-clamp-2">
                                    {{ notice.title }}
                                </h3>
                            </Link>
                        </li>
                        <li
                            class="py-3"
                            v-if="Object.keys(data.notices).length < 4"
                        >
                            <Link href="#" class="block">
                                <p class="text-xl font-bold text-orange-500">
                                    22 Apr 2020
                                </p>
                                <h3 class="line-clamp-2">
                                    বাংলাদেশ, প্রায় শতকরা ৯০ ভাগ মুসলমানের একটি
                                    জনপদের নাম। এ দেশ তথ্য গোটা ভারত উপমহাদেশের
                                    আছে একটি গৌরবোজ্জ্বল অতীত।
                                </h3>
                            </Link>
                        </li>
                        <li
                            class="py-3"
                            v-if="Object.keys(data.notices).length < 3"
                        >
                            <Link href="#" class="block">
                                <p class="text-xl font-bold text-orange-500">
                                    22 Apr 2020
                                </p>
                                <h3 class="line-clamp-2">
                                    বাংলাদেশ, প্রায় শতকরা ৯০ ভাগ মুসলমানের একটি
                                    জনপদের নাম। এ দেশ তথ্য গোটা ভারত উপমহাদেশের
                                    আছে একটি গৌরবোজ্জ্বল অতীত।
                                </h3>
                            </Link>
                        </li>
                        <li
                            class="py-3"
                            v-if="Object.keys(data.notices).length < 2"
                        >
                            <Link href="#" class="block">
                                <p class="text-xl font-bold text-orange-500">
                                    21 Apr 2020
                                </p>
                                <h3 class="line-clamp-2">
                                    বাংলাদেশ, প্রায় শতকরা ৯০ ভাগ মুসলমানের একটি
                                    জনপদের নাম। এ দেশ তথ্য গোটা ভারত উপমহাদেশের
                                    আছে একটি গৌরবোজ্জ্বল অতীত।
                                </h3>
                            </Link>
                        </li>
                        <li
                            class="py-3"
                            v-if="Object.keys(data.notices).length < 1"
                        >
                            <Link href="#" class="block">
                                <p class="text-xl font-bold text-orange-500">
                                    20 Apr 2020
                                </p>
                                <h3 class="line-clamp-1">
                                    বাংলাদেশ, প্রায় শতকরা ৯০ ভাগ মুসলমানের একটি
                                    জনপদের নাম। এ দেশ তথ্য গোটা ভারত উপমহাদেশের
                                    আছে একটি গৌরবোজ্জ্বল অতীত।
                                </h3>
                            </Link>
                        </li>
                    </ul>
                </div>
                <div class="">
                    <arabic-calender
                        class="w-full rounded-lg border border-gray-400"
                    />
                </div>
            </div>
        </section>

        <section class="mx-auto max-w-6xl pt-4 pb-4 md:pt-8 md:pb-8">
            <h2 class="my-6 text-center text-4xl font-bold text-blue-900">
                আমাদের বিভাগসমূহ
            </h2>
            <div class="grid gap-4 md:grid-cols-3">
                <div
                    v-for="classes in data.classes"
                    :key="classes.id"
                    class="overflow-hidden rounded-lg border bg-white pb-4"
                >
                    <h3
                        class="bg-orange-500 py-2 text-center text-2xl font-semibold text-white"
                    >
                        {{ classes.name }}
                    </h3>
                    <p
                        class="overflow-hidden px-4 pt-4 text-justify text-lg line-clamp-6"
                    >
                        {{ classes.description }}
                    </p>
                </div>
                <div
                    v-if="Object.keys(data.classes).length < 3"
                    class="overflow-hidden rounded-lg border bg-white pb-4"
                >
                    <h3
                        class="bg-orange-500 py-2 text-center text-2xl font-semibold text-white"
                    >
                        বিভাগের নাম
                    </h3>
                    <p
                        class="overflow-hidden px-4 pt-4 text-justify text-lg line-clamp-6"
                    >
                        বাংলাদেশ, প্রায় শতকরা ৯০ ভাগ মুসলমানের একটি জনপদের নাম।
                        এ দেশ তথ্য গোটা ভারত উপমহাদেশের আছে একটি গৌরবোজ্জ্বল
                        অতীত। এখানে নেতৃত্ব দিয়েছেন অনেক সৎ, যোগ্য এবং সুমহান
                        ব্যক্তিবর্গ। কিন্তু কালের পরিবর্তনে আজ আমাদের সোনার দেশ
                    </p>
                </div>
                <div
                    v-if="Object.keys(data.classes).length < 2"
                    class="overflow-hidden rounded-lg border bg-white pb-4"
                >
                    <h3
                        class="bg-orange-500 py-2 text-center text-2xl font-semibold text-white"
                    >
                        বিভাগের নাম
                    </h3>
                    <p
                        class="overflow-hidden px-4 pt-4 text-justify text-lg line-clamp-6"
                    >
                        বাংলাদেশ, প্রায় শতকরা ৯০ ভাগ মুসলমানের একটি জনপদের নাম।
                        এ দেশ তথ্য গোটা ভারত উপমহাদেশের আছে একটি গৌরবোজ্জ্বল
                        অতীত। এখানে নেতৃত্ব দিয়েছেন অনেক সৎ, যোগ্য এবং সুমহান
                        ব্যক্তিবর্গ। কিন্তু কালের পরিবর্তনে আজ আমাদের সোনার দেশ
                    </p>
                </div>
                <div
                    v-if="Object.keys(data.classes).length < 1"
                    class="overflow-hidden rounded-lg border bg-white pb-4"
                >
                    <h3
                        class="bg-orange-500 py-2 text-center text-2xl font-semibold text-white"
                    >
                        বিভাগের নাম
                    </h3>
                    <p
                        class="overflow-hidden px-4 pt-4 text-justify text-lg line-clamp-6"
                    >
                        বাংলাদেশ, প্রায় শতকরা ৯০ ভাগ মুসলমানের একটি জনপদের নাম।
                        এ দেশ তথ্য গোটা ভারত উপমহাদেশের আছে একটি গৌরবোজ্জ্বল
                        অতীত। এখানে নেতৃত্ব দিয়েছেন অনেক সৎ, যোগ্য এবং সুমহান
                        ব্যক্তিবর্গ। কিন্তু কালের পরিবর্তনে আজ আমাদের সোনার দেশ
                    </p>
                </div>
            </div>
        </section>

        <section class="mx-auto max-w-6xl pt-4 pb-4 md:pt-8 md:pb-8">
            <div class="rounded-lg border border-gray-400 bg-white">
                <h2 class="mt-8 text-center text-4xl font-bold text-blue-900">
                    {{ data.ourMessage.name }}
                </h2>
                <div class="px-8 py-4 text-justify text-lg">
                    {{ data.ourMessage.value }}
                </div>
            </div>
        </section>

        <section class="bg-blue-900 pt-4 pb-4 text-white md:pt-8 md:pb-8">
            <div
                class="mx-auto flex max-w-6xl flex-col items-center justify-between gap-4 px-8 py-4 text-justify text-lg md:flex-row"
            >
                <div
                    class="order-2 flex-1 shrink grow space-y-2 text-center md:order-1 md:text-left"
                >
                    <h3 class="text-xl font-bold md:text-3xl">
                        মাদরাসা সায়্যিদাতুল জান্নাত (রা.)
                    </h3>
                    <address class="text-sm font-semibold md:text-base">
                        বাড়ি নং: ৪১/২৫, ব্লক: বি, চাঁনমিয়া হাউজিং, <br />
                        মোহাম্মাদপুর, ঢাকা-১২০৭
                    </address>
                </div>

                <application-logo
                    class="order-1 w-28 shrink-0 grow-0 rounded-full bg-white p-0.5 md:order-2"
                />

                <div
                    class="order-3 flex flex-1 shrink grow grid-cols-2 flex-col items-center justify-end gap-4 md:flex-row"
                >
                    <div class="shrink-0 grow-0">
                        <div class="flex items-center justify-center gap-2">
                            <PhoneIcon
                                class="w-5 rounded bg-white p-0.5 text-blue-900 md:w-6"
                            />
                            <p class="text-xl font-bold md:text-2xl">
                                01923204939
                            </p>
                        </div>
                        <div class="flex items-center justify-center gap-2">
                            <PhoneIcon
                                class="w-5 rounded bg-white p-0.5 text-blue-900 md:w-6"
                            />
                            <p class="text-xl font-bold md:text-2xl">
                                01833056363
                            </p>
                        </div>
                    </div>
                    <div class="max-w-max shrink grow">
                        <div
                            class="flex items-center justify-center gap-2 md:justify-start"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-6 fill-white md:w-8"
                                viewBox="0 0 35.662 25.473"
                            >
                                <path
                                    d="M28.044,19.347a1.145,1.145,0,0,0-.6-1.075L17.257,11.9a1.2,1.2,0,0,0-1.294-.04,1.186,1.186,0,0,0-.657,1.114V25.715a1.186,1.186,0,0,0,.657,1.114,1.376,1.376,0,0,0,.617.159,1.134,1.134,0,0,0,.677-.2l10.189-6.368a1.145,1.145,0,0,0,.6-1.075Zm10.189,0q0,1.91-.02,2.985t-.169,2.716a22.014,22.014,0,0,1-.448,2.935,4.656,4.656,0,0,1-1.373,2.448,4.2,4.2,0,0,1-2.468,1.154,130.47,130.47,0,0,1-13.353.5,130.47,130.47,0,0,1-13.353-.5,4.242,4.242,0,0,1-2.478-1.154,4.626,4.626,0,0,1-1.383-2.448,24.634,24.634,0,0,1-.428-2.935q-.149-1.642-.169-2.716t-.02-2.985q0-1.91.02-2.985t.169-2.716a22.013,22.013,0,0,1,.448-2.935A4.655,4.655,0,0,1,4.581,8.262,4.2,4.2,0,0,1,7.048,7.108,130.47,130.47,0,0,1,20.4,6.61a130.468,130.468,0,0,1,13.353.5,4.242,4.242,0,0,1,2.478,1.154,4.627,4.627,0,0,1,1.383,2.448,24.634,24.634,0,0,1,.428,2.935q.149,1.642.169,2.716T38.233,19.347Z"
                                    transform="translate(-2.571 -6.61)"
                                />
                            </svg>

                            <p class="text-xl font-bold md:text-2xl">
                                MSZannat
                            </p>
                        </div>
                        <div class="flex items-center justify-start gap-2">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-6 fill-white md:w-8"
                                viewBox="0 0 34.875 34.664"
                            >
                                <path
                                    d="M35.438,18A17.438,17.438,0,1,0,15.275,35.227V23.041h-4.43V18h4.43V14.158c0-4.37,2.6-6.784,6.586-6.784a26.836,26.836,0,0,1,3.9.34V12h-2.2a2.52,2.52,0,0,0-2.841,2.723V18h4.836l-.773,5.041H20.725V35.227A17.444,17.444,0,0,0,35.438,18Z"
                                    transform="translate(-0.563 -0.563)"
                                />
                            </svg>

                            <p class="text-xl font-bold md:text-2xl">
                                fb.com/MSZannat
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/Master.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import MainBanner from "@/Components/MainBanner.vue";
import ArabicCalender from "@/Components/ArabicCalender.vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import { PhoneIcon } from "@heroicons/vue/solid";

export default {
    components: {
        AppLayout,
        Head,
        Link,
        MainBanner,
        ArabicCalender,
        ApplicationLogo,
        PhoneIcon,
    },
    props: {
        data: {
            type: Object,
            default: {},
        },
    },
};
</script>
