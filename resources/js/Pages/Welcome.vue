<template>
    <Head title="Welcome" />

    <div
        class="items-top relative flex min-h-screen justify-center bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0"
    >
        <div
            v-if="canLogin"
            class="fixed top-0 right-0 hidden px-6 py-4 sm:block"
        >
            <Link
                v-if="$page.props.auth.user"
                :href="route('dashboard')"
                class="text-sm text-gray-700 underline"
            >
                Dashboard
            </Link>

            <template v-else>
                <Link
                    :href="route('login')"
                    class="text-sm text-gray-700 underline"
                >
                    Log in
                </Link>

                <Link
                    v-if="canRegister"
                    :href="route('register')"
                    class="ml-4 text-sm text-gray-700 underline"
                >
                    Register
                </Link>
            </template>
        </div>

        <div class="mx-auto max-w-6xl sm:px-6 lg:px-8">
            <div
                class="flex gap-4 rounded-md bg-gradient-to-r from-white to-green-500 p-4 text-lg shadow-md md:text-3xl"
            >
                <span class="text-green-600">M</span>
                <span class="text-red-700">A</span>
                <span class="text-sky-600">D</span>
                <span class="text-gray-700">R</span>
                <span class="text-gray-400">A</span>
                <span class="text-gray-300">S</span>
                <span class="text-gray-50">A</span>
                <span class="text-white">H</span>
            </div>
        </div>
    </div>
</template>

<script>
import { Head, Link } from "@inertiajs/inertia-vue3";

export default {
    components: {
        Head,
        Link,
    },
    props: {
        canLogin: Boolean,
        canRegister: Boolean,
        laravelVersion: String,
        phpVersion: String,
    },
};
</script>
