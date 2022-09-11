<template>
    <div
        class="w-full max-w-2xl rounded border bg-white p-4 shadow print:border-0 print:shadow-none"
    >
        <validation-errors class="mb-4" />

        <div class="mb-2 flex flex-col items-center justify-center">
            <h3 class="text-xl font-bold md:text-2xl">
                {{ data.result.exam.name }}
                {{ $e2bnumber(data.result.exam.session) }}
            </h3>
            <h2 class="text-lg font-semibold md:text-xl">
                শ্রেণী: {{ data.result.class.name }}
            </h2>
            <h2 class="text-base md:text-lg">
                বিষয়: {{ data.result.subject.name }}
            </h2>
            <h2 class="text-sm md:text-base">
                কিতাব: {{ data.result.subject.book }}
            </h2>
        </div>

        <form @submit.prevent="submit" class="">
            <div class="grid gap-4">
                <table
                    class="table-fixed divide-y divide-gray-200 dark:divide-gray-700 print:divide-black"
                >
                    <thead class="bg-white">
                        <tr>
                            <th class="border p-3">রোল</th>
                            <th class="border p-3">শিক্ষার্থী</th>
                            <th class="border p-3">মৌখিক</th>
                            <th class="border p-3">লিখিত</th>
                        </tr>
                    </thead>
                    <tbody
                        class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800 print:divide-black"
                    >
                        <tr
                            v-for="(student, index) in data.students"
                            :key="index"
                            class="hover:bg-gray-100 dark:hover:bg-gray-700"
                        >
                            <td class="border p-3 text-center">
                                {{ $e2bnumber(student.roll) }}
                            </td>
                            <td class="border p-3 text-left">
                                {{ student.name }}
                            </td>
                            <td class="border p-3 text-center">
                                <Input
                                    type="number"
                                    class="w-24 text-center print:hidden"
                                    v-model="
                                        data.result.marks.find(
                                            (mark) =>
                                                Number(mark.student_id) ===
                                                student.id
                                        ).speaking
                                    "
                                />
                            </td>
                            <td class="border p-3 text-center">
                                <Input
                                    type="number"
                                    class="w-24 text-center print:hidden"
                                    v-model="
                                        data.result.marks.find(
                                            (mark) =>
                                                Number(mark.student_id) ===
                                                student.id
                                        ).writing
                                    "
                                />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <hr class="my-4 w-full print:hidden" />

            <div class="flex items-center justify-end print:hidden">
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
import FormGroup from "@/Components/FormGroup.vue";

export default {
    components: {
        ValidationErrors,
        Button,
        Input,
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
                result: this.data.result,
            }),
        };
    },
    methods: {
        submit() {
            if (this.moduleAction == "store") {
                return this.form.post(
                    this.route("results.store", [
                        this.data.result.exam_id,
                        this.data.result.class_id,
                        this.data.result.subject_code,
                    ])
                );
            }
        },
    },
};
</script>
