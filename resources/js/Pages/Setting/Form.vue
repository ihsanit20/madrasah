<template>
    <div class="w-full max-w-xl rounded border bg-white p-4 shadow">
        <validation-errors class="mb-4" />

        <form @submit.prevent="submit" class="">
            <div class="grid gap-4">
                <form-group class="w-full" :label="form.name">
                    <Textarea
                        class="block h-full min-h-max w-full resize-none text-sm md:text-lg"
                        v-model="form.value"
                        @keyup="resizeTextarea"
                        @focus="resizeTextarea"
                    ></Textarea>
                </form-group>
            </div>

            <hr class="my-4 w-full" />

            <div class="flex items-center justify-end">
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
import ValidationErrors from "@/Components/ValidationErrors.vue";
import Button from "@/Components/Button.vue";
import Input from "@/Components/Input.vue";
import Select from "@/Components/Select.vue";
import FormGroup from "@/Components/FormGroup.vue";
import Textarea from "@/Components/Textarea.vue";

export default {
    components: {
        ValidationErrors,
        Button,
        Input,
        Select,
        FormGroup,
        Textarea,
    },
    props: {
        moduleAction: String,
        buttonValue: {
            type: String,
            default: "Save",
        },
        data: {
            type: Object,
            default: {},
        },
    },
    data() {
        return {
            form: this.$inertia.form({
                key: this.data.setting.key || "",
                name: this.data.setting.name || "",
                value: this.data.setting.value || "",
            }),
        };
    },
    methods: {
        submit() {
            if (this.moduleAction == "store") {
                return this.form.post(this.route("settings.store"));
            }
            if (this.moduleAction == "update") {
                return this.form.put(
                    this.route("settings.update", this.data.setting.id)
                );
            }
        },
        resizeTextarea(e) {
            let area = e.target;
            area.style.overflow = "hidden";
            area.style.height = area.scrollHeight + "px";
            console.log(area.scrollHeight);
            console.dir(area);
        },
    },
};
</script>
