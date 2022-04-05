<template>
    <div
        class="mx-auto flex max-w-6xl items-center justify-between gap-2 py-2 px-2 md:py-3"
    >
        <MenuIcon @click="navigationController" class="h-6 w-6 md:hidden" />

        <Link
            :href="route($page.props.auth.user ? 'dashboard' : 'home')"
            class="flex h-full items-center gap-2 md:gap-4"
        >
            <application-logo class="h-full" />

            <h1
                class="hidden text-xs font-semibold text-gray-600 md:block md:text-2xl"
            >
                Madrasah Management
            </h1>
        </Link>

        <search />

        <account />
    </div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import Search from "./Search.vue";
import Account from "./Account.vue";
import { MenuIcon } from "@heroicons/vue/outline";
export default {
    components: {
        Link,
        ApplicationLogo,
        Search,
        Account,
        MenuIcon,
    },
    props: {
        navigationController: Function,
    },
};
</script>
