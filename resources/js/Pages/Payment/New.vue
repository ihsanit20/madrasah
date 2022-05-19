<template>
    <Head title="নতুন রশিদ" />

    <app-layout>
        <div class="w-full max-w-lg rounded border bg-white p-4 shadow">
            <h2
                class="mb-2 text-center text-2xl font-bold text-sky-600 print:text-black"
            >
                টাকা জমার রশিদ
            </h2>
            <form @submit.prevent="submit" class="">
                <div class="grid gap-4 md:grid-cols-3">
                    <form-group class="col-span-2" label="ক্লাস">
                        <Select
                            class="block w-full"
                            v-model="classId"
                            @change="classOrRollHandler"
                            required
                        >
                            <option value="">-- নির্বাচন করুন --</option>
                            <option
                                v-for="classes in data.classes"
                                :key="classes.id"
                                :value="classes.id"
                            >
                                {{ classes.name }}
                            </option>
                        </Select>
                    </form-group>
                    <form-group class="" label="রোল">
                        <Input
                            class="block w-full"
                            type="Number"
                            v-model="roll"
                            @input="classOrRollHandler"
                            required
                        />
                    </form-group>
                    <form-group class="col-span-2" label="শিক্ষার্থীর নাম">
                        <Input
                            class="block w-full"
                            type="text"
                            disabled
                            v-model="studentName"
                        />
                    </form-group>
                    <form-group class="" label="রেজি. নং">
                        <Input
                            class="block w-full"
                            type="Number"
                            v-model="registration"
                            @input="registrationHandler"
                            required
                        />
                    </form-group>
                    <form-group
                        class="col-span-full"
                        label="বাবদ নির্বাচন করুন"
                    >
                        <Select
                            class="block w-full"
                            v-model="form.purpose"
                            required
                        >
                            <option value="">-- নির্বাচন করুন --</option>
                            <option
                                v-for="(purpose, index) in data.purposes"
                                :key="index"
                                :value="index"
                                :disabled="paidPurpose.includes(Number(index))"
                                v-html="
                                    (paidPurpose.includes(Number(index))
                                        ? '&#x2713; '
                                        : '') + purpose.title
                                "
                            ></option>
                        </Select>
                    </form-group>
                </div>
                <div class="mt-4 flex items-center justify-end">
                    <Button> পরবর্তী ধাপ &#8594; </Button>
                </div>
            </form>
        </div>
        {{ paidPurpose }}
    </app-layout>
</template>

<script>
import { Head } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/App.vue";
import FormComponent from "./Form.vue";
import FormGroup from "@/Components/FormGroup.vue";
import InlineData from "@/Components/InlineData.vue";
import Select from "@/Components/Select.vue";
import Input from "@/Components/Input.vue";
import Button from "@/Components/Button.vue";

export default {
    components: {
        Head,
        AppLayout,
        FormComponent,
        FormGroup,
        InlineData,
        Select,
        Input,
        Button,
    },
    props: {
        data: {
            type: Object,
            default: {},
        },
    },
    created() {
        this.registration = this.data.registration;
        this.registrationHandler();
    },
    data() {
        return {
            form: this.$inertia.form({
                admission: "",
                purpose: "",
            }),
            classId: "",
            roll: "",
            studentName: "",
            registration: "",
            paidPurpose: [],
        };
    },
    methods: {
        submit() {
            if (this.form.admission && this.form.purpose) {
                return this.form.get(this.route("payments.create"));
            }
        },
        registrationHandler() {
            let selectedAdmission = Object.values(this.data.admissions).filter(
                (admission) => {
                    return admission.student.registration == this.registration;
                }
            )[0];

            if (selectedAdmission) {
                this.roll = selectedAdmission.roll;
                this.classId = selectedAdmission.classId;
                this.form.admission = selectedAdmission.id;
                this.studentName = selectedAdmission.studentName;
                this.paidPurpose = selectedAdmission.student.paidPurpose;
            } else {
                this.roll = "";
                this.classId = "";
                this.form.admission = "";
                this.studentName = "";
                this.paidPurpose = "";
            }

            this.form.purpose = "";
        },
        classOrRollHandler() {
            let selectedAdmission = null;

            if (this.classId && this.roll) {
                selectedAdmission = Object.values(this.data.admissions).filter(
                    (admission) => {
                        return (
                            admission.classId == this.classId &&
                            admission.roll == this.roll
                        );
                    }
                )[0];
            }

            if (selectedAdmission) {
                this.registration = selectedAdmission.student.registration;
                this.form.admission = selectedAdmission.id;
                this.studentName = selectedAdmission.studentName;
                this.paidPurpose = selectedAdmission.student.paidPurpose;
            } else {
                this.registration = "";
                this.form.admission = "";
                this.studentName = "";
                this.paidPurpose = "";
            }

            this.form.purpose = "";
        },
    },
};
</script>
