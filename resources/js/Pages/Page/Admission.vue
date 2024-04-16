<template>
    <Head title="ভর্তি আবেদন" />

    <AppLayout>
        <div class="w-full max-w-lg rounded border bg-white p-4 shadow mx-auto mt-5">
            <h2
                class="mb-2 text-center text-2xl font-bold text-brand-600 print:text-black"
            >
                ভর্তি আবেদন
            </h2>
            <div class="flex items-center justify-center gap-8">
                <label>
                    <Input
                        type="radio"
                        name="admission_type"
                        :checked="form.type === 'new'"
                        @click="form.type = 'new'"
                    />
                    নতুন ভর্তি
                </label>
                <label>
                    <Input
                        type="radio"
                        name="admission_type"
                        :checked="form.type === 'old'"
                        @click="form.type = 'old'"
                    />
                    পুরাতন ভর্তি
                </label>
            </div>
            <form @submit.prevent="submit" class="">
                <div
                    v-if="form.type === 'old'"
                    class="grid gap-4 md:grid-cols-3"
                >
                    <FormGroup class="col-span-2" label="ক্লাস">
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
                    </FormGroup>
                    <FormGroup class="" label="রোল">
                        <Input
                            class="block w-full"
                            type="Number"
                            v-model="roll"
                            @input="classOrRollHandler"
                            required
                        />
                    </FormGroup>
                    <FormGroup class="col-span-2" label="শিক্ষার্থীর নাম">
                        <Input
                            class="block w-full"
                            type="text"
                            disabled
                            v-model="studentName"
                        />
                    </FormGroup>
                    <FormGroup class="" label="রেজি. নং">
                        <Input
                            class="block w-full"
                            type="Number"
                            v-model="registration"
                            @input="registrationHandler"
                            required
                        />
                    </FormGroup>
                </div>

                <div class="mt-4 flex items-center justify-end">
                    <Button v-if="isValided" type="submit">
                        পরবর্তী ধাপ &#8594;
                    </Button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>

<script>
import { Head } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/Master.vue";
import FormGroup from "@/Components/FormGroup.vue";
import Select from "@/Components/Select.vue";
import Input from "@/Components/Input.vue";
import Button from "@/Components/Button.vue";
import Label from "@/Components/Label.vue";

export default {
    components: {
        Head,
        AppLayout,
        FormGroup,
        Select,
        Input,
        Button,
        Label,
    },
    props: {
        data: {
            type: Object,
            default: {},
        },
    },
    computed: {
        isValided() {
            return Boolean(
                this.form.type === "new" ||
                    (this.form.type === "old" && this.form.student)
            );
        },
    },
    created() {
        this.registrationHandler();
    },
    data() {
        return {
            form: this.$inertia.form({
                student: "",
                type: "",
            }),
            classId: "",
            roll: "",
            studentName: "",
            registration: "",
        };
    },
    methods: {
        submit() {
            if (this.form.type === "new") {
                delete this.form.student;
            }

            if (this.isValided) {
                return this.form.get(this.route("page.admission-form"));
            }
        },
        registrationHandler() {
            this.resetDuringRegistrationSelect();
            this.resetCommonData();

            let selectedAdmission = Object.values(this.data.admissions).filter(
                (admission) => {
                    return admission.student.registration == this.registration;
                }
            )[0];

            if (selectedAdmission) {
                this.setCommonData(selectedAdmission);
                this.setDuringRegistrationSelect(selectedAdmission);
            }
        },
        classOrRollHandler() {
            this.resetDuringclassOrRollSelect();
            this.resetCommonData();

            let selectedAdmission = null;

            if (this.classId && this.roll) {
                selectedAdmission = Object.values(this.data.admissions).filter(
                    (admission) => {
                        return (
                            admission.class_id == this.classId &&
                            admission.roll == this.roll
                        );
                    }
                )[0];
            }

            if (selectedAdmission) {
                this.setCommonData(selectedAdmission);
                this.setDuringclassOrRollSelect(selectedAdmission);
            }
        },
        setCommonData(selectedAdmission) {
            this.form.admission = selectedAdmission.id;
            this.studentName = selectedAdmission.student.name;
            this.form.student = selectedAdmission.student.id;
        },
        setDuringRegistrationSelect(selectedAdmission) {
            this.roll = selectedAdmission.roll;
            this.classId = selectedAdmission.class_id;
        },
        setDuringclassOrRollSelect(selectedAdmission) {
            this.registration = selectedAdmission.student.registration;
        },
        resetCommonData() {
            this.form.admission = "";
            this.studentName = "";
            this.form.student = "";
        },
        resetDuringRegistrationSelect() {
            this.roll = "";
            this.classId = "";
        },
        resetDuringclassOrRollSelect() {
            this.registration = "";
        },
    },
};
</script>
