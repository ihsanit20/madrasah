<template>
    <header class="sticky top-0 z-40 bg-white shadow-sm">
        <div
            class="mx-auto flex max-w-6xl items-center justify-between gap-2 py-2 px-2 md:py-3"
        >
            <Link
                :href="route($page.props.auth.user ? 'dashboard' : 'home')"
                class="flex h-full items-center gap-2 md:gap-4"
            >
                <application-logo class="h-20" />

                <h1
                    class="hidden text-xs font-bold text-blue-900 md:block md:text-4xl"
                >
                    মাদরাসা সায়্যিদাতুল জান্নাত (রা.)
                </h1>
            </Link>

            <dir class="flex gap-4">
                <Link
                    class="rounded-lg bg-orange-500 px-8 py-1.5 text-lg font-semibold text-white"
                >
                    ভর্তির আবেদন
                </Link>
                <Link
                    :href="route('login')"
                    class="rounded-lg bg-blue-900 px-8 py-1.5 text-lg font-semibold text-white"
                >
                    লগইন
                </Link>
            </dir>
        </div>
    </header>

    <main class="flex-shrink flex-grow space-y-4 overflow-auto px-2">
        <slot />
    </main>

    <footer>
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
};
</script>
