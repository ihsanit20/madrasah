<template>
    <div class="w-full max-w-xl rounded border bg-white p-4 shadow">
        <validation-errors class="mb-4" />

        <form @submit.prevent="submit" class="">
            <div class="grid gap-4 md:grid-cols-2">
                <form-group label="তারিখ">
                    <Input
                        type="date"
                        class="block w-full"
                        v-model="form.date"
                    />
                </form-group>
                <form-group label="খাত">
                    <Select v-model="form.category_id">
                        <option value="">--নির্বাচন করুন--</option>
                        <option
                            v-for="category in data.categories"
                            :key="category.id"
                            :value="category.id"
                        >
                            {{ category.name }}
                        </option>
                    </Select>
                </form-group>
                <form-group label="টাকা">
                    <Input
                        type="number"
                        class="block w-full"
                        v-model="form.amount"
                    />
                </form-group>
                <form-group label="শিক্ষক/স্টাফ">
                    <Select v-model="form.staff_id">
                        <option value="">--নির্বাচন করুন--</option>
                        <optgroup
                            v-for="staff in data.staff"
                            :key="staff.id"
                            :label="staff.designation.name"
                        >
                            <option :value="staff.id">{{ staff.name }}</option>
                        </optgroup>
                    </Select>
                </form-group>
                <form-group label="বিবরণ" class="col-span-full">
                    <Input
                        type="text"
                        class="block w-full"
                        v-model="form.description"
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
                category_id: this.data.income.categoryId || "",
                staff_id: this.data.income.staffId || "",
                amount: this.data.income.amount || "",
                date: this.data.income.date,
                description: this.data.income.description,
            }),
        };
    },
    methods: {
        submit() {
            if (this.moduleAction == "store") {
                return this.form.post(this.route("incomes.store"));
            }
            if (this.moduleAction == "update") {
                return this.form.put(
                    this.route("incomes.update", this.data.income.id)
                );
            }
        },
    },
};
</script>
