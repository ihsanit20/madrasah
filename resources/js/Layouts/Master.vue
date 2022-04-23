<template>
    <header
        class="sticky top-0 z-40 overflow-hidden bg-white shadow-sm print:hidden"
    >
        <div
            class="mx-auto flex w-full max-w-6xl items-center justify-between gap-2 py-2 px-2 md:py-3"
        >
            <Link
                :href="route('home')"
                class="flex items-center gap-2 md:gap-4"
            >
                <application-logo class="h-12 md:h-16" />

                <h1
                    class="hidden text-xs font-bold text-blue-900 md:block md:text-4xl"
                >
                    {{ $page.props.settings.siteName }}
                </h1>
            </Link>

            <div class="flex gap-4">
                <Link
                    :href="route('page.admission-form')"
                    class="w-28 rounded-lg bg-orange-500 py-1.5 text-center text-sm font-semibold text-white md:w-40 md:text-lg"
                >
                    ভর্তির আবেদন
                </Link>
                <Link
                    :href="route('login')"
                    class="w-28 rounded-lg bg-blue-900 py-1.5 text-center text-sm font-semibold text-white md:w-40 md:text-lg"
                >
                    লগইন
                </Link>
            </div>
        </div>
    </header>

    <main class="flex-shrink flex-grow space-y-4 overflow-auto">
        <slot />
    </main>

    <footer v-if="hasFooter" class="print:hidden">
        <app-footer />
    </footer>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";
import AppFooter from "./Footer/Index.vue";
import AppHeader from "./Header/Index.vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";

export default {
    components: {
        Link,
        AppFooter,
        AppHeader,
        ApplicationLogo,
    },

    props: {
        hasFooter: {
            type: Boolean,
            default: true,
        },
    },
};
</script>
