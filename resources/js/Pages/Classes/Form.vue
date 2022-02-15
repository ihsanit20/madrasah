<template>
    <div class="w-full max-w-md rounded border bg-white p-4 shadow">
        <validation-errors class="mb-4" />

        <form @submit.prevent="submit" class="">
            <div class="grid gap-4">
                <div class="flex gap-2">
                    <div class="relative flex-grow">
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
                    <div class="relative w-14">
                        <Label
                            class="absolute -top-2 left-2.5 bg-white px-0.5"
                            value="Code"
                        />
                        <Input
                            type="number"
                            class="block w-full text-center"
                            v-model="form.code"
                            required
                        />
                    </div>
                </div>
                <div class="relative">
                    <Label
                        class="absolute -top-2 left-2.5 bg-white px-0.5"
                        value="Subjects"
                    />
                    <div class="flex flex-col gap-2 rounded border px-2 py-3">
                        <div
                            v-for="(subject, index) in form.subjects"
                            :key="index"
                            class="flex items-center gap-2 rounded border border-dashed border-gray-300 px-2 py-3"
                        >
                            <div class="relative w-20">
                                <Label
                                    class="absolute -top-2 left-2.5 bg-white px-0.5"
                                    value="Code"
                                />
                                <Input
                                    type="number"
                                    class="block w-full text-center"
                                    v-model="subject.code"
                                    required
                                />
                            </div>
                            <div class="relative flex-grow">
                                <Label
                                    class="absolute -top-2 left-2.5 bg-white px-0.5"
                                    value="Name"
                                />
                                <Input
                                    type="text"
                                    class="block w-full"
                                    v-model="subject.name"
                                    required
                                />
                            </div>
                            <div class="flex-grow-0">
                                <TrashIcon
                                    @click="removeSubjectSlot(index)"
                                    class="h-5 w-5 cursor-pointer text-red-600"
                                />
                            </div>
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
                <div class="relative">
                    <Label
                        class="absolute -top-2 left-2.5 bg-white px-0.5"
                        value="Fees"
                    />
                    <div class="flex flex-col gap-2 rounded border px-2 py-3">
                        <div
                            v-for="(fee, index) in form.fees"
                            :key="index"
                            class="flex flex-col items-center gap-2 rounded border border-dashed border-gray-300 px-2 py-3 md:flex-row"
                        >
                            <div class="relative w-full flex-grow md:w-auto">
                                <Label
                                    class="absolute -top-2 left-2.5 bg-white px-0.5"
                                    value="Fee Name"
                                />
                                <Input
                                    type="text"
                                    class="block w-full"
                                    v-model="fee.name"
                                    required
                                />
                            </div>
                            <div
                                class="flex w-full items-center gap-2 md:w-auto"
                            >
                                <div
                                    class="relative flex-grow md:w-32 md:flex-grow-0"
                                >
                                    <Select
                                        v-model="fee.period"
                                        class="block w-full"
                                    >
                                        <option value="">--Select--</option>
                                        <option value="1">Monthly</option>
                                        <option value="2">Annual</option>
                                    </Select>
                                </div>
                                <div class="relative w-20">
                                    <Label
                                        class="absolute -top-2 left-2.5 bg-white px-0.5"
                                        value="Amount"
                                    />
                                    <Input
                                        type="number"
                                        class="block w-full text-center"
                                        v-model="fee.amount"
                                        required
                                    />
                                </div>
                                <div class="flex-grow-0">
                                    <TrashIcon
                                        @click="removeFeeSlot(index)"
                                        class="h-5 w-5 cursor-pointer text-red-600"
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center justify-end">
                            <button
                                @click="addFeeSlot"
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
import { TrashIcon } from "@heroicons/vue/outline";
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
        TrashIcon,
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
        removeSubjectSlot(index) {
            this.form.subjects.splice(index, 1);
        },
        removeFeeSlot(index) {
            this.form.fees.splice(index, 1);
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
