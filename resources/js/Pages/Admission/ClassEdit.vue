<template>
    <div class="w-full max-w-xl rounded border bg-white p-4 shadow">
        <validation-errors class="mb-4" />

        <inline-data title="শিক্ষার্থী:" :value="data.student.name" />
        <inline-data title="ক্লাস:" :value="data.student.currentClassName" />
        <inline-data title="রোল:" :value="$e2bnumber(data.student.currentClassRoll)" />

        <hr class="my-3" />

        <form @submit.prevent="submit" class="">
            <div class="grid gap-4">
                <form-group label="নতুন ক্লাস">
                    <Select
                        required
                        class="block w-full"
                        v-model="form.class_id"
                    >
                        <option
                            v-for="(classes, index) in data.classes"
                            :key="index"
                            :value="classes.id"
                        >
                            {{ classes.name }}
                        </option>
                    </Select>
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
import InlineData from "@/Components/InlineData.vue";

export default {
    components: {
        ValidationErrors,
        Button,
        Input,
        Select,
        FormGroup,
        Textarea,
        InlineData,
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
                step: 5,
                class_id: this.data.admission.classId || "",
            }),
        };
    },
    methods: {
        submit() {
            if (this.moduleAction == "update") {
                return this.form.put(
                    this.route("admissions.update", this.data.admission.id)
                );
            }
        },
    },
};
</script>
