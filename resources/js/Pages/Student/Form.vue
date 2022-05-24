<template>
    <div class="w-full max-w-3xl rounded border bg-white p-4 shadow">
        <validation-errors class="mb-4" />

        <form @submit.prevent="submit" class="">
            <form-heading class="mb-2">ব্যক্তিগত তথ্য</form-heading>
            <div class="grid gap-x-2 gap-y-4 md:grid-cols-2">
                <form-group class="w-full" label="শিক্ষার্থীর নাম">
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
                <form-group class="w-full" label="জন্ম নিবন্ধন নাম্বার">
                    <Input
                        type="number"
                        class="block w-full"
                        v-model="form.birth_certificate"
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
                <form-group
                    class="col-span-full grid gap-2 rounded-md border border-dashed border-gray-300 px-2 py-2 md:grid-cols-3"
                >
                    <form-group class="w-full" label="পিতার নাম">
                        <Input
                            type="text"
                            class="block w-full"
                            v-model="form.father_info.name"
                            required
                        />
                    </form-group>
                    <form-group class="w-full" label="ফোন">
                        <Input
                            type="number"
                            class="block w-full"
                            v-model="form.father_info.phone"
                        />
                    </form-group>
                    <form-group class="w-full" label="পেশা">
                        <Input
                            type="text"
                            class="block w-full"
                            v-model="form.father_info.occupation"
                        />
                    </form-group>
                </form-group>
                <form-group
                    class="col-span-full grid gap-2 rounded-md border border-dashed border-gray-300 px-2 py-2 md:grid-cols-3"
                >
                    <form-group class="w-full" label="মাতার নাম">
                        <Input
                            type="text"
                            class="block w-full"
                            v-model="form.mother_info.name"
                            required
                        />
                    </form-group>
                    <form-group class="w-full" label="ফোন">
                        <Input
                            type="number"
                            class="block w-full"
                            v-model="form.mother_info.phone"
                        />
                    </form-group>
                    <form-group class="w-full" label="পেশা">
                        <Input
                            type="text"
                            class="block w-full"
                            v-model="form.mother_info.occupation"
                        />
                    </form-group>
                </form-group>
            </div>

            <form-heading class="mt-6 mb-2">অভিভাবকের তথ্য</form-heading>
            <div class="grid gap-x-2 gap-y-4 md:grid-cols-3">
                <form-group
                    class="col-span-full grid gap-2 rounded-md border border-dashed border-gray-300 px-2 py-2"
                >
                    <div
                        class="col-span-full flex items-center justify-center gap-3 md:justify-start"
                    >
                        <label class="flex items-center gap-1">
                            <Input
                                v-model="form.guardian_type"
                                type="radio"
                                name="guardian_info_type"
                                :value="1"
                                :checked="form.guardian_type == 1"
                                required
                            />
                            <span>পিতা</span>
                        </label>
                        <label class="flex items-center gap-1">
                            <Input
                                v-model="form.guardian_type"
                                type="radio"
                                name="guardian_info_type"
                                :value="2"
                                :checked="form.guardian_type == 2"
                                required
                            />
                            <span>মাতা</span>
                        </label>
                        <label class="flex items-center gap-1">
                            <Input
                                v-model="form.guardian_type"
                                type="radio"
                                name="guardian_info_type"
                                :value="3"
                                :checked="form.guardian_type == 3"
                                required
                            />
                            <span>বৈধ অভিভাবক</span>
                        </label>
                    </div>
                    <div
                        v-if="form.guardian_type == 3"
                        class="grid gap-2 md:grid-cols-3"
                    >
                        <form-group class="w-full" label="অভিভাবকের নাম">
                            <Input
                                type="text"
                                class="block w-full"
                                v-model="form.guardian_info.name"
                                required
                            />
                        </form-group>
                        <form-group class="w-full" label="ফোন">
                            <Input
                                type="number"
                                class="block w-full"
                                v-model="form.guardian_info.phone"
                            />
                        </form-group>
                        <form-group
                            class="w-full"
                            label="শিক্ষাথীর সাথে সম্পর্ক"
                        >
                            <Input
                                type="text"
                                class="block w-full"
                                v-model="form.guardian_info.relation"
                            />
                        </form-group>
                    </div>
                </form-group>
            </div>

            <form-heading class="mt-6 mb-2">বর্তমান ঠিকানা</form-heading>
            <form-group
                class="col-span-full grid gap-2 rounded-md border border-dashed border-gray-300 px-2 pt-2 pb-2"
            >
                <div class="grid gap-x-2 gap-y-4 md:grid-cols-3">
                    <form-group label="বিভাগ">
                        <Select
                            class="block w-full"
                            v-model="form.present_address.division"
                            @change="presentAddressDivisionSelectHandler"
                            required
                        >
                            <option value="">-- নির্বাচন করুন --</option>
                            <option
                                v-for="division in present_address.divisions"
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
                            v-model="form.present_address.district"
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
                            v-model="form.present_address.area"
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
                            v-model="form.present_address.postoffice"
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
                            v-model="form.present_address.address"
                            required
                        />
                    </form-group>
                </div>
            </form-group>

            <form-heading class="mt-6 mb-2">স্থায়ী ঠিকানা</form-heading>
            <form-group
                class="col-span-full grid gap-2 rounded-md border border-dashed border-gray-300 px-2 pt-2 pb-2"
            >
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
                            v-model="form.permanent_address.division"
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
                            v-model="form.permanent_address.district"
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
                            v-model="form.permanent_address.area"
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
                            v-model="form.permanent_address.postoffice"
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
                            v-model="form.permanent_address.address"
                            required
                        />
                    </form-group>
                </div>
            </form-group>

            <form-heading class="mt-6 mb-2">শিক্ষার্থীর ধরন</form-heading>
            <div class="grid gap-x-2 gap-y-4 md:grid-cols-3">
                <form-group
                    class="col-span-full grid gap-2 rounded-md border border-dashed border-gray-300 px-2 py-2"
                >
                    <div
                        class="col-span-full flex items-center justify-center gap-3 md:justify-start"
                    >
                        <label class="flex items-center gap-1">
                            <Input
                                v-model="form.resident"
                                type="radio"
                                name="resident"
                                :value="1"
                                :checked="form.resident == 1"
                                required
                            />
                            <span>আবাসিক</span>
                        </label>
                        <label class="flex items-center gap-1">
                            <Input
                                v-model="form.resident"
                                type="radio"
                                name="resident"
                                :value="2"
                                :checked="form.resident == 2"
                                required
                            />
                            <span>অনাবাসিক</span>
                        </label>
                        <label class="flex items-center gap-1">
                            <Input
                                v-model="form.resident"
                                type="radio"
                                name="resident"
                                :value="3"
                                :checked="form.resident == 3"
                                required
                            />
                            <span>ডে-কেয়ার</span>
                        </label>
                        <label class="flex items-center gap-1">
                            <Input
                                v-model="form.resident"
                                type="radio"
                                name="resident"
                                :value="3"
                                :checked="form.resident == 3"
                                required
                            />
                            <span>সেমি-আবাসিক</span>
                        </label>
                    </div>
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
import Label from "@/Components/Label.vue";
import Button from "@/Components/Button.vue";
import Input from "@/Components/Input.vue";
import Select from "@/Components/Select.vue";
import FormHeading from "@/Components/FormHeading.vue";
import FormGroup from "@/Components/FormGroup.vue";
import FormSlotGroup from "@/Components/FormSlotGroup.vue";

export default {
    components: {
        ValidationErrors,
        Label,
        Button,
        Input,
        Select,
        FormHeading,
        FormGroup,
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

        if (this.moduleAction == "update") {
            this.form.father_info = this.data.student.fatherInfo;
            this.form.mother_info = this.data.student.motherInfo;
            this.form.guardian_info = this.data.student.guardianInfo;

            this.form.present_address.postoffice =
                this.data.student.presentAddress.postoffice;
            this.form.present_address.address =
                this.data.student.presentAddress.value;
            this.form.present_address.area =
                this.data.student.presentAddress.areaId;
            this.form.present_address.district =
                this.data.student.presentAddress.area.districtId;
            this.form.present_address.division =
                this.data.student.presentAddress.area.district.divisionId;

            this.form.permanent_address.postoffice =
                this.data.student.permanentAddress.postoffice;
            this.form.permanent_address.address =
                this.data.student.permanentAddress.value;
            this.form.permanent_address.area =
                this.data.student.permanentAddress.areaId;
            this.form.permanent_address.district =
                this.data.student.permanentAddress.area.districtId;
            this.form.permanent_address.division =
                this.data.student.permanentAddress.area.district.divisionId;
        }
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
                name: this.data.student.name,
                date_of_birth: this.data.student.dateOfBirth,
                birth_certificate: this.data.student.birthCertificate,
                gender: this.data.student.gender,
                blood_group: this.data.student.bloodGroup,
                father_info: {
                    name: "",
                    phone: "",
                    occupation: "",
                    relation: "Father",
                },
                mother_info: {
                    name: "",
                    phone: "",
                    occupation: "",
                    relation: "Mother",
                },
                guardian_type:
                    this.moduleAction == "update"
                        ? this.data.student.guardianType
                        : 0,
                guardian_info: {
                    name: "",
                    phone: "",
                    occupation: "",
                    relation: "",
                },
                is_same_address:
                    this.moduleAction == "update"
                        ? this.data.student.isSameAddress
                        : 0,
                present_address: {
                    division: "",
                    district: "",
                    area: "",
                    address: "",
                },
                permanent_address: {
                    division: "",
                    district: "",
                    area: "",
                    address: "",
                },
                resident: this.data.student.resident,
            }),
        };
    },
    methods: {
        submit() {
            if (this.moduleAction == "store") {
                return this.form.post(this.route("students.store"));
            }
            if (this.moduleAction == "update") {
                return this.form.put(
                    this.route("students.update", this.data.student.id)
                );
            }
        },
        sameAsPresentHandler(event) {
            this.form.is_same_address = event.target.checked;
        },
        presentAddressDivisionSelectHandler() {
            if (this.form.present_address.division) {
                this.present_address.districts = Object.values(
                    this.data.districts
                ).filter(
                    (district) =>
                        district.divisionId ==
                        this.form.present_address.division
                );
            } else {
                this.present_address.districts = this.data.districts;
            }

            this.form.present_address.district = "";

            this.presentAddressDistrictSelectHandler();
        },
        presentAddressDistrictSelectHandler() {
            if (this.form.present_address.district) {
                this.present_address.areas = Object.values(
                    this.data.areas
                ).filter(
                    (area) =>
                        area.districtId == this.form.present_address.district
                );
            } else {
                this.present_address.areas = this.data.areas;
            }

            this.form.present_address.area = "";
        },
        permanentAddressDivisionSelectHandler() {
            if (this.form.permanent_address.division) {
                this.permanent_address.districts = Object.values(
                    this.data.districts
                ).filter(
                    (district) =>
                        district.divisionId ==
                        this.form.permanent_address.division
                );
            } else {
                this.permanent_address.districts = this.data.districts;
            }

            this.form.permanent_address.district = "";

            this.permanentAddressDistrictSelectHandler();
        },
        permanentAddressDistrictSelectHandler() {
            if (this.form.permanent_address.district) {
                this.permanent_address.areas = Object.values(
                    this.data.areas
                ).filter(
                    (area) =>
                        area.districtId == this.form.permanent_address.district
                );
            } else {
                this.permanent_address.areas = this.data.areas;
            }

            this.form.permanent_address.area = "";
        },
    },
};
</script>
