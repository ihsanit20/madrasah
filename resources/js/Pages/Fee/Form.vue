<template>
    <div class="w-full max-w-xl rounded border bg-white p-4 shadow">
        <validation-errors class="mb-4" />

        <form @submit.prevent="submit" class="">
            <div class="grid gap-4">
                <form-group class="w-full" label="প্রদেয় ফি">
                    <Input
                        type="text"
                        class="block w-full"
                        v-model="form.name"
                        required
                    />
                </form-group>
                <form-group class="w-full" label="ফি-এর ধরন">
                    <Select v-model="form.period" class="block w-full">
                        <option value="">-- নির্বাচন --</option>
                        <option
                            v-for="(period, index) in data.periods"
                            :key="index"
                            :value="index"
                        >
                            {{ period }}
                        </option>
                    </Select>
                </form-group>
                <form-group
                    v-if="form.period == 3"
                    class="w-full"
                    label="নির্ধারিত মাস"
                >
                    <div class="grid grid-cols-2 gap-2 md:grid-cols-3">
                        <label
                            v-for="(month, index) in data.months"
                            :key="index"
                            class="rounded border p-2"
                        >
                            <input
                                type="checkbox"
                                :value="month.id"
                                :checked="
                                    form.months.includes(parseInt(month.id))
                                "
                                class="mr-2"
                                @change="toggleMonth"
                            />
                            {{ month.bengali }}
                        </label>
                    </div>
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
                name: this.data.fee.name || "",
                period: this.data.fee.period || "",
                months: this.data.fee.months || [],
            }),
        };
    },
    methods: {
        submit() {
            if (this.moduleAction == "store") {
                return this.form.post(this.route("fees.store"));
            }
            if (this.moduleAction == "update") {
                return this.form.put(
                    this.route("fees.update", this.data.fee.id)
                );
            }
        },
        toggleMonth(event) {
            const month = parseInt(event.target.value);
            const index = this.form.months.indexOf(month);
            if (index > -1) {
                this.form.months.splice(index, 1);
            } else {
                this.form.months.push(month);
            }
        },
    },
};
</script>
