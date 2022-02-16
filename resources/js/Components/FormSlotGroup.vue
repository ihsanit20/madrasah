<template>
    <div class="relative">
        <Label
            v-if="label"
            :value="label"
            class="absolute -top-1.5 left-2.5 bg-white px-0.5 leading-4"
        />
        <div class="flex flex-col gap-2 rounded border px-2 py-3">
            <div
                v-for="(item, index) in collections"
                :key="index"
                class="flex items-center gap-2 rounded border border-dashed border-gray-300 px-2 py-3"
            >
                <slot :item="item" />
                <div class="flex-grow-0">
                    <TrashIcon
                        @click="removeSlot(index)"
                        class="h-5 w-5 cursor-pointer text-red-600"
                    />
                </div>
            </div>
            <div class="flex items-center justify-center">
                <add-button @click="addSlotMethod" />
            </div>
        </div>
    </div>
</template>

<script>
import { TrashIcon } from "@heroicons/vue/outline";
import AddButton from "./AddButton.vue";
import Label from "@/Components/Label.vue";
export default {
    components: {
        TrashIcon,
        AddButton,
        Label,
    },
    props: ["label", "collections", "addSlotMethod"],
    methods: {
        removeSlot(index) {
            this.collections.splice(index, 1);
        },
    },
};
</script>
