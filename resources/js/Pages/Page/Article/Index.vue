<template>
    <app-layout>
        <div class="grid">
            <section-card title="আর্টিকেল">
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-2 md:gap-4 px-2 md:px-0">
                    <Link
                        v-for="(post, index) in posts.data"
                        :key="index"
                        :href="route('article.show', post.id)"
                        class="border bg-white flex flex-col rounded-xl overflow-hidden"
                    >
                        <PostCard :post="post" />
                    </Link>
                </div>
            </section-card>
            <div
                v-if="posts.links.prev || posts.links.next"
                class="mt-6 w-full flex justify-center gap-4 items-center"
            >
                <Link
                    v-if="posts.links.prev"
                    :href="posts.links.prev"
                    class="w-24 flex justify-center items-center py-2 border text-brand-600 border-brand-600 rounded hover:bg-brand-600 hover:text-white"
                >
                    Previous
                </Link>
                <div
                    v-else
                    class="w-24 flex justify-center items-center py-2 rounded bg-gray-300 text-white cursor-not-allowed"
                >
                    Previous
                </div>
                <Link
                    v-if="posts.links.next"
                    :href="posts.links.next"
                    class="w-24 flex justify-center items-center py-2 border text-brand-600 border-brand-600 rounded hover:bg-brand-600 hover:text-white"
                >
                    Next
                </Link>
                <div
                    v-else
                    class="w-24 flex justify-center items-center py-2 rounded bg-gray-300 text-white cursor-not-allowed"
                >
                    Next
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import PostCard from "@/Components/PostCard.vue";
import SectionCard from "@/Components/SectionCard.vue";
import AppLayout from "@/Layouts/App.vue";
import { Head, Link } from "@inertiajs/vue3";

export default {
    components: {
        AppLayout,
        SectionCard,
        Head,
        Link,
        PostCard,
    },
    props: {
        posts: {
            type: Object,
            default: {},
        },
    },
};
</script>
