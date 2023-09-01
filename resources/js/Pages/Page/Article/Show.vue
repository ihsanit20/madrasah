<template>
    <Head>
        <title>{{ post.title }}</title>
        <meta name="title" :content="post.title" />
        <meta name="description" :content="post.description" />

        <!-- Facebook -->
        <meta property="og:url" :content="route('article.show', post.id)" />
        <meta property="og:type" content="article" />
        <meta property="og:title" :content="post.title" />
        <meta property="og:description" :content="post.description" />
        <meta
            property="og:image"
            :content="
                'https://messagebd.net' +
                (post.imageUrl || '/images/article.jpg')
            "
        />
    </Head>
    <app-layout>
        <div class="max-w-6xl md:mx-auto border bg-white mt-6 rounded-xl">
            <h1 class="text-brand-600 mt-4 md:mt-8 text-3xl md:text-4xl font-bold text-center px-2">
                {{ post.title }}
            </h1>
            <div class="w-full sm:max-w-xl float-right p-4 pb-2 sm:p-8 sm:pb-2">
                <div
                    class="bg-gray-300 flex-initial flex-col justify-center items-center rounded-xl overflow-hidden"
                >
                    <img
                        :src="post.imageUrl || '/images/article.jpg'"
                        class="w-full aspect-video border border-gray-300"
                        @error="$defaultImage"
                    />
                </div>
            </div>
            <div
                v-html="post.body"
                class="ProseMirror text-base md:text-xl p-4 md:p-8 whitespace-pre-wrap text-justify !leading-relaxed __description"
            ></div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/App.vue";
import AvatarPhotoView from "@/Components/AvatarPhotoView.vue";
import SectionCard from "@/Components/SectionCard.vue";
import { Head, Link } from "@inertiajs/vue3";

export default {
    components: {
        AppLayout,
        AvatarPhotoView,
        SectionCard,
        Head,
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

<style>

    .__description h3 {
        margin-bottom: 18px;
        font-weight: 800;
    }

    .__description p {
        margin-bottom: 16px;
    }
</style>
