<template>
    <div class="w-full max-w-xl rounded border bg-white p-4 shadow">
        <validation-errors class="mb-4" />

        <form @submit.prevent="submit" class="">
            <div class="grid gap-6">
                <form-group label="নাম">
                    <Input
                        type="text"
                        class="block w-full"
                        v-model="form.name"
                        required
                    />
                </form-group>
                <form-group label="বিস্তারিত">
                    <Textarea
                        class="block h-40 w-full text-sm md:h-32 md:text-lg"
                        v-model="form.description"
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
import Label from "@/Components/Label.vue";

export default {
    components: {
        ValidationErrors,
        Button,
        Input,
        Select,
        FormGroup,
        Textarea,
        Label,
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
                name: this.data.department.name,
                description: this.data.department.description,
            }),
        };
    },
    created() {
        //
    },
    methods: {
        submit() {
            if (this.moduleAction == "store") {
                return this.form.post(this.route("departments.store"));
            }
            if (this.moduleAction == "update") {
                return this.form.put(
                    this.route("departments.update", this.data.department.id)
                );
            }
        },
        resizeTextarea(e) {
            let area = e.target;
            let bothSideBorder = 2;
            area.style.height = "auto";
            area.style.overflow = "hidden";
            area.style.height = area.scrollHeight + bothSideBorder + "px";
        },
    },
};
</script>
