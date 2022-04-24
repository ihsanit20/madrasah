<template>
    <div class="bg-white p-10">
        <letter-head :photoFrame="true" />
        <h2 class="mt-4 mb-2 text-center text-2xl font-bold print:text-black">
            ভর্তির আবেদন ফরম
        </h2>
        <div class="grid gap-4">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <inline-data
                        title="ফরম নাম্বার:"
                        :value="data.admission.id"
                    />
                </div>
                <div class="flex items-center justify-center gap-4">
                    <label class="flex items-center justify-center gap-2">
                        <Input
                            type="radio"
                            :checked="true"
                            class="h-3.5 w-3.5 rounded-none"
                        />
                        <span>নতুন</span>
                    </label>
                    <label class="flex items-center justify-center gap-2">
                        <Input type="radio" class="h-3.5 w-3.5 rounded-none" />
                        <span>পুরাতন</span>
                    </label>
                </div>
            </div>
            <div class="flex items-center justify-between gap-4">
                <div>
                    <inline-data
                        title="শিক্ষার্থীর নাম:"
                        :value="data.student.name"
                    />
                </div>
                <div>
                    <inline-data
                        title="জন্ম তারিখ:"
                        :value="data.student.dateOfBirthWithFormat"
                    />
                </div>
            </div>
            <div class="flex items-center justify-between gap-4">
                <div>
                    <inline-data
                        title="জন্ম নিবন্ধন নাম্বার:"
                        :value="data.student.birthCertificate"
                    />
                </div>
                <div class="flex items-center justify-center gap-4">
                    <div>
                        <inline-data
                            title="রক্তের গ্রুপ:"
                            :value="data.student.bloodGroupText"
                        />
                    </div>
                    <div class="flex items-center justify-center gap-4">
                        <div class="text-gray-700">লিঙ্গ:</div>
                        <label class="flex items-center justify-center gap-2">
                            <Input
                                type="radio"
                                name="gender"
                                :checked="data.student.gender == '1'"
                                class="h-3.5 w-3.5 rounded-none"
                            />
                            <span>ছেলে</span>
                        </label>
                        <label class="flex items-center justify-center gap-2">
                            <Input
                                type="radio"
                                name="gender"
                                :checked="data.student.gender == '2'"
                                class="h-3.5 w-3.5 rounded-none"
                            />
                            <span>মেয়ে</span>
                        </label>
                    </div>
                </div>
            </div>
            <hr />
            <div class="grid gap-4 print:grid-cols-3 md:grid-cols-3">
                <div>
                    <inline-data
                        title="পিতার নাম:"
                        :value="data.student.fatherInfo.name"
                    />
                </div>
                <div>
                    <inline-data
                        title="ফোন:"
                        :value="data.student.fatherInfo.phone"
                    />
                </div>
                <div>
                    <inline-data
                        title="পেশা:"
                        :value="data.student.fatherInfo.occupation"
                    />
                </div>
            </div>
            <div class="grid gap-4 print:grid-cols-3 md:grid-cols-3">
                <div>
                    <inline-data
                        title="মাতার নাম:"
                        :value="data.student.motherInfo.name"
                    />
                </div>
                <div>
                    <inline-data
                        title="ফোন:"
                        :value="data.student.motherInfo.phone"
                    />
                </div>
                <div>
                    <inline-data
                        title="পেশা:"
                        :value="data.student.motherInfo.occupation"
                    />
                </div>
            </div>
            <hr />
        </div>
    </div>
</template>

<script>
import LetterHead from "@/Templete/LetterHead.vue";
import Input from "@/Components/Input.vue";
import InlineData from "@/Components/InlineData.vue";
export default {
    components: {
        LetterHead,
        Input,
        InlineData,
    },
    props: {
        data: {
            type: Object,
            default: {},
        },
    },
};
</script>
