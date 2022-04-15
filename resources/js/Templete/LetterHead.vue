<template>
    <div>
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
    </div>
</template>

<script>
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
export default {
    components: {
        ApplicationLogo,
    },
};
</script>
