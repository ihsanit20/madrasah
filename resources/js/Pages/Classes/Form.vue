<template>
    <div class="w-full max-w-lg rounded border bg-white p-4 shadow">
        <validation-errors class="mb-4" />

        <form @submit.prevent="submit" class="">
            <div class="grid gap-4">
                <div class="flex gap-2">
                    <form-group class="flex-grow" label="Name">
                        <Input
                            type="text"
                            class="block w-full"
                            v-model="form.name"
                            required
                        />
                    </form-group>
                    <form-group class="w-14" label="Code">
                        <Input
                            type="number"
                            class="block w-full text-center"
                            v-model="form.code"
                            required
                        />
                    </form-group>
                </div>
                <form-slot-group
                    label="Subjects"
                    :collections="form.subjects"
                    :addSlotMethod="addSubjectSlot"
                >
                    <template #default="{ item: subject }">
                        <form-group class="w-20" label="Code">
                            <Input
                                type="number"
                                class="block w-full text-center"
                                v-model="subject.code"
                                required
                            />
                        </form-group>
                        <form-group class="flex-grow" label="Name">
                            <Input
                                type="text"
                                class="block w-full"
                                v-model="subject.name"
                                required
                            />
                        </form-group>
                    </template>
                </form-slot-group>
                <form-slot-group
                    label="Fees"
                    :collections="form.fees"
                    :addSlotMethod="addFeeSlot"
                >
                    <template #default="{ item: fee }">
                        <div class="flex flex-col gap-2 md:flex-row">
                            <form-group
                                class="w-full flex-grow md:w-auto"
                                label="Fee Name"
                            >
                                <Input
                                    type="text"
                                    class="block w-full"
                                    v-model="fee.name"
                                    required
                                />
                            </form-group>
                            <div
                                class="flex w-full items-center gap-2 md:w-auto"
                            >
                                <form-group
                                    class="flex-grow md:w-32 md:flex-grow-0"
                                >
                                    <Select
                                        v-model="fee.period"
                                        class="block w-full"
                                    >
                                        <option value="">--Select--</option>
                                        <option value="1">Monthly</option>
                                        <option value="2">Annual</option>
                                    </Select>
                                </form-group>
                                <form-group class="w-20" label="Amount">
                                    <Input
                                        type="number"
                                        class="block w-full text-center"
                                        v-model="fee.amount"
                                        required
                                    />
                                </form-group>
                            </div>
                        </div>
                    </template>
                </form-slot-group>
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
import { TrashIcon, PlusCircleIcon } from "@heroicons/vue/outline";
import Button from "@/Components/Button.vue";
import Input from "@/Components/Input.vue";
import Select from "@/Components/Select.vue";
import AddButton from "@/Components/AddButton.vue";
import FormSlotGroup from "@/Components/FormSlotGroup.vue";
import FormGroup from "@/Components/FormGroup.vue";

export default {
    components: {
        ValidationErrors,
        Button,
        Input,
        Select,
        TrashIcon,
        PlusCircleIcon,
        AddButton,
        FormSlotGroup,
        FormGroup,
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
        this.form.subjects = this.data.classes.subjects || [];
        this.form.fees = this.data.classes.fees || [];
    },
    data() {
        return {
            form: this.$inertia.form({
                name: this.data.classes.name,
                code: this.data.classes.code,
                subjects: [],
                fees: [],
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
        addFeeSlot() {
            this.form.fees.push({
                name: "",
                period: "",
                amount: "",
            });
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
