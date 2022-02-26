<template>
    <div class="w-full max-w-3xl rounded border bg-white p-4 shadow">
        <validation-errors class="mb-4" />

        <form @submit.prevent="submit" class="">
            <form-heading class="mb-2">Basic Information</form-heading>
            <div class="grid gap-x-2 gap-y-4 md:grid-cols-3">
                <form-group class="w-full md:col-span-2" label="Name">
                    <Input
                        type="text"
                        class="block w-full"
                        v-model="form.name"
                        required
                    />
                </form-group>
                <form-group class="w-full" label="Date of Birth">
                    <Input
                        type="date"
                        class="block w-full"
                        v-model="form.date_of_birth"
                        required
                    />
                </form-group>
                <form-group
                    class="w-full md:col-span-2"
                    label="Birth Certificate"
                >
                    <Input
                        type="number"
                        class="block w-full"
                        v-model="form.birth_certificate"
                        required
                    />
                </form-group>
                <form-group class="w-full" label="Gender">
                    <div
                        class="flex items-center gap-2 rounded-md border py-2 pl-2"
                    >
                        <label class="flex items-center gap-1">
                            <Input
                                v-model="form.gender"
                                type="radio"
                                name="gender"
                                :value="1"
                                required
                            />
                            <span>Male</span>
                        </label>
                        <label class="flex items-center gap-1">
                            <Input
                                v-model="form.gender"
                                type="radio"
                                name="gender"
                                :value="2"
                                required
                            />
                            <span>Female</span>
                        </label>
                    </div>
                </form-group>
                <form-group
                    class="col-span-full grid gap-2 rounded-md border border-dashed border-gray-300 px-2 pt-4 pb-2 md:grid-cols-3"
                    label="Father's info"
                >
                    <form-group class="w-full" label="Name">
                        <Input
                            type="text"
                            class="block w-full"
                            v-model="form.father_info.name"
                            required
                        />
                    </form-group>
                    <form-group class="w-full" label="Phone">
                        <Input
                            type="number"
                            class="block w-full"
                            v-model="form.father_info.phone"
                        />
                    </form-group>
                    <form-group class="w-full" label="Occupation">
                        <Input
                            type="text"
                            class="block w-full"
                            v-model="form.father_info.comment"
                        />
                    </form-group>
                </form-group>
                <form-group
                    class="col-span-full grid gap-2 rounded-md border border-dashed border-gray-300 px-2 pt-4 pb-2 md:grid-cols-3"
                    label="Mother's info"
                >
                    <form-group class="w-full" label="Name">
                        <Input
                            type="text"
                            class="block w-full"
                            v-model="form.mother_info.name"
                            required
                        />
                    </form-group>
                    <form-group class="w-full" label="Phone">
                        <Input
                            type="number"
                            class="block w-full"
                            v-model="form.mother_info.phone"
                        />
                    </form-group>
                    <form-group class="w-full" label="Occupation">
                        <Input
                            type="text"
                            class="block w-full"
                            v-model="form.mother_info.comment"
                        />
                    </form-group>
                </form-group>
            </div>

            <form-heading class="mt-6 mb-2">Contact Information</form-heading>
            <div class="grid gap-x-2 gap-y-4 md:grid-cols-3">
                <form-group
                    class="col-span-full grid gap-2 rounded-md border border-dashed border-gray-300 px-2 pt-3 pb-2"
                    label="Financial Guardian"
                >
                    <div
                        class="col-span-full flex items-center justify-center gap-3 md:justify-start"
                    >
                        <label class="flex items-center gap-1">
                            <Input
                                v-model="form.guardianType"
                                type="radio"
                                name="guardian_info_type"
                                :value="1"
                                required
                            />
                            <span>Father</span>
                        </label>
                        <label class="flex items-center gap-1">
                            <Input
                                v-model="form.guardianType"
                                type="radio"
                                name="guardian_info_type"
                                :value="2"
                                required
                            />
                            <span>Mother</span>
                        </label>
                        <label class="flex items-center gap-1">
                            <Input
                                v-model="form.guardianType"
                                type="radio"
                                name="guardian_info_type"
                                :value="3"
                                required
                            />
                            <span>Other</span>
                        </label>
                    </div>
                    <div
                        v-if="form.guardianType == 3"
                        class="grid gap-2 md:grid-cols-3"
                    >
                        <form-group class="w-full" label="Name">
                            <Input
                                type="text"
                                class="block w-full"
                                v-model="form.guardian_info.name"
                                required
                            />
                        </form-group>
                        <form-group class="w-full" label="Phone">
                            <Input
                                type="number"
                                class="block w-full"
                                v-model="form.guardian_info.phone"
                            />
                        </form-group>
                        <form-group class="w-full" label="Relation">
                            <Input
                                type="text"
                                class="block w-full"
                                v-model="form.guardian_info.comment"
                            />
                        </form-group>
                    </div>
                </form-group>
            </div>

            <form-heading class="mt-6 mb-2">Present Address</form-heading>
            <form-group
                class="col-span-full grid gap-2 rounded-md border border-dashed border-gray-300 px-2 pt-2 pb-2"
            >
                <div class="grid gap-x-2 gap-y-4 md:grid-cols-3">
                    <form-group>
                        <Select class="block w-full">
                            <option>-- Select Division --</option>
                        </Select>
                    </form-group>
                    <form-group>
                        <Select class="block w-full">
                            <option>-- Select District --</option>
                        </Select>
                    </form-group>
                    <form-group>
                        <Select class="block w-full">
                            <option>-- Select Area --</option>
                        </Select>
                    </form-group>
                    <form-group label="Address" class="col-span-full">
                        <Input type="text" class="block w-full" />
                    </form-group>
                </div>
            </form-group>

            <form-heading class="mt-6 mb-2">Permanent Address</form-heading>
            <form-group
                class="col-span-full grid gap-2 rounded-md border border-dashed border-gray-300 px-2 pt-2 pb-2"
            >
                <div
                    class="col-span-full flex items-center justify-center gap-3 md:justify-start"
                >
                    <label class="flex items-center justify-center gap-1">
                        <Input
                            v-model="form.is_same_address"
                            type="radio"
                            name="address"
                            :value="1"
                        />
                        <span>Same as present</span>
                    </label>
                    <label class="flex items-center justify-center gap-1">
                        <Input
                            v-model="form.is_same_address"
                            type="radio"
                            name="address"
                            :value="2"
                        />
                        <span>Difference</span>
                    </label>
                </div>
                <div
                    v-if="form.is_same_address == 2"
                    class="grid gap-x-2 gap-y-4 md:grid-cols-3"
                >
                    <form-group>
                        <Select class="block w-full">
                            <option>-- Select Division --</option>
                        </Select>
                    </form-group>
                    <form-group>
                        <Select class="block w-full">
                            <option>-- Select District --</option>
                        </Select>
                    </form-group>
                    <form-group>
                        <Select class="block w-full">
                            <option>-- Select Area --</option>
                        </Select>
                    </form-group>
                    <form-group label="Address" class="col-span-full">
                        <Input type="text" class="block w-full" />
                    </form-group>
                </div>
            </form-group>

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
import FormHeading from "@/Components/FormHeading.vue";
import FormGroup from "@/Components/FormGroup.vue";
import FormSlotGroup from "@/Components/FormSlotGroup.vue";

export default {
    components: {
        ValidationErrors,
        Label,
        Button,
        Input,
        Select,
        FormHeading,
        FormGroup,
        FormSlotGroup,
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
                name: this.data.student.name,
                date_of_birth: this.data.student.date_of_birth,
                birth_certificate: this.data.student.birth_certificate,
                gender: this.data.student.gender,
                father_info: {
                    name: "",
                    comment: "",
                    phone: "",
                },
                mother_info: {
                    name: "",
                    comment: "",
                    phone: "",
                },
                guardianType: 0,
                guardian_info: {
                    name: "",
                    comment: "",
                    phone: "",
                },
                is_same_address: 0,
            }),
        };
    },
    methods: {
        submit() {
            if (this.moduleAction == "store") {
                return this.form.post(this.route("students.store"));
            }
            if (this.moduleAction == "update") {
                return this.form.put(
                    this.route("students.update", this.data.student.id)
                );
            }
        },
    },
};
</script>
