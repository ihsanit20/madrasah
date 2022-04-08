<template>
    <div
        class="flex min-h-screen flex-col items-center bg-gray-100 sm:justify-center"
    >
        <div
            class="mt-6 w-full overflow-hidden bg-white px-6 py-4 shadow-md sm:max-w-md sm:rounded-lg"
        >
            <Link href="/">
                <BreezeApplicationLogo
                    class="mx-auto h-20 w-20 fill-current text-gray-500"
                />
            </Link>

            <div
                class="mt-4 text-center text-2xl font-bold text-blue-900 md:text-3xl"
            >
                মাদরাসা সায়্যিদাতুল জান্নাত (রা.)
            </div>
            <hr class="my-5" />
            <slot />
        </div>
    </div>
</template>

<script>
import BreezeApplicationLogo from "@/Components/ApplicationLogo.vue";
import { Link } from "@inertiajs/inertia-vue3";

export default {
    components: {
        BreezeApplicationLogo,
        Link,
    },
};
</script>
