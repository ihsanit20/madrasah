<template>
    <div class="w-full max-w-3xl rounded border bg-white p-4 shadow">
        <validation-errors class="mb-4" />

        <form @submit.prevent="submit" class="space-y-4">
            <h2
                class="mt-4 mb-2 text-center text-2xl font-bold text-brand-600 print:text-black"
            >
                ভর্তি সম্পন্নকরণ
            </h2>
            <div class="grid gap-x-2 print:grid-cols-3 md:grid-cols-3">
                <div class="col-span-2">
                    <inline-data
                        title="শিক্ষার্থীর নাম:"
                        :value="data.student.name"
                    />
                </div>
                <div>
                    <inline-data
                        title="ফরম নাম্বার:"
                        :value="data.admission.id"
                    />
                </div>
                <div class="col-span-2">
                    <inline-data
                        title="ভর্তিচ্ছু বিভাগ/শ্রেণী:"
                        :value="data.admission.className"
                    />
                </div>
                <div>
                    <inline-data
                        title="শিক্ষার্থীর ধরন:"
                        :value="data.student.residentText"
                    />
                </div>
            </div>

            <hr />

            <div class="grid gap-4">
                <div class="p-6 text-center font-semibold text-rose-500">
                    এই আবেদনকারী শিক্ষার্থী যদি অত্র প্রতিষ্ঠানে ভর্তির উপযোগী
                    হয় এবং অভিভাবক মহোদয় অঙ্গীকার পূরণে সম্মত হয় তাহলে এই
                    আবেদনকারীকে অত্র প্রতিষ্ঠানের শিক্ষার্থী হিসেবে গণ্য করুন
                </div>

                <div>
                    <inline-data
                        title="ভর্তি কার্যক্রম সম্পাদনকারীর নাম:"
                        :value="verifiedBy"
                    />
                </div>
            </div>

            <hr />

            <div class="flex items-center justify-between">
                <Link
                    :href="
                        route('admissions.edit', data.admission.id) + '?step=3'
                    "
                    class="rounded-md border border-brand-600 px-4 py-2 font-semibold text-brand-600 hover:bg-brand-700 hover:text-white"
                >
                    &#8592; পূর্ববর্তী ধাপ
                </Link>
                <Button
                    class="bg-brand-600 hover:bg-brand-600"
                    :disabled="form.processing"
                    v-html="buttonValue"
                >
                </Button>
            </div>
        </form>
    </div>
</template>

<script>
import { Link } from "@inertiajs/vue3";
import ValidationErrors from "@/Components/ValidationErrors.vue";
import Label from "@/Components/Label.vue";
import Button from "@/Components/Button.vue";
import Input from "@/Components/Input.vue";
import Select from "@/Components/Select.vue";
import FormHeading from "@/Components/FormHeading.vue";
import FormGroup from "@/Components/FormGroup.vue";
import FormSlotGroup from "@/Components/FormSlotGroup.vue";
import InlineData from "@/Components/InlineData.vue";

export default {
    components: {
        Link,
        ValidationErrors,
        Label,
        Button,
        Input,
        Select,
        FormHeading,
        FormGroup,
        FormSlotGroup,
        InlineData,
    },
    props: {
        moduleAction: String,
        buttonValue: {
            type: String,
            default: "ভর্তি সম্পন্ন করুন",
        },
        data: {
            type: Object,
            default: {},
        },
    },
    data() {
        return {
            verifiedBy:
                this.data.admission.verifiedBy ||
                this.$page.props.auth.user.name,
            form: this.$inertia.form({
                step: 4,
            }),
        };
    },
    methods: {
        submit() {
            if (this.moduleAction == "update") {
                return this.form.put(
                    this.route("admissions.update", this.data.admission.id)
                );
            }
        },
    },
};
</script>
