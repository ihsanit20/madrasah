<template>
    <div class="w-full max-w-2xl rounded border bg-white p-4 shadow">
        <validation-errors class="mb-4" />

        <letter-head />

        <form @submit.prevent="submit" class="mt-6">
            <div class="grid gap-4 md:grid-cols-2">
                <form-group class="" label="জমার রশিদ ধরণ">
                    <Select
                        @change="setFeeForAdmission"
                        class="block w-full"
                        v-model="form.period"
                        required
                    >
                        <option value="">-- নির্বাচন করুন --</option>
                        <option :value="1">ভর্তিকালীন প্রদেয়</option>
                        <option :value="2">মাসিক প্রদেয়</option>
                    </Select>
                </form-group>
                <form-group class="" label="তারিখ">
                    <Select
                        disabled="true"
                        class="block w-full"
                        v-model="form.date"
                    >
                        <option :value="data.date.value">
                            {{ data.date.label }}
                        </option>
                    </Select>
                </form-group>
                <form-group
                    v-if="form.period"
                    class="col-start-1"
                    label="শিক্ষার্থীর নাম"
                >
                    <Select
                        required
                        class="block w-full"
                        v-model="form.admission_id"
                        @change="setFeeForAdmission"
                    >
                        <option value="">-- নির্বাচন করুন --</option>
                        <option
                            v-for="(student, index) in data.students"
                            :key="index"
                            :value="student.currentAdmissionId"
                        >
                            {{ student.name }}
                        </option>
                    </Select>
                </form-group>
                <form-group v-if="form.period" class="" label="Reg No.">
                    <Select
                        required
                        class="block w-full"
                        v-model="form.admission_id"
                        @change="setFeeForAdmission"
                    >
                        <option value="">-- নির্বাচন করুন --</option>
                        <option
                            v-for="(student, index) in data.students"
                            :key="index"
                            :value="student.currentAdmissionId"
                        >
                            {{ student.registration }}
                        </option>
                    </Select>
                </form-group>
                <form-group v-if="form.period" class="" label="ক্লাস/বিভাগ">
                    <Select
                        required
                        class="block w-full"
                        v-model="form.admission_id"
                        @change="setFeeForAdmission"
                    >
                        <option value="">-- নির্বাচন করুন --</option>
                        <option
                            v-for="(student, index) in data.students"
                            :key="index"
                            :value="student.currentAdmissionId"
                        >
                            {{ student.currentClassName }}
                        </option>
                    </Select>
                </form-group>
                <form-group v-if="form.period" class="" label="রোল">
                    <Select
                        required
                        class="block w-full"
                        v-model="form.admission_id"
                        @change="setFeeForAdmission"
                    >
                        <option value="">-- নির্বাচন করুন --</option>
                        <option
                            v-for="(student, index) in data.students"
                            :key="index"
                            :value="student.currentAdmissionId"
                        >
                            {{ student.currentClassRoll }}
                        </option>
                    </Select>
                </form-group>

                <div
                    v-if="form.period && form.admission_id"
                    class="col-span-full border"
                >
                    <div
                        v-for="(fee, index) in form.fees"
                        :key="index"
                        class="flex items-center justify-between border-b"
                    >
                        <div class="shrink grow p-3">
                            {{ fee.title }}
                        </div>
                        <div
                            class="w-24 shrink-0 grow-0 border-l p-3 text-right"
                        >
                            {{ fee.amount }}
                        </div>
                    </div>
                    <div class="flex items-center justify-between border-b">
                        <div class="shrink grow p-3 text-right">মোট</div>
                        <div
                            class="w-24 shrink-0 grow-0 border-l p-3 text-right"
                        >
                            {{ form.total }}
                        </div>
                    </div>
                    <div class="flex items-center justify-between border-b">
                        <div class="shrink grow p-3 text-right">জমা</div>
                        <div class="w-24 shrink-0 grow-0 border-l">
                            <input
                                type="number"
                                v-model="form.paid"
                                class="block w-full border-0 p-3 text-right"
                                required
                            />
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="shrink grow p-3 text-right">বাকি</div>
                        <div
                            class="w-24 shrink-0 grow-0 border-l p-3 text-right"
                        >
                            {{ form.total - form.paid }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4 flex items-center justify-end">
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

export default {
    components: {
        ValidationErrors,
        Button,
        Input,
        Select,
        FormGroup,
        Textarea,
        LetterHead,
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
    created() {
        this.form.date = this.data.date.value;
    },
    data() {
        return {
            form: this.$inertia.form({
                date: "",
                admission_id: "",
                period: "",
                fees: [],
                total: 0,
                paid: "",
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
