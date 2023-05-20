<template>
    <div class="w-full max-w-4xl rounded border bg-white p-4 shadow">
        <validation-errors class="mb-4" />

        <form @submit.prevent="submit" class="">
            <form-heading class="mb-2">ব্যক্তিগত তথ্য</form-heading>
            <div class="grid gap-x-2 gap-y-4 md:grid-cols-2">
                <form-group class="w-full" label="নাম">
                    <Input
                        type="text"
                        class="block w-full"
                        v-model="form.name"
                        required
                    />
                </form-group>
                <form-group class="w-full" label="জন্ম তারিখ">
                    <Input
                        type="date"
                        class="block w-full"
                        v-model="form.date_of_birth"
                        required
                    />
                </form-group>
                <form-group class="w-full" label="ফোন">
                    <Input
                        type="text"
                        class="block w-full"
                        v-model="form.phone"
                        required
                    />
                </form-group>
                <form-group class="w-full" label="বিকল্প ফোন">
                    <Input
                        type="text"
                        class="block w-full"
                        v-model="form.alternative_phone"
                    />
                </form-group>
                <form-group class="w-full" label="NID / জন্ম নিবন্ধন নাম্বার">
                    <Input
                        type="number"
                        class="block w-full"
                        v-model="form.nid"
                    />
                </form-group>
                <div class="flex gap-2">
                    <form-group class="flex-1" label="লিঙ্গ">
                        <Select
                            class="block w-full"
                            v-model="form.gender"
                            required
                        >
                            <option value="">-- নির্বাচন করুন --</option>
                            <option :value="1">ছেলে</option>
                            <option :value="2">মেয়ে</option>
                        </Select>
                    </form-group>
                    <form-group class="flex-1" label="রক্তের গ্রুপ">
                        <Select class="block w-full" v-model="form.blood_group">
                            <option value="">-- Select --</option>
                            <option
                                v-for="(bloodGroup, index) in data.bloodGroups"
                                :key="index"
                                :value="index"
                            >
                                {{ bloodGroup }}
                            </option>
                        </Select>
                    </form-group>
                </div>
            </div>

            <form-heading class="mt-8">পারিবারিক তথ্য</form-heading>

            <div class="grid gap-x-2 gap-y-4 md:grid-cols-2">
                <form-group class="w-full" label="পিতার নাম">
                    <Input
                        type="text"
                        class="block w-full"
                        v-model="form.fathers_info.name"
                        required
                    />
                </form-group>
                <form-group class="w-full" label="ফোন">
                    <Input
                        type="number"
                        class="block w-full"
                        v-model="form.fathers_info.phone"
                    />
                </form-group>
                <form-group class="w-full" label="মাতার নাম">
                    <Input
                        type="text"
                        class="block w-full"
                        v-model="form.mothers_info.name"
                        required
                    />
                </form-group>
                <form-group class="w-full" label="ফোন">
                    <Input
                        type="number"
                        class="block w-full"
                        v-model="form.mothers_info.phone"
                    />
                </form-group>
            </div>

            <form-heading class="mt-8">রেফারেন্স তথ্য</form-heading>

            <div class="grid gap-x-2 gap-y-4 md:grid-cols-4">
                <form-group class="w-full md:col-span-2" label="নাম">
                    <Input
                        type="text"
                        class="block w-full"
                        v-model="form.reference_info.name"
                        required
                    />
                </form-group>
                <form-group class="w-full" label="ফোন">
                    <Input
                        type="number"
                        class="block w-full"
                        v-model="form.reference_info.phone"
                    />
                </form-group>
                <form-group class="w-full" label="সম্পর্ক">
                    <Input
                        type="text"
                        class="block w-full"
                        v-model="form.reference_info.relation"
                    />
                </form-group>
                <form-group class="col-span-full w-full" label="ঠিকানা">
                    <Input
                        type="text"
                        class="block w-full"
                        v-model="form.reference_info.address"
                    />
                </form-group>
            </div>

            <form-heading class="mt-8">বর্তমান ঠিকানা</form-heading>

            <div class="grid gap-x-2 gap-y-4 md:grid-cols-3">
                <form-group label="বিভাগ">
                    <Select
                        class="block w-full"
                        v-model="form.present_address_info.division"
                        @change="presentAddressDivisionSelectHandler"
                        required
                    >
                        <option value="">-- নির্বাচন করুন --</option>
                        <option
                            v-for="division in data.divisions"
                            :key="division.id"
                            :value="division.id"
                        >
                            {{ division.name }}
                        </option>
                    </Select>
                </form-group>
                <form-group label="জেলা">
                    <Select
                        class="block w-full"
                        v-model="form.present_address_info.district"
                        @change="presentAddressDistrictSelectHandler"
                        required
                    >
                        <option value="">-- নির্বাচন করুন --</option>
                        <option
                            v-for="district in present_address.districts"
                            :key="district.id"
                            :value="district.id"
                        >
                            {{ district.name }}
                        </option>
                    </Select>
                </form-group>
                <form-group label="উপজেলা/থানা">
                    <Select
                        class="block w-full"
                        v-model="form.present_address_info.area"
                    >
                        <option value="">-- নির্বাচন করুন --</option>
                        <option
                            v-for="area in present_address.areas"
                            :key="area.id"
                            :value="area.id"
                            required
                        >
                            {{ area.name }}
                        </option>
                    </Select>
                </form-group>
                <form-group label="পোস্ট অফিস" class="col-span-1">
                    <Input
                        type="text"
                        class="block w-full"
                        v-model="form.present_address_info.postoffice"
                        required
                    />
                </form-group>
                <form-group
                    label="বাড়ি নং, রোড নং, গ্রাম/মহল্লা"
                    class="col-span-2"
                >
                    <Input
                        type="text"
                        class="block w-full"
                        v-model="form.present_address_info.address"
                        required
                    />
                </form-group>
            </div>

            <form-heading class="mt-8">স্থায়ী ঠিকানা</form-heading>

            <div
                class="col-span-full flex items-center justify-center gap-3 md:justify-start"
            >
                <label class="flex items-center justify-center gap-1">
                    <Input
                        @change="sameAsPresentHandler"
                        type="checkbox"
                        :checked="form.is_same_address"
                    />
                    <span>বর্তমান ও স্থায়ী ঠিকানা একই</span>
                </label>
            </div>
            <div
                v-if="!form.is_same_address"
                class="grid gap-x-2 gap-y-4 md:grid-cols-3"
            >
                <form-group label="বিভাগ">
                    <Select
                        class="block w-full"
                        v-model="form.permanent_address_info.division"
                        @change="permanentAddressDivisionSelectHandler"
                        required
                    >
                        <option value="">-- নির্বাচন করুন --</option>
                        <option
                            v-for="division in permanent_address.divisions"
                            :key="division.id"
                            :value="division.id"
                        >
                            {{ division.name }}
                        </option>
                    </Select>
                </form-group>
                <form-group label="জেলা">
                    <Select
                        class="block w-full"
                        v-model="form.permanent_address_info.district"
                        @change="permanentAddressDistrictSelectHandler"
                        required
                    >
                        <option value="">-- নির্বাচন করুন --</option>
                        <option
                            v-for="district in permanent_address.districts"
                            :key="district.id"
                            :value="district.id"
                        >
                            {{ district.name }}
                        </option>
                    </Select>
                </form-group>
                <form-group label="উপজেলা/থানা">
                    <Select
                        class="block w-full"
                        v-model="form.permanent_address_info.area"
                        required
                    >
                        <option value="">-- নির্বাচন করুন --</option>
                        <option
                            v-for="area in permanent_address.areas"
                            :key="area.id"
                            :value="area.id"
                        >
                            {{ area.name }}
                        </option>
                    </Select>
                </form-group>
                <form-group label="পোস্ট অফিস" class="col-span-1">
                    <Input
                        type="text"
                        class="block w-full"
                        v-model="form.permanent_address_info.postoffice"
                        required
                    />
                </form-group>
                <form-group
                    label="বাড়ি নং, রোড নং, গ্রাম/মহল্লা"
                    class="col-span-2"
                >
                    <Input
                        type="text"
                        class="block w-full"
                        v-model="form.permanent_address_info.address"
                        required
                    />
                </form-group>
            </div>

            <form-heading class="mt-8">শিক্ষাগত যোগ্যতা</form-heading>

            <form-slot-group
                :collections="form.educational_qualifications"
                :addSlotMethod="addEducationalQualificationSlot"
            >
                <template #default="{ item: educational_qualification }">
                    <form-group
                        label="পরিক্ষার নাম"
                        class="w-full md:w-2/12"
                    >
                        <Input
                            type="text"
                            class="block w-full"
                            v-model="educational_qualification.exam_name"
                            required
                        />
                    </form-group>
                    <form-group
                        label="সাল"
                        class="w-full md:w-1/12"
                    >
                        <Input
                            type="text"
                            class="block w-full text-center"
                            v-model="educational_qualification.year"
                        />
                    </form-group>
                    <form-group
                        label="প্রতিষ্ঠানের নাম"
                        class="w-full md:w-4/12"
                    >
                        <Input
                            type="text"
                            class="block w-full"
                            v-model="educational_qualification.institute_name"
                        />
                    </form-group>
                    <form-group
                        label="বোর্ড"
                        class="w-full md:w-2/12"
                    >
                        <Input
                            type="text"
                            class="block w-full"
                            v-model="educational_qualification.board"
                        />
                    </form-group>
                    <form-group
                        label="ফলাফল"
                        class="w-full md:w-2/12"
                    >
                        <Input
                            type="text"
                            class="block w-full text-center"
                            v-model="educational_qualification.result"
                        />
                    </form-group>
                </template>
            </form-slot-group>

            <form-heading class="mt-8">পূর্বের অভিজ্ঞতা</form-heading>

            <div class="grid gap-x-2 gap-y-4 md:grid-cols-4">
                <form-group class="w-full md:col-span-2" label="প্রতিষ্ঠানের নাম">
                    <Input
                        type="text"
                        class="block w-full"
                        v-model="form.previous_experience.institute_name"
                    />
                </form-group>
                <form-group class="w-full" label="পদবি">
                    <Input
                        type="text"
                        class="block w-full"
                        v-model="form.previous_experience.designation"
                    />
                </form-group>
                <form-group class="w-full" label="সময়কাল">
                    <Input
                        type="text"
                        class="block w-full"
                        v-model="form.previous_experience.period"
                    />
                </form-group>
            </div>

            <form-heading class="mt-8">প্রত্যাশা</form-heading>

            <div class="grid gap-x-2 gap-y-4 md:grid-cols-2">
                <form-group class="w-full" label="আপনি অত্র প্রতিষ্ঠানে কোন পদে আবেদন করছেন?">
                    <Select
                        class="block w-full"
                        v-model="form.designation_id"
                        required
                    >
                        <option value="">-- নির্বাচন করুন --</option>
                        <option
                            v-for="designation in data.designations"
                            :key="designation.id"
                            :value="designation.id"
                        >
                            {{ designation.name }}
                        </option>
                    </Select>
                </form-group>
                <form-group class="w-full" label="আপনি মাসিক কি পরিমাণ হাদিয়া প্রত্যাশা করেন?">
                    <Input
                        type="text"
                        class="block w-full"
                        v-model="form.expected_salary"
                    />
                </form-group>
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
import FormHeading from "@/Components/FormHeading.vue";
import FormGroup from "@/Components/FormGroup.vue";
import Textarea from "@/Components/Textarea.vue";
import FormSlotGroup from '@/Components/FormSlotGroup.vue';

export default {
    components: {
        ValidationErrors,
        Button,
        Input,
        Select,
        FormHeading,
        FormGroup,
        Textarea,
        FormSlotGroup,
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
        this.present_address.divisions = this.data.divisions;
        this.present_address.districts = this.data.districts;
        this.present_address.areas = this.data.areas;

        this.permanent_address.divisions = this.data.divisions;
        this.permanent_address.districts = this.data.districts;
        this.permanent_address.areas = this.data.areas;

        // if (this.moduleAction == "update") {
        //     this.form.father_info = this.data.staff.fatherInfo;
        //     this.form.mother_info = this.data.staff.motherInfo;
        //     this.form.guardian_info = this.data.staff.guardianInfo;

        //     this.form.present_address.postoffice =
        //         this.data.staff.presentAddress.postoffice;
        //     this.form.present_address.address =
        //         this.data.staff.presentAddress.value;
        //     this.form.present_address.area =
        //         this.data.staff.presentAddress.areaId;
        //     this.form.present_address.district =
        //         this.data.staff.presentAddress.area.districtId;
        //     this.form.present_address.division =
        //         this.data.staff.presentAddress.area.district.divisionId;

        //     this.form.permanent_address.postoffice =
        //         this.data.staff.permanentAddress.postoffice;
        //     this.form.permanent_address.address =
        //         this.data.staff.permanentAddress.value;
        //     this.form.permanent_address.area =
        //         this.data.staff.permanentAddress.areaId;
        //     this.form.permanent_address.district =
        //         this.data.staff.permanentAddress.area.districtId;
        //     this.form.permanent_address.division =
        //         this.data.staff.permanentAddress.area.district.divisionId;
        // }
    },
    data() {
        return {            
            present_address: {
                divisions: "",
                districts: "",
                postoffice: "",
                areas: "",
            },
            permanent_address: {
                divisions: "",
                districts: "",
                postoffice: "",
                areas: "",
            },
            form: this.$inertia.form({
                name: this.data.staff.name,
                date_of_birth: this.data.staff.date_of_birth,
                phone: this.data.staff.phone,
                alternative_phone: this.data.staff.alternative_phone,
                nid: this.data.staff.nid,
                gender: this.data.staff.gender,
                blood_group: this.data.staff.blood_group,
                fathers_info: this.data.staff.fathers_info,
                mothers_info: this.data.staff.mothers_info,
                reference_info: this.data.staff.reference_info,
                is_same_address: this.data.staff.is_same_address,
                present_address_info: this.data.staff.present_address_info,
                permanent_address_info: this.data.staff.permanent_address_info,
                educational_qualifications: this.data.staff.educational_qualifications,
                previous_experience: this.data.staff.previous_experience,
                designation_id: this.data.staff.designation_id || "",
                expected_salary: this.data.staff.expected_salary,
            }),
        };
    },
    methods: {
        submit() {
            if (this.moduleAction == "store") {
                return this.form.post(this.route("staff-form.store"));
            }
            if (this.moduleAction == "update") {
                return this.form.put(
                    this.route("staff-form.update", this.data.staff.id)
                );
            }
        },
        sameAsPresentHandler(event) {
            this.form.is_same_address = event.target.checked;
        },
        presentAddressDivisionSelectHandler() {
            if (this.form.present_address_info.division) {
                this.present_address.districts = Object.values(
                    this.data.districts
                ).filter(
                    (district) =>
                        district.divisionId ==
                        this.form.present_address_info.division
                );
            } else {
                this.present_address.districts = this.data.districts;
            }

            this.form.present_address_info.district = "";

            this.presentAddressDistrictSelectHandler();
        },
        presentAddressDistrictSelectHandler() {
            if (this.form.present_address_info.district) {
                this.present_address.areas = Object.values(
                    this.data.areas
                ).filter(
                    (area) =>
                        area.districtId == this.form.present_address_info.district
                );
            } else {
                this.present_address.areas = this.data.areas;
            }

            this.form.present_address_info.area = "";
        },
        permanentAddressDivisionSelectHandler() {
            if (this.form.permanent_address_info.division) {
                this.permanent_address.districts = Object.values(
                    this.data.districts
                ).filter(
                    (district) =>
                        district.divisionId ==
                        this.form.permanent_address_info.division
                );
            } else {
                this.permanent_address.districts = this.data.districts;
            }

            this.form.permanent_address_info.district = "";

            this.permanentAddressDistrictSelectHandler();
        },
        permanentAddressDistrictSelectHandler() {
            if (this.form.permanent_address_info.district) {
                this.permanent_address.areas = Object.values(
                    this.data.areas
                ).filter(
                    (area) =>
                        area.districtId == this.form.permanent_address_info.district
                );
            } else {
                this.permanent_address.areas = this.data.areas;
            }

            this.form.permanent_address_info.area = "";
        },
        addEducationalQualificationSlot() {
            this.form.educational_qualifications.push({
                exam_name: "",
                year: "",
                institute_name: "",
                board: "",
                result: ""
            });
        }
    },
};
</script>
