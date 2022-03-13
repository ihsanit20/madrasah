<template>
    <div class="w-full max-w-xs rounded border bg-white p-4 shadow">
        <validation-errors class="mb-4" />

        <form @submit.prevent="submit" class="">
            <div class="grid gap-4 md:grid-cols-2">
                <form-group label="Class" class="col-span-full">
                    <Select class="block w-full" v-model="form.class_id">
                        <optgroup
                            v-for="classes in data.classes"
                            :key="classes.id"
                            :label="`Code: ${classes.code}`"
                        >
                            <option :value="classes.id">
                                {{ classes.name }}
                            </option>
                        </optgroup>
                    </Select>
                </form-group>

                <form-group label="Student" class="col-span-full">
                    <Select class="block w-full" v-model="form.student_id">
                        <optgroup
                            v-for="student in data.students"
                            :key="student.id"
                            :label="`Father: ${student.fatherInfo.name}`"
                        >
                            <option :value="student.id">
                                {{ student.name }}
                            </option>
                        </optgroup>
                    </Select>
                </form-group>

                <form-group label="Year">
                    <Select class="block w-full" v-model="form.year">
                        <option
                            v-for="(year, index) in years"
                            :key="index"
                            :value="year"
                        >
                            {{ year }}
                        </option>
                    </Select>
                </form-group>

                <form-group label="Roll">
                    <Input
                        type="number"
                        class="block w-full"
                        v-model="form.roll"
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

export default {
    components: {
        ValidationErrors,
        Button,
        Input,
        Select,
        FormGroup,
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
                student_id: "",
                class_id: "",
                year: "",
                roll: "",
            }),
            years: [2020, 2021, 2022, 2023],
        };
    },
    methods: {
        submit() {
            if (this.moduleAction == "store") {
                return this.form.post(this.route("admissions.store"));
            }
            if (this.moduleAction == "update") {
                return this.form.put(
                    this.route("admissions.update", this.data.admission.id)
                );
            }
        },
    },
};
</script>
