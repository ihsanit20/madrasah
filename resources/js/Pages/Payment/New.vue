<template>
    <Head title="নতুন রশিদ" />

    <app-layout pageTitle="নতুন রশিদ">
        <div class="w-full max-w-2xl rounded border bg-white p-4 shadow">
            <form @submit.prevent="submit" class="mt-6">
                <div class="grid gap-4 md:grid-cols-2">
                    <form-group class="" label="জমার রশিদ ধরণ">
                        <Select class="block w-full" v-model="period" required>
                            <option value="">-- নির্বাচন করুন --</option>
                            <option :value="1">ভর্তিকালীন প্রদেয়</option>
                            <option :value="2">মাসিক প্রদেয়</option>
                        </Select>
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
                    <form-group class="col-start-1" label="ক্লাস">
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
                </div>
                <div class="mt-4 flex items-center justify-end">
                    <Button> পরবর্তী ধাপ &#8594; </Button>
                </div>
            </form>
        </div>
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
    data() {
        return {
            period: "",
            classId: "",
            roll: "",
            registration: "",
            admissionId: "",
        };
    },
    methods: {
        submit() {
            return this.admission;
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
                this.admissionId = selectedAdmission.id;
            } else {
                this.roll = "";
                this.classId = "";
                this.admissionId = "";
            }
        },
        classOrRollHandler() {
            if (this.classId && this.roll) {
                let selectedAdmission = Object.values(
                    this.data.admissions
                ).filter((admission) => {
                    return (
                        admission.classId == this.classId &&
                        admission.roll == this.roll
                    );
                })[0];

                if (selectedAdmission) {
                    this.registration = selectedAdmission.student.registration;
                    this.admissionId = selectedAdmission.id;
                } else {
                    this.registration = "";
                    this.admissionId = "";
                }
            } else {
                this.registration = "";
                this.admissionId = "";
            }
        },
    },
};
</script>
