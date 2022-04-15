<template>
    <div class="bg-white p-10">
        <div class="mx-auto flex items-center justify-center gap-4">
            <application-logo class="w-16" />
            <div class="flex flex-col items-center justify-end space-y-1">
                <h1 class="text-4xl font-bold text-blue-900 print:text-black">
                    {{ $page.props.settings.siteName }}
                </h1>
                <p class="text-sm print:text-black">
                    {{ $page.props.settings.siteAddress }}
                </p>
            </div>
        </div>
        <div class="mt-6 border border-gray-400 print:border-black"></div>
        <div class="py-3 print:text-black">
            তারিখ: <b>{{ data.notice.formatedDate }}</b>
        </div>
        <h2 class="mt-4 mb-2 text-center text-2xl font-bold print:text-black">
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
                    {{ $page.props.settings.siteName }}
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
export default {
    components: {
        ApplicationLogo,
    },
    props: {
        data: {
            type: Object,
            default: {},
        },
    },
};
</script>
