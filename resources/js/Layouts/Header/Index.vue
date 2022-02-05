<template>
    <div
        class="mx-auto flex max-w-6xl items-center justify-between gap-2 py-2 px-2"
    >
        <MenuIcon @click="navigationController" class="h-6 w-6 md:hidden" />

        <Link
            :href="route($page.props.auth.user ? 'dashboard' : 'home')"
            class="flex items-center gap-2"
        >
            <application-logo class="h-7 md:h-10" />

            <h1
                class="hidden text-xs font-bold text-gray-700 md:block md:text-lg"
            >
                Madrasha Name Here
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
