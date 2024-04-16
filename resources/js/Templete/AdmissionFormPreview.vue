<template>
    <div class="bg-white px-6 py-4 print:py-0 print:px-4">
        <letter-head :photoFrame="true" />
        <h2 class="mt-4 mb-2 text-center text-2xl font-bold print:text-black">
            ভর্তির আবেদন ফরম
        </h2>
        <div class="grid gap-2">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <inline-data
                        title="ফরম নাম্বার:"
                        :value="data.id"
                    />
                </div>
                <div class="flex items-center justify-center gap-4">
                    <label class="flex items-center justify-center gap-2">
                        <check-uncheck-icon class="w-4" :isChecked="true" />
                        <span
                            :class="{
                                'font-semibold': true,
                            }"
                        >
                            নতুন
                        </span>
                    </label>
                    <label class="flex items-center justify-center gap-2">
                        <check-uncheck-icon class="w-4" />
                        <span
                            :class="{
                                'font-semibold': false,
                            }"
                        >
                            পুরাতন
                        </span>
                    </label>
                </div>
            </div>
            <div class="flex items-center justify-between gap-4">
                <div>
                    <inline-data
                        title="শিক্ষার্থীর নাম:"
                        :value="data.name"
                    />
                </div>
                <div>
                    <inline-data
                        title="জন্ম তারিখ:"
                        :value="data.date_of_birth"
                    />
                </div>
            </div>
            <div class="flex items-center justify-between gap-4">
                <div>
                    <inline-data
                        title="জন্ম নিবন্ধন নাম্বার:"
                        :value="data.birth_certificate"
                    />
                </div>
                <div class="flex items-center justify-center gap-4">
                    <div>
                        <inline-data
                            title="রক্তের গ্রুপ:"
                            :value="data.blood_group_text"
                        />
                    </div>
                    <div class="flex items-center justify-center gap-4">
                        <div class="text-gray-700">লিঙ্গ:</div>
                        <label class="flex items-center justify-center gap-2">
                            <check-uncheck-icon
                                class="w-4"
                                :isChecked="data.gender == '1'"
                            />
                            <span
                                :class="{
                                    'font-semibold': data.gender == '1',
                                }"
                            >
                                ছেলে
                            </span>
                        </label>
                        <label class="flex items-center justify-center gap-2">
                            <check-uncheck-icon
                                class="w-4"
                                :isChecked="data.gender == '2'"
                            />
                            <span
                                :class="{
                                    'font-semibold': data.gender == '2',
                                }"
                            >
                                মেয়ে
                            </span>
                        </label>
                    </div>
                </div>
            </div>
            <hr />
            <div class="grid gap-4 print:grid-cols-4 md:grid-cols-4">
                <div class="print:col-span-2 md:col-span-2">
                    <inline-data
                        title="পিতার নাম:"
                        :value="data.fathers_info?.name"
                    />
                </div>
                <div>
                    <inline-data
                        title="ফোন:"
                        :value="data.fathers_info?.phone"
                    />
                </div>
                <div>
                    <inline-data
                        title="পেশা:"
                        :value="data.fathers_info?.occupation"
                    />
                </div>
            </div>
            <div class="grid gap-4 print:grid-cols-4 md:grid-cols-4">
                <div class="print:col-span-2 md:col-span-2">
                    <inline-data
                        title="মাতার নাম:"
                        :value="data.mothers_info?.name"
                    />
                </div>
                <div>
                    <inline-data
                        title="ফোন:"
                        :value="data.mothers_info?.phone"
                    />
                </div>
                <div>
                    <inline-data
                        title="পেশা:"
                        :value="data.mothers_info?.occupation"
                    />
                </div>
            </div>
            <hr />
            <div class="flex items-center gap-4">
                <inline-data title="অভিভাবকের তথ্য" />
                <label class="flex items-center justify-center gap-2">
                    <check-uncheck-icon
                        class="w-4"
                        :isChecked="data.guardian_type == '1'"
                    />
                    <span
                        :class="{
                            'font-semibold': data.guardian_type == '1',
                        }"
                    >
                        পিতা
                    </span>
                </label>
                <label class="flex items-center justify-center gap-2">
                    <check-uncheck-icon
                        class="w-4"
                        :isChecked="data.guardian_type == '2'"
                    />
                    <span
                        :class="{
                            'font-semibold': data.guardian_type == '2',
                        }"
                    >
                        মাতা
                    </span>
                </label>
                <label class="flex items-center justify-center gap-2">
                    <check-uncheck-icon
                        class="w-4"
                        :isChecked="data.guardian_type == '3'"
                    />
                    <span
                        :class="{
                            'font-semibold': data.guardian_type == '3',
                        }"
                    >
                        বৈধ অভিভাবক
                    </span>
                </label>
            </div>
            <div class="grid gap-4 print:grid-cols-4 md:grid-cols-4">
                <div class="print:col-span-2 md:col-span-2">
                    <inline-data
                        title="অভিভাবকের নাম:"
                        :value="data.guardian_info?.name"
                    />
                </div>
                <div>
                    <inline-data
                        title="ফোন:"
                        :value="data.guardian_info?.phone"
                    />
                </div>
                <div>
                    <inline-data
                        title="সম্পর্ক:"
                        :value="data.guardian_info?.relation"
                    />
                </div>
            </div>
            <hr />
            <div class="font-semibold text-gray-700">বর্তমান ঠিকানা:</div>
            <div class="grid gap-4 print:grid-cols-3 md:grid-cols-3">
                <div class="print:col-span-2 md:col-span-2">
                    <inline-data
                        title="বাড়ি নং, রোড নং, গ্রাম/মহল্লা:"
                        :value="data.present_address?.address"
                    />
                </div>
                <div>
                    <inline-data
                        title="পোস্ট অফিস:"
                        :value="data.present_address?.postoffice"
                    />
                </div>
            </div>
            <div class="grid gap-4 print:grid-cols-3 md:grid-cols-3">
                <div>
                    <inline-data
                        title="উপজেলা:"
                        :value="data.present_address?.area"
                    />
                </div>
                <div>
                    <inline-data
                        title="জেলা:"
                        :value="data.present_address?.district"
                    />
                </div>
                <div>
                    <inline-data
                        title="বিভাগ:"
                        :value="data.present_address?.division"
                    />
                </div>
            </div>
            <div class="font-semibold text-gray-700">স্থায়ী ঠিকানা:</div>
            <div class="grid gap-4 print:grid-cols-3 md:grid-cols-3">
                <div class="print:col-span-2 md:col-span-2">
                    <inline-data
                        title="বাড়ি নং, রোড নং, গ্রাম/মহল্লা:"
                        :value="data.permanent_address?.address"
                    />
                </div>
                <div>
                    <inline-data
                        title="পোস্ট অফিস:"
                        :value="data.permanent_address?.postoffice"
                    />
                </div>
            </div>
            <div class="grid gap-4 print:grid-cols-3 md:grid-cols-3">
                <div>
                    <inline-data
                        title="উপজেলা:"
                        :value="data.permanent_address?.area"
                    />
                </div>
                <div>
                    <inline-data
                        title="জেলা:"
                        :value="data.permanent_address?.district"
                    />
                </div>
                <div>
                    <inline-data
                        title="বিভাগ:"
                        :value="data.permanent_address?.division"
                    />
                </div>
            </div>
            <hr />
            <div class="grid gap-4">
                <div>
                    <inline-data
                        title="সর্বশেষ যে বিদ্যালয়ে পড়েছে তার নাম:"
                        :value="data.previous_info?.previous_school"
                    />
                </div>
            </div>
            <div class="flex justify-between gap-4">
                <div class="col-span-2">
                    <inline-data
                        title="শ্রেণী:"
                        :value="data.previous_info?.previous_class"
                    />
                </div>
                <div>
                    <inline-data
                        title="রোল:"
                        :value="data.previous_info?.previous_roll"
                    />
                </div>
                <div class="col-span-3">
                    <inline-data
                        title="সর্বশেষ পরীক্ষার অর্জিত ফলাফল:"
                        :value="data.previous_info?.previous_result"
                    />
                </div>
            </div>
            <hr />
            <div class="grid gap-4">
                <div>
                    <inline-data
                        title="ভর্তিচ্ছু বিভাগ/শ্রেণী:"
                        :value="data.className"
                    />
                </div>
                <div class="flex flex-wrap items-center gap-5">
                    <div class="text-gray-700">শিক্ষার্থীর ধরন:</div>
                    <label class="flex items-center justify-center gap-2">
                        <check-uncheck-icon
                            class="w-4"
                            :isChecked="data.resident == '1'"
                        />
                        <span
                            :class="{
                                'font-semibold': data.resident == '1',
                            }"
                        >
                            আবাসিক
                        </span>
                    </label>
                    <label class="flex items-center justify-center gap-2">
                        <check-uncheck-icon
                            class="w-4"
                            :isChecked="data.resident == '2'"
                        />
                        <span
                            :class="{
                                'font-semibold': data.resident == '2',
                            }"
                        >
                            অনাবাসিক
                        </span>
                    </label>
                    <label class="flex items-center justify-center gap-2">
                        <check-uncheck-icon
                            class="w-4"
                            :isChecked="data.resident == '3'"
                        />
                        <span
                            :class="{
                                'font-semibold': data.resident == '3',
                            }"
                        >
                            ডে-কেয়ার
                        </span>
                    </label>
                    <label class="flex items-center justify-center gap-2">
                        <check-uncheck-icon
                            class="w-4"
                            :isChecked="data.resident == '4'"
                        />
                        <span
                            :class="{
                                'font-semibold': data.resident == '4',
                            }"
                        >
                            সেমি-আবাসিক
                        </span>
                    </label>
                </div>
            </div>
            <div class="flex items-center justify-between gap-4">
                <div>
                    <inline-data
                        title="আবেদনের তারিখ:"
                        :value="(data.application_date)"
                    />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import LetterHead from "@/Templete/LetterHead.vue";
import Input from "@/Components/Input.vue";
import InlineData from "@/Components/InlineData.vue";
import CheckUncheckIcon from "@/Components/CheckUncheckIcon.vue";
export default {
    components: {
        LetterHead,
        Input,
        InlineData,
        CheckUncheckIcon,
    },
    props: {
        data: {
            type: Object,
            default: {},
        },
    },
};
</script>
