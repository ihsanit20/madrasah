<template>
    <div class="w-full max-w-3xl rounded border bg-white p-4 shadow">
        <validation-errors class="mb-4" />

        <form @submit.prevent="submit" class="">
            <form-heading class="mb-2">Basic Information</form-heading>
            <div class="grid gap-x-2 gap-y-4 md:grid-cols-2">
                <form-group class="w-full" label="Name">
                    <Input
                        type="text"
                        class="block w-full"
                        v-model="form.name"
                        required
                    />
                </form-group>
                <form-group class="w-full" label="Date of Birth">
                    <Input
                        type="date"
                        class="block w-full"
                        v-model="form.date_of_birth"
                        required
                    />
                </form-group>
                <form-group class="w-full" label="Birth Certificate">
                    <Input
                        type="number"
                        class="block w-full"
                        v-model="form.birth_certificate"
                        required
                    />
                </form-group>
                <form-group class="w-full" label="Gender">
                    <div
                        class="flex items-center gap-2 rounded-md border py-2 pl-2"
                    >
                        <label class="flex items-center gap-1">
                            <Input
                                v-model="form.gender"
                                type="radio"
                                name="gender"
                                :value="1"
                                :checked="form.gender == 1"
                                required
                            />
                            <span>Male</span>
                        </label>
                        <label class="flex items-center gap-1">
                            <Input
                                v-model="form.gender"
                                type="radio"
                                name="gender"
                                :value="2"
                                :checked="form.gender == 2"
                                required
                            />
                            <span>Female</span>
                        </label>
                    </div>
                </form-group>
                <form-group
                    class="col-span-full grid gap-2 rounded-md border border-dashed border-gray-300 px-2 pt-4 pb-2 md:grid-cols-3"
                    label="Father's info"
                >
                    <form-group class="w-full" label="Name">
                        <Input
                            type="text"
                            class="block w-full"
                            v-model="form.father_info.name"
                            required
                        />
                    </form-group>
                    <form-group class="w-full" label="Phone">
                        <Input
                            type="number"
                            class="block w-full"
                            v-model="form.father_info.phone"
                        />
                    </form-group>
                    <form-group class="w-full" label="Occupation">
                        <Input
                            type="text"
                            class="block w-full"
                            v-model="form.father_info.occupation"
                        />
                    </form-group>
                </form-group>
                <form-group
                    class="col-span-full grid gap-2 rounded-md border border-dashed border-gray-300 px-2 pt-4 pb-2 md:grid-cols-3"
                    label="Mother's info"
                >
                    <form-group class="w-full" label="Name">
                        <Input
                            type="text"
                            class="block w-full"
                            v-model="form.mother_info.name"
                            required
                        />
                    </form-group>
                    <form-group class="w-full" label="Phone">
                        <Input
                            type="number"
                            class="block w-full"
                            v-model="form.mother_info.phone"
                        />
                    </form-group>
                    <form-group class="w-full" label="Occupation">
                        <Input
                            type="text"
                            class="block w-full"
                            v-model="form.mother_info.occupation"
                        />
                    </form-group>
                </form-group>
            </div>

            <form-heading class="mt-6 mb-2">Contact Information</form-heading>
            <div class="grid gap-x-2 gap-y-4 md:grid-cols-3">
                <form-group
                    class="col-span-full grid gap-2 rounded-md border border-dashed border-gray-300 px-2 pt-3 pb-2"
                    label="Financial Guardian"
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
                            <span>Father</span>
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
                            <span>Mother</span>
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
                            <span>Other</span>
                        </label>
                    </div>
                    <div
                        v-if="form.guardian_type == 3"
                        class="grid gap-2 md:grid-cols-3"
                    >
                        <form-group class="w-full" label="Name">
                            <Input
                                type="text"
                                class="block w-full"
                                v-model="form.guardian_info.name"
                                required
                            />
                        </form-group>
                        <form-group class="w-full" label="Phone">
                            <Input
                                type="number"
                                class="block w-full"
                                v-model="form.guardian_info.phone"
                            />
                        </form-group>
                        <form-group class="w-full" label="Relation">
                            <Input
                                type="text"
                                class="block w-full"
                                v-model="form.guardian_info.relation"
                            />
                        </form-group>
                    </div>
                </form-group>
            </div>

            <form-heading class="mt-6 mb-2">Present Address</form-heading>
            <form-group
                class="col-span-full grid gap-2 rounded-md border border-dashed border-gray-300 px-2 pt-2 pb-2"
            >
                <div class="grid gap-x-2 gap-y-4 md:grid-cols-3">
                    <form-group>
                        <Select
                            class="block w-full"
                            v-model="form.present_address.division"
                            @change="presentAddressDivisionSelectHandler"
                        >
                            <option value="">-- Select Division --</option>
                            <option
                                v-for="division in present_address.divisions"
                                :key="division.id"
                                :value="division.id"
                            >
                                {{ division.name }}
                            </option>
                        </Select>
                    </form-group>
                    <form-group>
                        <Select
                            class="block w-full"
                            v-model="form.present_address.district"
                            @change="presentAddressDistrictSelectHandler"
                        >
                            <option value="">-- Select District --</option>
                            <option
                                v-for="district in present_address.districts"
                                :key="district.id"
                                :value="district.id"
                            >
                                {{ district.name }}
                            </option>
                        </Select>
                    </form-group>
                    <form-group>
                        <Select
                            class="block w-full"
                            v-model="form.present_address.area"
                        >
                            <option value="">-- Select Area --</option>
                            <option
                                v-for="area in present_address.areas"
                                :key="area.id"
                                :value="area.id"
                            >
                                {{ area.name }}
                            </option>
                        </Select>
                    </form-group>
                    <form-group label="Address" class="col-span-full">
                        <Input
                            type="text"
                            class="block w-full"
                            v-model="form.present_address.address"
                        />
                    </form-group>
                </div>
            </form-group>

            <form-heading class="mt-6 mb-2">Permanent Address</form-heading>
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
                        <span>Same as present</span>
                    </label>
                </div>
                <div
                    v-if="!form.is_same_address"
                    class="grid gap-x-2 gap-y-4 md:grid-cols-3"
                >
                    <form-group>
                        <Select
                            class="block w-full"
                            v-model="form.permanent_address.division"
                            @change="permanentAddressDivisionSelectHandler"
                        >
                            <option value="">-- Select Division --</option>
                            <option
                                v-for="division in permanent_address.divisions"
                                :key="division.id"
                                :value="division.id"
                            >
                                {{ division.name }}
                            </option>
                        </Select>
                    </form-group>
                    <form-group>
                        <Select
                            class="block w-full"
                            v-model="form.permanent_address.district"
                            @change="permanentAddressDistrictSelectHandler"
                        >
                            <option value="">-- Select District --</option>
                            <option
                                v-for="district in permanent_address.districts"
                                :key="district.id"
                                :value="district.id"
                            >
                                {{ district.name }}
                            </option>
                        </Select>
                    </form-group>
                    <form-group>
                        <Select
                            class="block w-full"
                            v-model="form.permanent_address.area"
                        >
                            <option value="">-- Select Area --</option>
                            <option
                                v-for="area in permanent_address.areas"
                                :key="area.id"
                                :value="area.id"
                            >
                                {{ area.name }}
                            </option>
                        </Select>
                    </form-group>
                    <form-group label="Address" class="col-span-full">
                        <Input
                            type="text"
                            class="block w-full"
                            v-model="form.permanent_address.address"
                        />
                    </form-group>
                </div>
            </form-group>

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

            this.form.present_address.address =
                this.data.student.presentAddress.value;
            this.form.present_address.area =
                this.data.student.presentAddress.areaId;
            this.form.present_address.district =
                this.data.student.presentAddress.area.districtId;
            this.form.present_address.division =
                this.data.student.presentAddress.area.district.divisionId;

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
                areas: "",
            },
            permanent_address: {
                divisions: "",
                districts: "",
                areas: "",
            },
            form: this.$inertia.form({
                name: this.data.student.name,
                date_of_birth: this.data.student.dateOfBirth,
                birth_certificate: this.data.student.birthCertificate,
                gender:
                    this.moduleAction == "update"
                        ? this.data.student.gender
                        : 0,
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
