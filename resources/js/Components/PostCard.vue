<template>
    <div class="overflow-hidden w-full aspect-video">
        <img
            :src="post.imageUrl || '/images/article.jpg'"
            class="w-full bg-gray-200 h-full object-cover hover:scale-110 transition-all ease-in-out"
            @error="$defaultImage"
        />
    </div>
    <div class="flex flex-col gap-1 p-2 md:p-4">
        <div class="line-clamp-[8]">
            <h3 class="shrink grow text-sm md:text-lg text-gray-900 font-bold">
                {{ post.title }}
            </h3>
            <hr class="my-1 shrink-0 grow-0" />
            <div
                class="shrink-0 grow-0 text-gray-900 text-sm md:text-base text-justify"
            >
                <div
                    v-html="post.body"
                    class="md:leading-relaxed whitespace-pre-wrap"
                ></div>
            </div>
        </div>
        <div class="flex justify-center items-center py-2">
            <span
                class="text-xs md:text-sm px-4 py-1 text-brand-600 border border-brand-600 hover:bg-brand-600 hover:text-white rounded-xl"
            >
                সম্পূর্ন লেখা পড়ুন
            </span>
        </div>
    </div>
</template>

<script>
import AppLayout from "@/Layouts/App.vue";
import { Link } from "@inertiajs/vue3";

export default {
    components: {
        AppLayout,
        Link,
    },
    props: {
        post: {
            type: Object,
            default: {},
        },
    },
};
</script>
