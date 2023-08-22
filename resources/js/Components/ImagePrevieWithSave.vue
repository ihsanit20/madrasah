<template>
    <div class="grid w-full max-w-xs gap-3 border p-3">
        <div v-if="imagePreview" class="relative border" :class="ratioClass">
            <img :src="imagePreview" class="h-full w-full object-cover" />
            <div
                class="absolute inset-0 border border-dashed border-gray-600 bg-transparent"
                :class="ratioClass"
            ></div>
        </div>
        <div v-if="status" class="flex items-center justify-center print:hidden">
            <div
                v-if="status === 1"
                class="flex gap-2 bg-brand-600 px-4 py-2 font-bold text-white"
            >
                <span>&check;</span>
                Success
            </div>
            <div
                v-if="status === 2"
                class="flex gap-2 bg-indigo-500 px-4 py-2 font-bold text-white"
            >
                <span class="animate-spin font-bold">&#x205B;</span>
                Processing
            </div>
        </div>
        <div v-else class="flex items-center justify-center gap-4 print:hidden">
            <label
                v-if="!edit"
                class="cursor-pointer border border-brand-600 px-4 py-2 text-brand-600 hover:bg-brand-600 hover:text-white"
            >
                {{ imagePreview ? "পরিবর্তন" : "আপলোড" }}
                <input
                    type="file"
                    class="hidden"
                    accept="image/*"
                    @input="preview"
                />
            </label>
            <button
                v-if="edit"
                type="button"
                @click="cancel"
                class="w-1/2 text-sm cursor-pointer border border-rose-500 px-1 py-2 text-rose-500 hover:bg-rose-500 hover:text-white"
            >
                Cancel
            </button>
            <button
                v-if="edit"
                type="button"
                @click="save"
                class="w-1/2 text-sm cursor-pointer border border-brand-500 px-1 py-2 text-brand-600 hover:bg-brand-600 hover:text-white"
            >
                Save
            </button>
        </div>
    </div>
</template>

<script>
import axios from "axios";
export default {
    components: {},
    props: {
        imageUrl: {
            type: String,
            default: null,
        },
        ratioClass: {
            type: String,
            default: "aspect-video",
        },
        option: {
            type: String,
            default: null,
        },
        id: {
            type: Number,
            default: 0,
        },
        type: {
            type: Number,
            default: 1,
        },
        width: {
            type: Number,
            default: 300,
        },
        height: {
            type: Number,
            default: 300,
        },
    },
    created() {
        this.image = this.imageUrl;
        this.imagePreview = this.imageUrl;
    },
    data() {
        return {
            imagePreview: null,
            image: null,
            file: null,
            edit: false,
            status: 0,
        };
    },
    methods: {
        preview(event) {
            const file = event.target.files[0];
            const url = URL.createObjectURL(file);

            this.file = file;
            this.edit = true;
            this.imagePreview = url;
        },
        cancel() {
            this.imagePreview = null;
            this.edit = false;
            this.file = null;

            setTimeout(() => {
                this.imagePreview = this.image;
            }, 400);
        },
        save() {
            this.status = 2;
            const formData = new FormData();
            formData.append("image", this.file);
            formData.append("option", this.option);
            formData.append("id", this.id);
            formData.append("type", this.type);
            formData.append("width", this.width);
            formData.append("height", this.height);

            axios
                .post("/image-upload-get-link", formData)
                .then((response) => {
                    this.edit = false;
                    this.file = null;
                    this.status = 1;

                    setTimeout(() => {
                        this.status = 0;
                    }, 2000);
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
};
</script>
