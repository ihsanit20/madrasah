<template>
    <div class="w-full max-w-xl rounded border bg-white p-4 shadow">
        <validation-errors class="mb-4" />

        <form @submit.prevent="submit" class="">
            <div v-if="data.setting.key === 'youtube' || data.setting.key === 'facebook'" class="grid gap-4">
                <form-group class="w-full" label="Name">
                    <Input
                        type="text"
                        class="block w-full"
                        v-model="name"
                        required
                    />
                </form-group>
                <form-group class="w-full" label="Link">
                    <Input
                        type="text"
                        class="block w-full"
                        v-model="link"
                        required
                    />
                </form-group>
            </div>

            <div v-else class="grid gap-4">
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
    created() {
        if(this.data.setting.key === 'youtube' || this.data.setting.key === 'facebook') {
            const setting = this.data.setting.value.split('|');

            this.name = (setting[0] || "").trim();

            this.link = (setting[1] || "").trim();
        }
    },
    data() {
        return {
            form: this.$inertia.form({
                key: this.data.setting.key || "",
                name: this.data.setting.name || "",
                value: this.data.setting.value || "",
            }),
            name: "",
            link: "",
        };
    },
    methods: {
        submit() {
            if(this.data.setting.key === 'youtube' || this.data.setting.key === 'facebook') {
                this.form.value = this.name + '|' + this.link;
            }

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
        },
    },
};
</script>
