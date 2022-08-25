<template>
    <div class="w-full max-w-3xl rounded border bg-white p-4 shadow">
        <validation-errors class="mb-4" />

        <form @submit.prevent="submit" class="space-y-4">
            <div class="grid gap-4 md:grid-cols-3">
                <form-group class="w-full md:col-span-2" label="পরীক্ষার নাম">
                    <Input
                        type="text"
                        class="block w-full"
                        v-model="form.name"
                        required
                    />
                </form-group>
                <form-group class="w-full" label="সেশন">
                    <Select
                        class="block w-full"
                        v-model="form.session"
                        required
                    >
                        <option value="1443-44">১৪৪৩-৪৪</option>
                    </Select>
                </form-group>
            </div>
            <div class="grid gap-3 rounded bg-gray-200 p-3 md:grid-cols-3">
                <div v-for="(classes, index) in this.data.classes" :key="index">
                    <label class="inline-flex items-center gap-2">
                        <Input
                            type="checkbox"
                            class=""
                            @change="changeClass"
                            :value="classes.id"
                            :checked="
                                form.classes.includes(
                                    Number(classes.id) || String(classes.id)
                                )
                            "
                        />
                        <span>{{ classes.name }}</span>
                    </label>
                </div>
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
import Label from "@/Components/Label.vue";
import Input from "@/Components/Input.vue";
import Select from "@/Components/Select.vue";
import FormGroup from "@/Components/FormGroup.vue";
import Textarea from "@/Components/Textarea.vue";
import { TrashIcon } from "@heroicons/vue/outline";

export default {
    components: {
        ValidationErrors,
        Button,
        Label,
        Input,
        Select,
        FormGroup,
        Textarea,
        TrashIcon,
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
        Object.values(this.data.exam.classes).forEach((classes) => {
            this.form.classes.push(Number(classes.id));
        });
    },
    data() {
        return {
            form: this.$inertia.form({
                name: this.data.exam.name,
                session: this.data.exam.session || "1443-44",
                classes: [],
            }),
        };
    },
    methods: {
        submit() {
            this.filterClass();

            if (this.moduleAction == "store") {
                return this.form.post(this.route("exams.store"));
            }
            if (this.moduleAction == "update") {
                return this.form.put(
                    this.route("exams.update", this.data.exam.id)
                );
            }
        },
        changeClass(event) {
            if (event.target.checked) {
                this.form.classes.push(Number(event.target.value));
            } else {
                let index = this.form.classes.indexOf(event.target.value);

                this.form.classes.splice(index, 1);
            }

            return this.filterClass();
        },
        filterClass() {
            // this.form.classes = [...new Set(this.form.classes)];
        },
    },
};
</script>
