<template>
    <div class="relative">
        <div class="mx-auto flex items-center justify-center gap-4">
            <application-logo class="w-16" />
            <div class="flex flex-col items-center justify-end space-y-1">
                <h1
                    class="text-3xl font-bold text-blue-900 print:text-2xl print:text-black"
                >
                    {{ $page.props.settings.siteName }}
                </h1>
                <p class="text-sm print:text-[11px] print:text-black">
                    {{ $page.props.settings.siteAddress }}
                </p>
            </div>
        </div>
        <div class="mt-6 border border-gray-400 print:border-black"></div>
        <div v-if="photoFrame" class="absolute left-0 top-0 bg-white pr-0.5">
            <div
                class="flex h-24 w-20 items-center justify-center border print:border-black"
            >
                <label class="text-sm text-gray-500 print:text-black">
                    ছবি
                </label>
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
        photoFrame: {
            type: Boolean,
            default: false,
        },
    },
};
</script>
