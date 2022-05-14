<template>
    <div class="w-full max-w-xl rounded border bg-white p-4 shadow">
        <validation-errors class="mb-4" />

        <form @submit.prevent="submit" class="">
            <div class="grid gap-4">
                <form-group class="w-full" label="Name">
                    <Input
                        type="text"
                        class="block w-full"
                        v-model="form.name"
                        required
                    />
                </form-group>
                <form-group class="w-full" label="Email">
                    <Input
                        type="email"
                        class="block w-full"
                        v-model="form.email"
                        required
                    />
                </form-group>
                <form-group class="w-full" label="Password">
                    <Input
                        type="text"
                        class="block w-full"
                        v-model="form.password"
                    />
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
                name: this.data.admin.name || "",
                email: this.data.admin.email || "",
                password: "",
            }),
        };
    },
    methods: {
        submit() {
            if (this.moduleAction == "store") {
                return this.form.post(this.route("admins.store"));
            }
            if (this.moduleAction == "update") {
                return this.form.put(
                    this.route("admins.update", this.data.admin.id)
                );
            }
        },
    },
};
</script>
