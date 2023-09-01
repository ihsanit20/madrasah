<template>
    <Head title="Post" />

    <app-layout
        
    >
        <template #header> Post List </template>

        <div class="py-4">
            

            <add-new-button :href="route('posts.create')" />

            <data-table :collections="data.posts" :filters="data.filters">
                <template #head>
                    <th class="py-3 px-2 text-left">Photo</th>
                    <th class="py-3 px-2 text-left">Title</th>
                    <th class="py-3 px-2 text-left">Admin</th>
                    <th class="py-3 px-2 text-center">Action</th>
                </template>
                <template #default="{ item: post }">
                    <td class="py-3 px-2 text-left">
                        <img
                            v-if="post.imageUrl"
                            :src="post.imageUrl"
                            class="w-20 aspect-video"
                        />
                    </td>
                    <td class="py-3 px-2 text-left">
                        {{ post.title }}
                    </td>
                    <td class="py-3 px-2 text-left">
                        {{ post.userName }}
                    </td>
                    <td class="py-2.5 px-2">
                        <div
                            class="flex justify-center items-center gap-1 md:gap-2"
                        >
                            <action-button-show
                                :href="route('posts.show', post.id)"
                            />
                            <action-button-edit
                                :href="route('posts.edit', post.id)"
                            />
                            <action-button-delete
                                :href="route('posts.destroy', post.id)"
                            />
                        </div>
                    </td>
                </template>
            </data-table>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/App.vue";
import { Head, Link } from "@inertiajs/vue3";
import DataTable from "@/Components/DataTable3.vue";
import ActionButtonShow from "@/Components/ActionButtonShow.vue";
import ActionButtonEdit from "@/Components/ActionButtonEdit.vue";
import ActionButtonDelete from "@/Components/ActionButtonDelete.vue";
import AddNewButton from "@/Components/AddNewButton.vue";

export default {
    components: {
        AppLayout,
        DataTable,
        Head,
        Link,
        ActionButtonShow,
        ActionButtonEdit,
        ActionButtonDelete,
        AddNewButton,
    },
    props: {
        data: { 
            type: Object,
            default: {} 
        },
    },
    computed: {
        //
    },
};
</script>
