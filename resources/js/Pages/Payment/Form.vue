<template>
    <div class="w-full max-w-2xl rounded border bg-white p-4 shadow">
        <validation-errors />

        <h2
            class="mb-2 text-center text-2xl font-bold text-sky-600 print:text-black"
        >
            টাকা জমার রশিদ
        </h2>

        <div class="grid gap-2 md:grid-cols-3">
            <div class="col-span-2">
                <inline-data title="তারিখ:" :value="$e2bnumber(data.date)" />
            </div>
            <div class="col-span-2">
                <inline-data
                    title="শ্রেণী:"
                    :value="data.admission.className"
                />
            </div>
            <div>
                <inline-data
                    title="রোল:"
                    :value="$e2bnumber(data.admission.roll)"
                />
            </div>
            <div class="col-span-2">
                <inline-data
                    title="শিক্ষার্থীর নাম:"
                    :value="data.admission.student.name"
                />
            </div>
            <div>
                <inline-data
                    title="রেজি. নং:"
                    :value="$e2bnumber(data.admission.student.registration)"
                />
            </div>
        </div>

        <form @submit.prevent="submit">
            <div class="mt-4 flex items-center justify-between">
                <Link
                    :href="route('payments.create')"
                    class="rounded-md border border-orange-600 px-4 py-2 font-semibold text-orange-600 hover:bg-orange-700 hover:text-white"
                >
                    &#8592; পূর্ববর্তী ধাপ
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
import ValidationErrors from "@/Components/ValidationErrors.vue";
import Button from "@/Components/Button.vue";
import Input from "@/Components/Input.vue";
import Select from "@/Components/Select.vue";
import FormGroup from "@/Components/FormGroup.vue";
import Textarea from "@/Components/Textarea.vue";
import LetterHead from "@/Templete/LetterHead.vue";
import { Link } from "@inertiajs/inertia-vue3";
import InlineData from "@/Components/InlineData.vue";

export default {
    components: {
        ValidationErrors,
        Button,
        Input,
        Select,
        FormGroup,
        Textarea,
        LetterHead,
        Link,
        InlineData,
    },
    props: {
        moduleAction: String,
        buttonValue: {
            type: String,
            default: "সংরক্ষণ করুণ",
        },
        data: {
            type: Object,
            default: {},
        },
    },
    data() {
        return {
            form: this.$inertia.form({
                admission_id: "",
            }),
        };
    },
    methods: {
        submit() {
            if (this.moduleAction == "store") {
                return this.form.post(this.route("payments.store"));
            }
            if (this.moduleAction == "update") {
                return this.form.put(
                    this.route("payments.update", this.data.payment.id)
                );
            }
        },
        setFeeForAdmission() {
            this.form.total = 0;
            this.form.fees = [];

            if (!this.form.admission_id || !this.form.period) {
                return;
            }

            let selectedStudent = Object.values(this.data.students).filter(
                (student) => {
                    return student.currentAdmissionId == this.form.admission_id;
                }
            )[0];

            selectedStudent.currentAdmission.payableFees.forEach((fee) => {
                if (fee.period == this.form.period) {
                    this.form.fees.push({
                        title: fee.feeName,
                        amount: fee.payableAmount,
                    });

                    this.form.total += fee.payableAmount;
                }
            });
        },
    },
};
</script>
