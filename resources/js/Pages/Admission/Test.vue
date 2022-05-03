<template>
    <div class="w-full max-w-3xl rounded border bg-white p-4 shadow">
        <validation-errors class="mb-4" />

        <form @submit.prevent="submit" class="space-y-4">
            <form-heading>ভর্তির যোগ্যতা যাচাই</form-heading>
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <inline-data
                        title="ফরম নাম্বার:"
                        :value="data.admission.id"
                    />
                </div>
                <div>
                    <inline-data
                        title="ভর্তিচ্ছু বিভাগ/শ্রেণী:"
                        :value="data.admission.className"
                    />
                </div>
                <div>
                    <inline-data
                        title="শিক্ষার্থীর নাম:"
                        :value="data.student.name"
                    />
                </div>
                <div>
                    <inline-data
                        title="পিতার নাম:"
                        :value="data.student.fatherInfo.name"
                    />
                </div>
            </div>

            <hr />

            <div class="grid gap-x-2 gap-y-4 md:grid-cols-2">
                <form-group
                    class="w-full"
                    label="বার্ষিক পরীক্ষা / ভর্তি পরীক্ষায় প্রাপ্ত নাম্বার"
                >
                    <Input
                        type="number"
                        class="block w-full"
                        v-model="form.admission_test_mark"
                        required
                    />
                </form-group>
                <form-group class="flex-1" label="পরিক্ষক:">
                    <Select
                        class="block w-full"
                        v-model="form.examiner"
                        required
                    >
                        <!-- <option value="">-- নির্বাচন করুন --</option> -->
                        <option
                            :selected="true"
                            :value="data.admission.class.teacherId"
                        >
                            {{ data.admission.class.teacherName }}
                        </option>
                    </Select>
                </form-group>

                <div
                    class="col-span-full space-y-3 rounded-md border border-dashed border-gray-300 p-3"
                >
                    <div class="flex items-center justify-between gap-4">
                        <div class="shrink grow text-sm md:text-base">
                            এই আবেদনকারী অত্র প্রতিষ্ঠানে ভর্তি হওয়ার যোগ্য কি
                            না?
                        </div>
                        <div
                            class="flex shrink-0 grow-0 flex-col items-center justify-center gap-0.5 md:flex-row md:gap-4"
                        >
                            <label
                                class="flex items-center justify-center gap-2"
                            >
                                <Input
                                    type="radio"
                                    name="eligible"
                                    :value="1"
                                    :checked="
                                        form.verifications.eligible == '1'
                                    "
                                    v-model="form.verifications.eligible"
                                    required
                                    @change="eligibleHandler"
                                />
                                <span class="w-5">হ্যাঁ</span>
                            </label>
                            <label
                                class="flex items-center justify-center gap-2"
                            >
                                <Input
                                    type="radio"
                                    name="eligible"
                                    :value="0"
                                    :checked="
                                        form.verifications.eligible == '0'
                                    "
                                    v-model="form.verifications.eligible"
                                    required
                                    @change="eligibleHandler"
                                />
                                <span class="w-5">না</span>
                            </label>
                        </div>
                    </div>

                    <div class="flex items-center justify-between gap-4">
                        <div class="shrink grow text-sm md:text-base">
                            আবেদনের সাথে প্রয়োজনীয় সকল কাগজপত্র সংযুক্ত করেছে কি
                            না?
                        </div>
                        <div
                            class="flex shrink-0 grow-0 flex-col items-center justify-center gap-0.5 md:flex-row md:gap-4"
                        >
                            <label
                                class="flex items-center justify-center gap-2"
                            >
                                <Input
                                    type="radio"
                                    name="attached"
                                    :value="1"
                                    :checked="
                                        form.verifications.attached == '1'
                                    "
                                    v-model="form.verifications.attached"
                                    required
                                />
                                <span class="w-5">হ্যাঁ</span>
                            </label>
                            <label
                                class="flex items-center justify-center gap-2"
                            >
                                <Input
                                    type="radio"
                                    name="attached"
                                    :value="0"
                                    :checked="
                                        form.verifications.attached == '0'
                                    "
                                    v-model="form.verifications.attached"
                                    required
                                />
                                <span class="w-5">না</span>
                            </label>
                        </div>
                    </div>

                    <div class="flex items-center justify-between gap-4">
                        <div class="shrink grow text-sm md:text-base">
                            প্রদিত সকল তথ্য সঠিক ও বিশ্বাসযোগ্য কি না?
                        </div>
                        <div
                            class="flex shrink-0 grow-0 flex-col items-center justify-center gap-0.5 md:flex-row md:gap-4"
                        >
                            <label
                                class="flex items-center justify-center gap-2"
                            >
                                <Input
                                    type="radio"
                                    name="correct"
                                    :value="1"
                                    :checked="form.verifications.correct == '1'"
                                    v-model="form.verifications.correct"
                                    required
                                />
                                <span class="w-5">হ্যাঁ</span>
                            </label>
                            <label
                                class="flex items-center justify-center gap-2"
                            >
                                <Input
                                    type="radio"
                                    name="correct"
                                    :value="0"
                                    :checked="form.verifications.correct == '0'"
                                    v-model="form.verifications.correct"
                                    required
                                />
                                <span class="w-5">না</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div
                    class="col-span-full space-y-1 rounded-md border border-dashed border-gray-300 p-3"
                >
                    <label class="flex items-center gap-2">
                        <Input
                            type="checkbox"
                            name="declaration"
                            :value="1"
                            :checked="declaration == '1'"
                            v-model="declaration"
                            @change="diclarationByAdmin"
                            required
                        />
                        <span>
                            আমি এই আবেদনকারীর দেওয়া সমস্ত তথ্য যাচাই করেছি
                        </span>
                    </label>
                    <div>
                        <inline-data title="যাচাইকারী:" :value="verifiedBy" />
                    </div>
                </div>
            </div>

            <hr />

            <div class="flex items-center justify-end">
                <Button
                    :class="{
                        'opacity-25': form.processing,
                        'bg-rose-600 hover:bg-rose-500':
                            this.form.verifications.eligible == 0,
                        'bg-green-600 hover:bg-green-500':
                            this.form.verifications.eligible == 1,
                    }"
                    :disabled="form.processing"
                >
                    {{ buttonText }}
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
import InlineData from "@/Components/InlineData.vue";

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
        InlineData,
    },
    props: {
        moduleAction: String,
        buttonValue: {
            type: String,
            default: "সকল তথ্য দিন",
        },
        data: {
            type: Object,
            default: {},
        },
    },
    created() {
        this.eligibleHandler();
    },
    data() {
        return {
            declaration: this.data.admission.status === 2 ? 1 : 0,
            verifiedBy:
                this.data.admission.verifiedBy ||
                this.$page.props.auth.user.name,
            buttonText: this.buttonValue,
            form: this.$inertia.form({
                step: 2,
                examiner: this.data.admission.class.teacherId,
                admission_test_mark: this.data.admission.admissionTestMark,
                verifications: {
                    eligible: this.data.admission.verifications.eligible,
                    attached: this.data.admission.verifications.attached,
                    correct: this.data.admission.verifications.correct,
                },
            }),
        };
    },
    methods: {
        submit() {
            if (this.moduleAction == "update") {
                return this.form.put(
                    this.route("admissions.update", this.data.admission.id)
                );
            }
        },
        eligibleHandler() {
            if (this.form.verifications.eligible == "1") {
                return (this.buttonText = "সংরক্ষণ করুণ এবং পরবর্তী ধাপে যান");
            }

            return (this.buttonText = "যোগ্য না হওয়ায় ফরম টি বাতিল করুন");
        },
        diclarationByAdmin(event) {
            if (event.target.checked) {
                return (this.declaration = 1);
            }

            return (this.declaration = 0);
        },
    },
};
</script>
