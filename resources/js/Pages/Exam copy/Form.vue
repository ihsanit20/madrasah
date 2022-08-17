<template>
    <div class="w-full max-w-3xl rounded border bg-white p-4 shadow">
        <validation-errors class="mb-4" />

        <form @submit.prevent="submit" class="space-y-4">
            <div class="grid gap-4 md:grid-cols-3">
                <form-group class="w-full" label="সেশন">
                    <Select
                        class="block w-full"
                        v-model="form.session"
                        required
                    >
                        <option value="৪৩-৪৪">৪৩-৪৪</option>
                    </Select>
                </form-group>
                <form-group class="w-full" label="ক্লাস">
                    <Select
                        class="block w-full"
                        v-model="form.class_id"
                        @change="changeClass"
                        required
                    >
                        <option value="">-- সিলেক্ট করুন --</option>
                        <option
                            v-for="classes in classList"
                            :key="classes.id"
                            :value="classes.id"
                        >
                            {{ classes.name }}
                        </option>
                    </Select>
                </form-group>
                <form-group class="w-full" label="বিষয়">
                    <Select
                        class="block w-full"
                        v-model="form.subject_code"
                        required
                    >
                        <option value="">-- সিলেক্ট করুন --</option>
                        <option
                            v-for="subject in subjectList"
                            :key="subject.code"
                            :value="subject.id"
                        >
                            {{ subject.name }}
                        </option>
                    </Select>
                </form-group>
            </div>
            <div class="grid gap-4 md:grid-cols-4">
                <form-group class="w-full md:col-span-2" label="পরীক্ষার নাম">
                    <Input
                        type="text"
                        class="block w-full"
                        v-model="form.name"
                        required
                    />
                </form-group>
                <form-group class="w-full" label="প্রশ্নের ভাষা">
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
                <form-group class="w-full" label="সময়">
                    <div class="grid grid-cols-2 gap-3">
                        <Input
                            type="number"
                            class="block w-full"
                            v-model="form.hour"
                            required
                        />
                        <Input
                            type="number"
                            class="block w-full"
                            v-model="form.minute"
                            required
                        />
                    </div>
                </form-group>
            </div>

            <div class="grid gap-4">
                <Input
                    type="text"
                    class="block w-full text-center"
                    v-model="form.top_text"
                    required
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
                        class="block h-20 w-full text-sm font-bold md:h-14 md:text-lg"
                        v-model="question.title"
                        @keyup="resizeTextarea"
                        @focus="resizeTextarea"
                        placeholder="প্রশ্ন/প্রশ্নের শিরনাম (Bold Font)"
                    ></Textarea>
                    <Textarea
                        class="block h-14 w-full text-sm md:text-lg"
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
import { TrashIcon } from "@heroicons/vue/outline";

export default {
    components: {
        ValidationErrors,
        Button,
        Input,
        Select,
        FormGroup,
        Textarea,
        TrashIcon,
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
        this.classList = this.data.classes;
        this.languageList = this.data.languages;

        if (this.moduleAction == "store") {
            this.addQuestionSlot();
        }
    },
    data() {
        return {
            form: this.$inertia.form({
                name: this.data.exam.name,
                session: this.data.exam.session || "৪৩-৪৪",
                class_id: this.data.exam.class_id,
                subject_code: this.data.exam.subject_code,
                top_text: this.data.exam.top_text,
                bottom_text: this.data.exam.bottom_text,
                hour: this.data.exam.hour,
                minute: this.data.exam.minute,
                mark: this.data.exam.mark,
                language_type: this.data.exam.language_type || 1,
                questions: [],
            }),
            classList: [],
            subjectList: [],
            languageList: [],
        };
    },
    methods: {
        submit() {
            if (this.moduleAction == "store") {
                return this.form.post(this.route("exams.store"));
            }
            if (this.moduleAction == "update") {
                return this.form.put(
                    this.route("exams.update", this.data.exam.id)
                );
            }
        },
        resizeTextarea(e) {
            let area = e.target;
            area.style.overflow = "hidden";
            area.style.height = area.scrollHeight + "px";
        },
        changeClass() {
            let selectedClass = Object.values(this.classList).find(
                (classes) => classes.id == this.form.class_id
            );

            this.subjectList = selectedClass ? selectedClass.subjects : [];
        },
        questionFormated(question = {}) {
            return {
                id: question.id || "",
                exam_id: question.exam_id || "",
                title: question.title || "",
                body: question.body || "",
                mark: question.mark || "",
            };
        },
        addQuestionSlot() {
            this.form.questions.push(this.questionFormated());
        },
        removeQuestionSlot(index) {
            if (!confirm("আপনি কি প্রশ্ন মুছে ফেলতে চান?")) {
                return;
            }

            this.form.questions.splice(index, 1);

            // this.form.questions.length == 0 && this.addQuestionSlot();
        },
    },
};
</script>
