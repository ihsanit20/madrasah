<template>
    <div class="w-full max-w-xl rounded border bg-white p-4 shadow">
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

            <hr class="my-4 w-full" />

            <div class="grid gap-4">
                <form-group class="w-full md:flex-row-reverse justify-center items-center gap-2" label="নিয়োগের তারিখ:">
                    <Input
                        type="date"
                        class="block w-full md:w-1/2"
                        v-model="form.joining_date"
                        required
                    />
                </form-group>
            </div>

            <hr class="my-4 w-full" />

            <div class="flex items-center justify-between">
                <Link
                    :href="
                        route('staff.show', data.staff.id)
                    "
                    class="rounded-md border border-brand-600 px-4 py-2 font-semibold text-brand-600 hover:bg-brand-700 hover:text-white"
                >
                    Cancel
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
import { Link } from "@inertiajs/vue3";
import ValidationErrors from "@/Components/ValidationErrors.vue";
import Button from "@/Components/Button.vue";
import Input from "@/Components/Input.vue";
import Select from "@/Components/Select.vue";
import FormHeading from "@/Components/FormHeading.vue";
import FormGroup from "@/Components/FormGroup.vue";
import Textarea from "@/Components/Textarea.vue";

export default {
    components: {
        Link,
        ValidationErrors,
        Button,
        Input,
        Select,
        FormHeading,
        FormGroup,
        Textarea,
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
                step: "basic",
                name: this.data.staff.name,
                date_of_birth: this.data.staff.date_of_birth,
                phone: this.data.staff.phone,
                alternative_phone: this.data.staff.alternative_phone,
                nid: this.data.staff.nid,
                gender: this.data.staff.gender,
                blood_group: this.data.staff.bloodGroup,
                fathers_info: this.data.staff.fathers_info,
                mothers_info: this.data.staff.mothers_info,
                reference_info: this.data.staff.reference_info,
                is_same_address: this.data.staff.is_same_address,
                present_address_info: this.data.staff.present_address_info,
                permanent_address_info: this.data.staff.permanent_address_info,
                joining_date: this.data.staff.joining_date,
            }),
        };
    },
    methods: {
        submit() {
            if (this.moduleAction == "store") {
                return this.form.post(this.route("staff.store"));
            }
            if (this.moduleAction == "update") {
                return this.form.put(
                    this.route("staff.update", this.data.staff.id)
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
