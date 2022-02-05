<template>
    <header class="sticky top-0 z-40 bg-white shadow-sm">
        <app-header :navigation-controller="navigationController" />
    </header>

    <div class="mx-auto flex max-w-6xl">
        <nav class="bg-white">
            <app-navigation :navigation="navigation" />
        </nav>

        <main class="flex-grow space-y-2 px-4 py-2">
            <h2 v-if="$slots.header" class="text-xl font-bold text-gray-800">
                <slot name="header" />
            </h2>

            <slot />
        </main>
    </div>

    <footer>
        <app-footer />
    </footer>
</template>

<script>
import AppFooter from "./Footer/Index.vue";
import AppHeader from "./Header/Index.vue";
import AppNavigation from "./Navigation/Index.vue";

export default {
    components: {
        AppFooter,
        AppHeader,
        AppNavigation,
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
