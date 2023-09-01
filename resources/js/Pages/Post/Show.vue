<template>
    <Head title="Post" />

    <app-layout>
        <template #header>
            {{ data.post.title }}
        </template>

        <div class="py-4">
            <add-new-button :href="route('posts.create')" class="mb-2" />

            <div class="overflow-auto bg-white border">
                <table class="table-auto">
                    <show-table-row heading="Action">
                        <div
                            class="flex justify-start items-center gap-1 md:gap-2"
                        >
                            <action-button-edit
                                :href="route('posts.edit', data.post.id)"
                            />
                            <a
                                target="_blank"
                                :href="route('article.show', data.post.id)"
                                class="flex gap-1 justify-center items-center text-white px-2 h-8 bg-green-500"
                            >
                                <ExternalLinkIcon class="w-5 h-5" />
                            </a>
                        </div>
                        
                    </show-table-row>

                    <show-table-row heading="Photo">
                        <image-previe-with-save
                            :imageUrl="data.post.imageUrl"
                            option="post"
                            :id="data.post.id"
                        />
                    </show-table-row>

                    <show-table-row heading="ID">{{ data.post.id }}</show-table-row>

                    <show-table-row heading="Admin">
                        {{ data.post.userName }}
                    </show-table-row>

                    <show-table-row heading="Title">
                        {{ data.post.title }}
                    </show-table-row>

                    <show-table-row heading="Author">
                        <div
                            class="grid md:grid-cols-2 gap-2 md:gap-4 max-w-3xl"
                        >
                            <div
                                v-if="data.post.author"
                                class="flex gap-2 md:gap-4"
                            >
                                <div class="grow-0 shrink-0">
                                    <avatar-photo-view
                                        :imageUrl="data.post.author.imageUrl"
                                        :firstLatter="data.post.author.firstLatter"
                                        class="w-12 text-3xl bg-brand-600/40 text-brand-600"
                                    />
                                </div>
                                <div class="grow shrink">
                                    <h3 class="text-base font-semibold">
                                        {{ data.post.author.name }}
                                    </h3>
                                    <p class="text-xs">
                                        {{ data.post.author.designation }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </show-table-row>

                    <show-table-row heading="Description">
                        {{ data.post.description }}
                    </show-table-row>

                    <show-table-row heading="Body">
                        <div class="grid gap-2 ProseMirror" v-html="data.post.body"></div>
                    </show-table-row>
                </table>
            </div>

            <div class="w-full mt-4 flex">
                <go-to-list :href="route('posts.index')" />
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/App.vue";
import { Head, Link } from "@inertiajs/vue3";
import ShowTableRow from "@/Components/ShowTableRow.vue";
import ActionButtonEdit from "@/Components/ActionButtonEdit.vue";
import GoToList from "@/Components/GoToList.vue";
import AddNewButton from "@/Components/AddNewButton.vue";
import ImagePrevieWithSave from "@/Components/ImagePrevieWithSave.vue";
import AvatarPhotoView from "@/Components/AvatarPhotoView.vue";
import {
    ExternalLinkIcon,
} from "@heroicons/vue/outline";

export default {
    components: {
        AppLayout,
        Head,
        Link,
        ShowTableRow,
        ActionButtonEdit,
        GoToList,
        AddNewButton,
        ImagePrevieWithSave,
        AvatarPhotoView,
        ExternalLinkIcon,
    },
    props: {
        data: { 
            type: Object,
            default: {} 
        },
    },
};
</script>
