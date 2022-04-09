<template>
    <header class="sticky top-0 z-40 overflow-hidden bg-white shadow-sm">
        <div
            class="mx-auto flex w-full max-w-6xl items-center justify-between gap-2 py-2 px-2 md:py-3"
        >
            <Link
                :href="route($page.props.auth.user ? 'dashboard' : 'home')"
                class="flex items-center gap-2 md:gap-4"
            >
                <application-logo class="h-12 md:h-20" />

                <h1
                    class="hidden text-xs font-bold text-blue-900 md:block md:text-4xl"
                >
                    মাদরাসা সায়্যিদাতুল জান্নাত (রা.)
                </h1>
            </Link>

            <div class="flex gap-4">
                <Link
                    href="#"
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
