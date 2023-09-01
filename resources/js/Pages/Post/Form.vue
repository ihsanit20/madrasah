<template>
    <div class="w-full max-w-3xl mx-auto p-4 bg-white border shadow">
        <ValidationErrors class="mb-4" />

        <form @submit.prevent="submit" class="w-full">
            <div class="mb-4 w-full">
                <Label value="Title" />
                <Input
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.title"
                    required
                    autofocus
                />
            </div>

            <!-- <div class="mb-4">
                <Label value="Description" />
                <textarea
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 shadow-sm resize-y"
                    v-model="form.description"
                    rows="3"
                    required
                ></textarea>
            </div> -->


            <div v-if="false" class="mb-4 w-full">
                <Label for="body" value="Body" />
                <textarea
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 shadow-sm resize-y"
                    v-model="form.body"
                    rows="10"
                    required
                >
                </textarea>
            </div>

            <div
                v-if="editor"
                class="font-serif flex gap-2 justify-center items-center flex-wrap"
            >
                <button
                    type="button"
                    @click="editor.chain().focus().toggleBold().run()"
                    :class="{
                        'bg-sky-600': editor.isActive('bold'),
                        'bg-gray-600': !editor.isActive('bold'),
                    }"
                    class="px-2 py-1 border rounded shadow text-white"
                >
                    B
                </button>

                <button
                    type="button"
                    @click="editor.chain().focus().toggleItalic().run()"
                    :class="{
                        'bg-sky-600': editor.isActive('italic'),
                        'bg-gray-600': !editor.isActive('italic'),
                    }"
                    class="px-2 py-1 border rounded shadow text-white"
                >
                    <i>I</i>
                </button>

                <button
                    type="button"
                    @click="editor.chain().focus().toggleUnderline().run()"
                    :class="{
                        'bg-sky-600': editor.isActive('underline'),
                        'bg-gray-600': !editor.isActive('underline'),
                    }"
                    class="px-2 py-1 border rounded shadow text-white"
                >
                    <u>U</u>
                </button>
                <!-- <button
                    type="button"
                    @click="editor.chain().focus().setParagraph().run()"
                    :class="{
                        'bg-sky-600': editor.isActive('paragraph'),
                        'bg-gray-600': !editor.isActive('paragraph'),
                    }"
                    class="px-2 py-1 border rounded shadow text-white"
                >
                    paragraph
                </button> -->
                <button
                    type="button"
                    @click="
                        editor.chain().focus().toggleHeading({ level: 3 }).run()
                    "
                    :class="{
                        'bg-sky-600': editor.isActive('heading', { level: 3 }),
                        'bg-gray-600': !editor.isActive('heading', {
                            level: 3,
                        }),
                    }"
                    class="px-2 py-1 border rounded shadow text-white"
                >
                    H1
                </button>
                <input
                    type="color"
                    @input="
                        editor
                            .chain()
                            .focus()
                            .setColor($event.target.value)
                            .run()
                    "
                    class="w-10 h-10"
                    :value="
                        editor.getAttributes('textStyle').color || '#000000'
                    "
                />
                <button
                    type="button"
                    @click="editor.chain().focus().toggleBulletList().run()"
                    :class="{
                        'bg-sky-600': editor.isActive('bulletList'),
                        'bg-gray-600': !editor.isActive('bulletList'),
                    }"
                    class="px-2 py-1 border rounded shadow text-white"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="w-6 h-6"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"
                        />
                    </svg>
                </button>
                <button
                    type="button"
                    @click="editor.chain().focus().toggleOrderedList().run()"
                    :class="{
                        'bg-sky-600': editor.isActive('orderedList'),
                        'bg-gray-600': !editor.isActive('orderedList'),
                    }"
                    class="px-2 py-1 border rounded shadow text-white flex justify-center items-center gap-0.5"
                >
                    <div class="grid text-[5.3px]">
                        <span>1</span>
                        <span>2</span>
                        <span>3</span>
                    </div>
                    <span>&#9776;</span>
                </button>
                <button
                    type="button"
                    @click="editor.chain().focus().setTextAlign('left').run()"
                    :class="{
                        'bg-sky-600': editor.isActive({ textAlign: 'left' }),
                        'bg-gray-600': !editor.isActive({ textAlign: 'left' }),
                    }"
                    class="px-2 py-1 border rounded shadow text-white"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="w-6 h-6"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25H12"
                        />
                    </svg>
                </button>
                <button
                    type="button"
                    @click="editor.chain().focus().setTextAlign('center').run()"
                    :class="{
                        'bg-sky-600': editor.isActive({ textAlign: 'center' }),
                        'bg-gray-600': !editor.isActive({
                            textAlign: 'center',
                        }),
                    }"
                    class="px-2 py-1 border rounded shadow text-white"
                >
                    center
                </button>
                <button
                    type="button"
                    @click="editor.chain().focus().setTextAlign('right').run()"
                    :class="{
                        'bg-sky-600': editor.isActive({ textAlign: 'right' }),
                        'bg-gray-600': !editor.isActive({ textAlign: 'right' }),
                    }"
                    class="px-2 py-1 border rounded shadow text-white"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="w-6 h-6"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M3.75 6.75h16.5M3.75 12h16.5M12 17.25h8.25"
                        />
                    </svg>
                </button>
                <button
                    type="button"
                    @click="
                        editor.chain().focus().setTextAlign('justify').run()
                    "
                    :class="{
                        'bg-sky-600': editor.isActive({ textAlign: 'justify' }),
                        'bg-gray-600': !editor.isActive({
                            textAlign: 'justify',
                        }),
                    }"
                    class="px-2 py-1 border rounded shadow text-white"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="w-6 h-6"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"
                        />
                    </svg>
                </button>
                <button
                    type="button"
                    @click="setLink"
                    :class="{
                        'bg-sky-600': editor.isActive('link'),
                        'bg-gray-600': !editor.isActive('link'),
                    }"
                    class="px-2 py-1 border rounded shadow text-white"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="w-6 h-6"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244"
                        />
                    </svg>
                </button>
                <button
                    type="button"
                    @click="editor.chain().focus().undo().run()"
                    class="px-2 py-1 border rounded shadow text-white bg-blue-400"
                >
                    &#8630;
                </button>
                <button
                    type="button"
                    @click="editor.chain().focus().redo().run()"
                    class="px-2 py-1 border rounded shadow text-white bg-blue-400"
                >
                    &#8631;
                </button>
            </div>

            <editor-content
                :editor="editor"
                class="border rounded shadow focus:outline-none my-3 overflow-y-auto"
            />

            <hr class="w-full my-4" />

            <div class="flex items-center justify-between">
                <div class="">
                    <go-to-list :href="route('posts.index')" />
                </div>
                <Button
                    class=""
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    {{ buttonValue }}
                </Button>
            </div>
        </form>
    </div>
</template>

<script>
import Button from "@/Components/Button.vue";
import GoToList from "@/Components/GoToList.vue";
import Input from "@/Components/Input.vue";
import Label from "@/Components/Label.vue";
import Select from "@/Components/Select.vue";
import ValidationErrors from "@/Components/ValidationErrors.vue";
import AvatarPhotoView from "@/Components/AvatarPhotoView.vue";
import { PlusCircleIcon, TrashIcon } from "@heroicons/vue/outline";

import { Editor, EditorContent } from "@tiptap/vue-3";
import StarterKit from "@tiptap/starter-kit";

import { Color } from "@tiptap/extension-color";
import Link from "@tiptap/extension-link";
import TextAlign from "@tiptap/extension-text-align";
import TextStyle from "@tiptap/extension-text-style";
import Underline from "@tiptap/extension-underline";
import Heading from "@tiptap/extension-heading";

export default {
    components: {
        Button,
        Input,
        Label,
        ValidationErrors,
        GoToList,
        Select,
        EditorContent,
        AvatarPhotoView,
        TrashIcon,
        PlusCircleIcon,
    },

    props: {
        moduleAction: String,
        buttonValue: {
            type: String,
            default: "Submit",
        },
        data: {
            type: Object,
            default: {},
        },
    },

    data() {
        return {
            form: this.$inertia.form({
                title: this.data.post.title,
                description: this.data.post.description,
                body: this.data.post.body,
                author_id: this.data.post.author_id || '',
            }),
            editor: null,
        };
    },

    methods: {
        submit() {
            this.form.body = this.editor.getHTML();

            if (this.moduleAction == "store") {
                return this.form.post(this.route("posts.store"));
            }

            if (this.moduleAction == "update") {
                return this.form.put(
                    this.route("posts.update", this.data.post.id)
                );
            }
        },
        bold() {
            console.log(window.getSelection());
        },
        setLink() {
            const previousUrl = this.editor.getAttributes("link").href;
            const url = window.prompt("URL", previousUrl);

            // cancelled
            if (url === null) {
                return;
            }

            // empty
            if (url === "") {
                this.editor
                    .chain()
                    .focus()
                    .extendMarkRange("link")
                    .unsetLink()
                    .run();

                return;
            }

            // update link
            this.editor
                .chain()
                .focus()
                .extendMarkRange("link")
                .setLink({ href: url })
                .run();
        },
        GetAuthorImageUrl(authorId) {
            let selectedAuthor = Object.values(this.data.authors).filter(
                (author) => author.id == parseInt(authorId)
            )[0];

            return selectedAuthor ? selectedAuthor.imageUrl : "";
        },
        GetAuthorFirstLatter(authorId) {
            let selectedAuthor = Object.values(this.data.authors).filter(
                (author) => author.id == parseInt(authorId)
            )[0];

            return selectedAuthor ? selectedAuthor.firstLatter : "";
        },
    },

    mounted() {
        this.editor = new Editor({
            extensions: [
                StarterKit,
                Underline,
                Color,
                TextStyle,
                Link.configure({
                    openOnClick: false,
                }),
                TextAlign.configure({
                    types: ["paragraph", "bold", "heading"],
                }),
                Heading.configure({
                    levels: [1, 2, 3],
                }),
            ],
            content: this.form.body,
        });
    },

    beforeUnmount() {
        this.editor.destroy();
    },
};
</script>

<style>
/* Basic editor styles */
.tiptap {
    min-height: 120px;
    padding: 4px;
}

.tiptap > h3 {
    font-size: 24px;
}
</style>