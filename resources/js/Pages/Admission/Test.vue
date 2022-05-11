<template>
    <div class="w-full max-w-3xl rounded border bg-white p-4 shadow">
        <validation-errors class="mb-4" />

        <form @submit.prevent="submit" class="space-y-4">
            <h2
                class="mt-4 mb-2 text-center text-2xl font-bold text-sky-600 print:text-black"
            >
                ভর্তির যোগ্যতা যাচাই
            </h2>
            <div class="grid gap-4 print:grid-cols-2 md:grid-cols-3">
                <div class="col-span-2">
                    <inline-data
                        title="শিক্ষার্থীর নাম:"
                        :value="data.student.name"
                    />
                </div>
                <div>
                    <inline-data
                        title="ফরম নাম্বার:"
                        :value="data.admission.id"
                    />
                </div>
                <div class="col-span-2">
                    <inline-data
                        title="ভর্তিচ্ছু বিভাগ/শ্রেণী:"
                        :value="data.admission.className"
                    />
                </div>
                <div>
                    <inline-data
                        title="শিক্ষার্থীর ধরন:"
                        :value="data.student.residentText"
                    />
                </div>
            </div>

            <hr />

            <div class="grid gap-x-2 gap-y-4 md:grid-cols-2">
                <form-group
                    class="w-full"
                    label="ভর্তি পরীক্ষা / বার্ষিক পরীক্ষায় প্রাপ্ত ফলাফল"
                >
                    <Input
                        type="text"
                        class="block w-full"
                        v-model="form.admission_test_mark"
                    />
                </form-group>
                <form-group class="flex-1" label="পরীক্ষক:">
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

            <div class="flex items-center justify-between">
                <Link
                    :href="route('admissions.show', data.admission.id)"
                    class="rounded-md border border-orange-600 px-4 py-2 font-semibold text-orange-600 hover:bg-orange-700 hover:text-white"
                >
                    &#8592; পূর্ববর্তী ধাপ
                </Link>
                <Button
                    class="bg-green-600 hover:bg-green-500"
                    :disabled="form.processing"
                    v-html="buttonValue"
                >
                </Button>
            </div>
        </form>
    </div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";
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
        Link,
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
            default: "পরবর্তী ধাপ &#8594;",
        },
        data: {
            type: Object,
            default: {},
        },
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
        diclarationByAdmin(event) {
            if (event.target.checked) {
                return (this.declaration = 1);
            }

            return (this.declaration = 0);
        },
    },
};
</script>
