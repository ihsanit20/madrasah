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
                        value="Subjects"
                    />
                    <div class="flex flex-col gap-4 rounded border p-4">
                        <div
                            v-for="(subject, index) in form.subjects"
                            :key="index"
                            class="flex items-center gap-2"
                        >
                            <Input
                                type="number"
                                class="block w-1/2"
                                v-model="subject.code"
                                required
                            />
                            <Input
                                type="text"
                                class="block w-full flex-shrink"
                                v-model="subject.name"
                                required
                            />
                            <span
                                @click="removeSubjectSlot(index)"
                                class="cursor-pointer text-3xl text-red-700"
                            >
                                &times;
                            </span>
                        </div>
                        <div class="flex items-center justify-end">
                            <button
                                @click="addSubjectSlot"
                                type="button"
                                class="rounded border px-3 py-1"
                            >
                                (+) Add Slot
                            </button>
                        </div>
                    </div>
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

export default {
    components: {
        ValidationErrors,
        Label,
        Button,
        Input,
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
    created() {
        if (Object.keys(this.data.classes.subjects).length) {
            this.form.subjects = this.data.classes.subjects;
        } else {
            this.form.subjects.push({
                code: "",
                name: "",
            });
        }
    },
    data() {
        return {
            form: this.$inertia.form({
                name: this.data.classes.name,
                subjects: [],
            }),
        };
    },
    methods: {
        addSubjectSlot() {
            this.form.subjects.push({
                code: "",
                name: "",
            });
        },
        removeSubjectSlot(index) {
            this.form.subjects.splice(index, 1);

            if (!this.form.subjects.length) {
                this.form.subjects.push({
                    code: "",
                    name: "",
                });
            }
        },
        submit() {
            if (this.moduleAction == "store") {
                return this.form.post(this.route("classes.store"));
            }
            if (this.moduleAction == "update") {
                return this.form.put(
                    this.route("classes.update", this.data.classes.id)
                );
            }
        },
    },
};
</script>
