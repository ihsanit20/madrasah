<template>
    <header class="sticky top-0 z-40 bg-white shadow-sm print:hidden">
        <app-header
            :navigation-controller="navigationController"
            :hasAccount="true"
        />
    </header>

    <div class="mx-auto flex max-w-6xl">
        <main
            class="w-full space-y-2 overflow-auto px-2 py-2 print:overflow-visible print:p-0 md:space-y-4 md:px-4 md:py-4"
        >
            <div
                v-if="pageTitle || addNewHref"
                class="flex items-center justify-center gap-1.5 text-center print:hidden"
            >
                <h2
                    v-if="pageTitle"
                    class="text-xl font-bold leading-5 text-gray-700"
                >
                    {{ pageTitle }}
                </h2>
                <Link
                    v-if="addNewHref"
                    :href="addNewHref"
                    class="bg-brand-600 flex flex-shrink-0 flex-grow-0 items-center justify-center gap-1 rounded px-2.5 py-0.5 text-white"
                >
                    <span>+</span>
                    <span class="hidden md:block">নতুন যোগ করুন</span>
                </Link>
            </div>

            <div class="flex w-full flex-col items-center gap-2 md:gap-4">
                <slot />
            </div>

            <hr class="print:hidden" />

            <div
                v-if="!route().current('dashboard')"
                class="flex w-full max-w-6xl justify-between print:hidden"
            >
                <Link
                    v-if="backHref"
                    class="text-xl font-bold leading-5 text-gray-700"
                    :href="backHref"
                >
                    ← Back
                </Link>
                <div
                    v-else
                    type="button"
                    class="inline-block cursor-pointer text-xl font-bold leading-5 text-gray-700"
                    onclick="history.back()"
                >
                    ← Back
                </div>
                <Link
                    class="text-xl font-bold leading-5 text-gray-700"
                    :href="route('dashboard')"
                >
                    <font-awesome-icon icon="fa-solid fa-house" />
                    Menu
                </Link>
            </div>
        </main>
    </div>
</template>

<script>
import { Link } from "@inertiajs/vue3";
import AppFooter from "./Footer/Index.vue";
import AppHeader from "./Header/Index.vue";
import AppNavigation from "./Navigation/Index.vue";

export default {
    components: {
        Link,
        AppFooter,
        AppHeader,
        AppNavigation,
    },
    props: {
        pageTitle: { type: String, default: "" },
        addNewHref: { type: String, default: "" },
        backHref: { type: String, default: "" },
    },
    data() {
        return {
            navigation: false,
        };
    },
    methods: {
        navigationController() {
            this.navigation = !this.navigation;
        },
    },
};
</script>
