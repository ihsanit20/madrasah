<template>
    <div class="w-full max-w-5xl rounded border bg-white p-4 shadow">
        <h3 class="text-center text-2xl font-bold text-sky-600">
            শিক্ষাগত যোগ্যতা
        </h3>

        <div class="grid md:grid-cols-2">
            <inline-data
                class="justify-start"
                title="নাম:" 
                :value="data.staff.name"
            />
            <inline-data
                class="justify-end"
                title="পদ:"
                :value="data.staff.designationTitle"
            />
            <inline-data
                class="justify-start"
                title="NID:"
                :value="data.staff.nid"
            />
            <inline-data
                class="justify-end"
                title="ফোন:"
                :value="data.staff.phone"
            />
        </div>

        <hr class="my-3" />

        <validation-errors class="mb-4" />

        <form @submit.prevent="submit" class="">
            <form-slot-group
                :collections="form.educational_qualifications"
                :addSlotMethod="addEducationalQualificationSlot"
            >
                <template #default="{ item: educational_qualification }">
                    <form-group
                        label="পরিক্ষার নাম"
                        class="w-full md:w-2/12"
                    >
                        <Input
                            type="text"
                            class="block w-full"
                            v-model="educational_qualification.exam_name"
                            required
                        />
                    </form-group>
                    <form-group
                        label="সাল"
                        class="w-full md:w-1/12"
                    >
                        <Input
                            type="text"
                            class="block w-full text-center"
                            v-model="educational_qualification.year"
                        />
                    </form-group>
                    <form-group
                        label="প্রতিষ্ঠানের নাম"
                        class="w-full md:w-4/12"
                    >
                        <Input
                            type="text"
                            class="block w-full"
                            v-model="educational_qualification.institute_name"
                        />
                    </form-group>
                    <form-group
                        label="বোর্ড"
                        class="w-full md:w-2/12"
                    >
                        <Input
                            type="text"
                            class="block w-full"
                            v-model="educational_qualification.board"
                        />
                    </form-group>
                    <form-group
                        label="ফলাফল"
                        class="w-full md:w-2/12"
                    >
                        <Input
                            type="text"
                            class="block w-full text-center"
                            v-model="educational_qualification.result"
                        />
                    </form-group>
                </template>
            </form-slot-group>

            <hr class="my-4 w-full" />

            <div class="flex items-center justify-between">
                <Link
                    :href="
                        route('staff.show', data.staff.id)
                    "
                    class="rounded-md border border-orange-600 px-4 py-2 font-semibold text-orange-600 hover:bg-orange-700 hover:text-white"
                >
                    Cancel
                </Link>
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
import { Link } from "@inertiajs/inertia-vue3"
import ValidationErrors from "@/Components/ValidationErrors.vue";
import Button from "@/Components/Button.vue";
import Input from "@/Components/Input.vue";
import Select from "@/Components/Select.vue";
import FormSlotGroup from "@/Components/FormSlotGroup.vue";
import Textarea from "@/Components/Textarea.vue";
import InlineData from "@/Components/InlineData.vue";
import FormGroup from "@/Components/FormGroup.vue";

export default {
    components: {
        Link,
        ValidationErrors,
        Button,
        Input,
        Select,
        FormSlotGroup,
        Textarea,
        InlineData,
        FormGroup,
    },
    props: {
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
        this.form.educational_qualifications = this.data.staff.educational_qualifications;
    },
    data() {
        return {
            form: this.$inertia.form({
                step: "education",
                educational_qualifications: [],
            }),
        };
    },
    methods: {
        addEducationalQualificationSlot() {
            this.form.educational_qualifications.push({
                exam_name: "",
                year: "",
                institute_name: "",
                board: "",
                result: ""
            });
        },
        submit() {
            return this.form.put(
                this.route("staff.update", this.data.staff.id)
            );
        },
    },
};
</script>
