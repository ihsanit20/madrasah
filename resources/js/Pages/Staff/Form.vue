<template>
    <div class="w-full max-w-xl rounded border bg-white p-4 shadow">
        <validation-errors class="mb-4" />

        <form @submit.prevent="submit" class="">
            <div class="grid gap-4">
                <form-group class="w-full" label="নাম">
                    <Input
                        type="text"
                        class="block w-full"
                        v-model="form.name"
                        required
                    />
                </form-group>
                <form-group label="পদবি">
                    <Select
                        required
                        class="block w-full"
                        v-model="form.designation_id"
                    >
                        <option
                            v-for="(designation, index) in data.designations"
                            :key="index"
                            :value="designation.id"
                        >
                            {{ designation.name }}
                        </option>
                    </Select>
                </form-group>
                <form-group class="w-full" label="Phone">
                    <Input
                        type="number"
                        class="block w-full"
                        v-model="form.phone"
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
                name: this.data.staff.name || "",
                phone: this.data.staff.phone || "",
                designation_id: this.data.staff.designationId || "",
            }),
        };
    },
    methods: {
        submit() {
            if (this.moduleAction == "store") {
                return this.form.post(this.route("staff.store"));
            }
            if (this.moduleAction == "update") {
                return this.form.put(
                    this.route("staff.update", this.data.staff.id)
                );
            }
        },
    },
};
</script>
