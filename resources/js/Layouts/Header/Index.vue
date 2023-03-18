<template>
    <div
        class="mx-auto flex max-w-6xl items-center justify-between gap-2 py-2 px-2 md:py-3"
    >
        <!-- <MenuIcon @click="navigationController" class="h-6 w-6 md:hidden" /> -->

        <Link :href="route('home')" class="flex items-center gap-2 md:gap-4">
            <application-logo class="h-12 md:h-16" />

            <h1
                class="hidden text-xs font-bold text-blue-900 md:block md:text-4xl"
            >
                {{ $page.props.settings.siteName }}
            </h1>
        </Link>

        <!-- <search /> -->

        <div class="flex items-center justify-between gap-2">
            <session v-if="hasAccount" />
            <account v-if="hasAccount" />
        </div>
    </div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import Search from "./Search.vue";
import Account from "./Account.vue";
import Session from "./Session.vue";
import { MenuIcon } from "@heroicons/vue/outline";
export default {
    components: {
        Link,
        ApplicationLogo,
        Search,
        Account,
        Session,
        MenuIcon,
    },
    props: {
        navigationController: Function,
        hasAccount: {
            type: Boolean,
            default: false,
        },
        hasSession: {
            type: Boolean,
            default: false,
        },
    },
};
</script>
