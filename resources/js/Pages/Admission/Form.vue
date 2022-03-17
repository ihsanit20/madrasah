<template>
    <div class="w-full max-w-xs rounded border bg-white p-4 shadow">
        <validation-errors class="mb-4" />

        <form @submit.prevent="submit" class="">
            <div class="grid gap-4 md:grid-cols-2">
                <form-group label="Class" class="col-span-full">
                    <Select
                        required
                        class="block w-full"
                        v-model="form.class_id"
                    >
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
                    <Select
                        required
                        class="block w-full"
                        v-model="form.student_id"
                    >
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
                    <Select required class="block w-full" v-model="form.year">
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
                        required
                        type="number"
                        class="block w-full"
                        v-model="form.roll"
                    />
                </form-group>

                <label
                    for="resident"
                    class="col-span-full flex items-center gap-2"
                >
                    <Input
                        id="resident"
                        type="checkbox"
                        @change="residentHandler"
                        :value="1"
                        :checked="form.resident"
                    />
                    Resident
                </label>
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
    created() {
        let year = new Date().getFullYear() + 1;

        do {
            this.years.push(year);
            year--;
        } while (year >= 2020);
    },
    data() {
        return {
            form: this.$inertia.form({
                student_id: this.data.admission.studentId || "",
                class_id: this.data.admission.classId || "",
                year: this.data.admission.year || "",
                roll: this.data.admission.roll || "",
                resident: this.data.admission.resident ? 1 : 0,
            }),
            years: [],
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
        residentHandler(event) {
            this.form.resident = event.target.checked ? 1 : 0;
        },
    },
};
</script>
