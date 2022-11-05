<template>
    <form-group :label="label">
        <div class="flex flex-col gap-2 rounded border px-2 py-3">
            <slot name="header"></slot>
            <div
                v-for="(item, index) in collections"
                :key="index"
                class="flex items-center gap-2 rounded border border-dashed border-gray-300 px-2 py-3"
            >
                <slot :item="item" :index="index" :iteration="index + 1" />
                <div class="flex-grow-0">
                    <TrashIcon
                        @click="removeSlot(index)"
                        class="h-5 w-5 cursor-pointer text-red-600"
                    />
                </div>
            </div>
            <div v-if="addSlotMethod" class="flex items-center justify-center">
                <add-button @click="addSlotMethod" />
            </div>
        </div>
    </form-group>
</template>

<script>
import FormGroup from "./FormGroup.vue";
import { TrashIcon } from "@heroicons/vue/outline";
import AddButton from "./AddButton.vue";
import Label from "@/Components/Label.vue";
export default {
    components: {
        FormGroup,
        TrashIcon,
        AddButton,
        Label,
    },
    props: ["label", "collections", "addSlotMethod"],
    methods: {
        removeSlot(index) {
            if (confirm("Are you sure you want to delete?")) {
                this.collections.splice(index, 1);
            }
        },
    },
};
</script>
