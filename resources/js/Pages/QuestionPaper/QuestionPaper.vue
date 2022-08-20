<template>
    <Head title="প্রশ্নপত্র" />

    <app-layout pageTitle="প্রশ্নপত্র">
        <div
            class="w-full max-w-3xl rounded border bg-white p-4 shadow print:border-0 print:shadow-none"
        >
            <validation-errors class="mb-4 print:hidden" />

            <div v-if="!isEdit">
                <div class="flex items-center justify-between print:hidden">
                    <print-button />
                    <button
                        type="button"
                        class="rounded bg-sky-600 px-3 py-1 text-white"
                        @click="isEdit = true"
                    >
                        Edit
                    </button>
                </div>
                <div class="text-center text-4xl font-bold">
                    {{ data.madrasahName[form.language_type] }}
                </div>
                <hr class="my-3" />
                <div class="space-y-1">
                    <div class="grid grid-cols-2 gap-8">
                        <inline-data
                            v-if="Number(form.language_type) === 1"
                            title="পরীক্ষা:"
                            :value="data.questionPaper.exam.name"
                            class="justify-end"
                        />
                        <inline-data
                        dir="rtl"
                            v-if="Number(form.language_type) === 2"
                            title="الامنحان:"
                            :value="data.questionPaper.exam.arabic"
                            class="justify-start"
                        />
                        <inline-data
                            v-if="Number(form.language_type) === 3"
                            title="Exam:"
                            :value="data.questionPaper.exam.english"
                            class="justify-end"
                        />
                        <inline-data
                            title="শিক্ষাবর্ষ:"
                            :value="`${data.questionPaper.exam.session} হিজরি`"
                        />
                    </div>
                    <div class="grid grid-cols-2 gap-8">
                        <inline-data
                            title="শ্রেণী:"
                            :value="data.questionPaper.class.name"
                            class="justify-end"
                        />
                        <inline-data title="বিষয়:" :value="data.subject.name" />
                    </div>
                    <div class="grid grid-cols-2 gap-8">
                        <inline-data
                            title="সময়:"
                            :value="`${
                                data.questionPaper.hour
                                    ? checkConvert(data.questionPaper.hour) +
                                      ' ঘণ্টা'
                                    : ''
                            } ${
                                data.questionPaper.minute
                                    ? checkConvert(data.questionPaper.minute) +
                                      ' মিনিট'
                                    : ''
                            }`"
                        />
                        <inline-data
                            title="পূর্ণমান:"
                            :value="checkConvert(data.questionPaper.mark)"
                            class="justify-end"
                        />
                    </div>
                </div>
                <hr class="my-3" />
                <div class="mb-2 flex items-center justify-center">
                    <div class="text-lg font-bold">
                        {{ data.questionPaper.top_text }}
                    </div>
                </div>
                <div class="grid gap-4">
                    <div
                        v-for="(question, index) in this.data.questionPaper
                            .questions"
                        :key="index"
                        class="flex items-start"
                    >
                        <div
                            v-if="Number(form.language_type) === 2"
                            class="w-10"
                        >
                            <div class="text-right text-xl font-bold">
                                {{ checkConvert(question.mark) }}
                            </div>
                        </div>
                        <div class="grid w-full">
                            <div
                                :dir="
                                    Number(form.language_type) === 2
                                        ? 'rtl'
                                        : 'ltr'
                                "
                                class="font-bold"
                                v-html="
                                    checkConvert(index + 1) +
                                    '. ' +
                                    checkConvert(question.title)
                                "
                            ></div>
                            <div
                                :dir="
                                    Number(form.language_type) === 2
                                        ? 'rtl'
                                        : 'ltr'
                                "
                                class="whitespace-pre-wrap px-5 font-normal"
                                v-html="checkConvert(question.body)"
                            ></div>
                        </div>
                        <div
                            v-if="Number(form.language_type) !== 2"
                            class="w-10"
                        >
                            <div class="text-right text-xl font-bold">
                                {{ checkConvert(question.mark) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <form
                v-if="isEdit"
                @submit.prevent="submit"
                class="space-y-4 print:hidden"
            >
                <div class="grid gap-4 md:grid-cols-5">
                    <form-group
                        class="w-full md:col-span-2"
                        label="প্রশ্নের ভাষা"
                    >
                        <Select
                            class="block w-full"
                            v-model="form.language_type"
                            required
                        >
                            <option
                                v-for="(language, index) in languageList"
                                :key="index"
                                :value="index"
                            >
                                {{ language }}
                            </option>
                        </Select>
                    </form-group>
                    <form-group
                        class="w-full md:col-span-2"
                        label="সময়"
                        :required="true"
                    >
                        <div class="flex items-center justify-between gap-1">
                            <Input
                                type="number"
                                class="block w-full text-center"
                                v-model="form.hour"
                                required
                            />
                            <span>ঘন্টা</span>
                            <Input
                                type="number"
                                class="ml-2 block w-full text-center"
                                v-model="form.minute"
                                required
                            />
                            <span>মিনিট</span>
                        </div>
                    </form-group>
                    <form-group class="w-full" label="পূর্নমান">
                        <Input
                            type="number"
                            class="block w-full text-center"
                            v-model="form.mark"
                            required
                        />
                    </form-group>
                </div>

                <div class="grid gap-4">
                    <Input
                        type="text"
                        class="block w-full text-center"
                        v-model="form.top_text"
                        placeholder="প্রশ্নের উপরের লেখা (যেমন: যেকোন ৫টি প্রশ্নের উত্তর দাও)"
                    />
                </div>
                <div
                    v-for="(question, index) in this.form.questions"
                    :key="index"
                    class="flex gap-3 rounded bg-gray-200 p-3"
                >
                    <div
                        class="flex w-10 shrink-0 grow-0 flex-col items-center justify-start gap-2"
                    >
                        <div
                            class="flex h-10 w-10 items-center justify-center rounded-full bg-white text-xl font-bold"
                        >
                            {{ index + 1 }}
                        </div>
                        <div
                            class="flex h-10 w-10 items-center justify-center rounded-full bg-white font-bold"
                        >
                            <TrashIcon
                                @click="removeQuestionSlot(index)"
                                class="w-7 cursor-pointer text-rose-600"
                            />
                        </div>
                    </div>
                    <div class="grid shrink grow gap-3">
                        <Textarea
                            :dir="
                                Number(form.language_type) === 2 ? 'rtl' : 'ltr'
                            "
                            class="block w-full resize-none text-sm font-bold md:text-lg"
                            v-model="question.title"
                            @keyup="resizeTextarea"
                            @focus="resizeTextarea"
                            placeholder="প্রশ্ন/প্রশ্নের শিরনাম (Bold Font)"
                        ></Textarea>
                        <Textarea
                            :dir="
                                Number(form.language_type) === 2 ? 'rtl' : 'ltr'
                            "
                            class="block w-full resize-none text-sm font-normal md:text-lg"
                            v-model="question.body"
                            @keyup="resizeTextarea"
                            @focus="resizeTextarea"
                            placeholder="প্রশ্ন/প্যারাগ্রাফ (Normal Font)"
                        ></Textarea>
                    </div>
                    <div class="grid w-16 shrink-0 grow-0 gap-3">
                        <div>
                            <Input
                                type="number"
                                class="block w-full text-center"
                                v-model="question.mark"
                                required
                                placeholder="মান"
                            />
                        </div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button
                        type="button"
                        class="rounded-lg bg-blue-500 px-4 py-2 text-sm font-bold text-white"
                        @click="addQuestionSlot"
                    >
                        প্রশ্ন যোগ করুন
                    </button>
                </div>

                <hr class="my-4 w-full" />

                <div class="flex items-center justify-end">
                    <Button
                        class=""
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                    >
                        Save
                    </Button>
                </div>
            </form>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/App.vue";
import { Head } from "@inertiajs/inertia-vue3";
import ValidationErrors from "@/Components/ValidationErrors.vue";
import Button from "@/Components/Button.vue";
import Input from "@/Components/Input.vue";
import Select from "@/Components/Select.vue";
import FormGroup from "@/Components/FormGroup.vue";
import Textarea from "@/Components/Textarea.vue";
import { TrashIcon } from "@heroicons/vue/outline";
import InlineData from "@/Components/InlineData.vue";
import PrintButton from "@/Components/PrintButton.vue";

export default {
    components: {
        AppLayout,
        Head,
        ValidationErrors,
        Button,
        Input,
        Select,
        FormGroup,
        Textarea,
        TrashIcon,
        InlineData,
        PrintButton,
    },
    props: {
        data: {
            type: Object,
            default: {},
        },
    },
    created() {
        this.languageList = this.data.languageList;

        Object.values(this.data.questionPaper.questions).forEach((question) => {
            this.addQuestionSlot({
                title: question.title,
                body: question.body,
                mark: question.mark,
            });
        });
    },
    data() {
        return {
            form: this.$inertia.form({
                top_text: this.data.questionPaper.top_text,
                hour: this.data.questionPaper.hour,
                minute: this.data.questionPaper.minute,
                mark: this.data.questionPaper.mark,
                language_type: this.data.questionPaper.language_type || 1,
                questions: [],
            }),
            languageList: [],
            isEdit: false,
        };
    },
    methods: {
        submit() {
            return this.form.post(
                this.route("question-papers.question-paper", [
                    this.data.questionPaper.exam_id,
                    this.data.questionPaper.class_id,
                    this.data.questionPaper.subject_code,
                ]),
                {
                    onSuccess: () => {
                        this.isEdit = false;
                    },
                }
            );
        },
        resizeTextarea(e) {
            let area = e.target;
            let bothSideBorder = 2;
            area.style.height = "auto";
            area.style.overflow = "hidden";
            area.style.height = area.scrollHeight + bothSideBorder + "px";
        },
        changeClass() {
            let selectedClass = Object.values(this.classList).find(
                (classes) => classes.id == this.form.class_id
            );

            this.subjectList = selectedClass ? selectedClass.subjects : [];
        },
        questionFormated(question) {
            return {
                id: question.id || "",
                question_paper_id: question.question_paper_id || "",
                title: question.title || "",
                body: question.body || "",
                mark: question.mark || "",
            };
        },
        addQuestionSlot(data = {}) {
            this.form.questions.push(this.questionFormated(data));
        },
        removeQuestionSlot(index) {
            if (!confirm("আপনি কি প্রশ্ন মুছে ফেলতে চান?")) {
                return;
            }

            this.form.questions.splice(index, 1);

            // this.form.questions.length == 0 && this.addQuestionSlot();
        },
        checkConvert(value) {
            if (Number(this.form.language_type) === 1) {
                return this.$e2bnumber(value);
            }

            if (Number(this.form.language_type) === 2) {
                return this.$e2anumber(value);
            }

            return value;
        },
    },
};
</script>
