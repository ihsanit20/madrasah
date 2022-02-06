<template>
    <div class="w-full max-w-md rounded border bg-white p-4 shadow">
        <validation-errors class="mb-4" />

        <form @submit.prevent="submit" class="">
            <div class="grid gap-4">
                <div class="relative">
                    <Label
                        class="absolute -top-2 left-2.5 bg-white px-0.5"
                        value="Name"
                    />
                    <Input
                        type="text"
                        class="block w-full"
                        v-model="form.name"
                        required
                    />
                </div>
                <div class="relative">
                    <Label
                        class="absolute -top-2 left-2.5 bg-white px-0.5"
                        value="Class"
                    />
                    <Select
                        class="block w-full"
                        v-model="form.class_id"
                        required
                    >
                        <option value="">-- Select Class --</option>
                        <option
                            v-for="(classes, index) in data.classesList"
                            :key="index"
                            :value="classes.id"
                        >
                            {{ classes.name }}
                        </option>
                    </Select>
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
import Label from "@/Components/Label.vue";
import Button from "@/Components/Button.vue";
import Input from "@/Components/Input.vue";
import Select from "@/Components/Select.vue";

export default {
    components: {
        ValidationErrors,
        Label,
        Button,
        Input,
        Select,
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
                name: this.data.subject.name,
                class_id: this.data.subject.classId,
            }),
        };
    },
    methods: {
        submit() {
            if (this.moduleAction == "store") {
                return this.form.post(this.route("subjects.store"));
            }
            if (this.moduleAction == "update") {
                return this.form.put(
                    this.route("subjects.update", this.data.subject.id)
                );
            }
        },
    },
};
</script>
