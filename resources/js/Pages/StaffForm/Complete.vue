<template>
    <div class="w-full max-w-3xl rounded border bg-white p-4 shadow">
        <validation-errors class="mb-4" />

        <form @submit.prevent="submit" class="space-y-4">
            <h2
                class="mt-4 mb-2 text-center text-2xl font-bold text-sky-600 print:text-black"
            >
                সম্পন্ন করন
            </h2>
            <div class="grid gap-x-2 print:grid-cols-3 md:grid-cols-3">
                <div class="col-span-2">
                    <inline-data
                        title="নাম:"
                        :value="data.staff.name"
                    />
                </div>
                <div>
                    <inline-data
                        title="ফরম নাম্বার:"
                        :value="data.staff.id"
                    />
                </div>
                <div class="col-span-2">
                    <inline-data
                        title="পদ:"
                        :value="data.staff.designation_title"
                    />
                </div>
                <div class="">
                    <inline-data
                        title="বেতন:"
                        :value="$e2bnumber(totalSalary)"
                    />
                </div>
            </div>

            <hr />

            <div class="grid gap-4 md:grid-cols-2">
                <div class="p-6 text-center font-semibold text-rose-500 col-span-full">
                    এই আবেদনকারী যদি অত্র প্রতিষ্ঠানের উপযোগী
                    হয় এবং তিনি অঙ্গীকার পূরণে সম্মত হয় তাহলে এই
                    আবেদনকারীকে অত্র প্রতিষ্ঠানে নিয়োগ প্রদান করুন।
                </div>

                <div>
                    <inline-data
                        title="কার্যক্রম সম্পাদনকারীর নাম:"
                        :value="verifiedBy"
                    />
                </div>

                <form-group class="w-full md:flex-row-reverse gap-2" label="নিয়োগের তারিখ:">
                    <Input
                        type="date"
                        class="block w-full md:w-1/2"
                        v-model="form.joining_date"
                        required
                    />
                </form-group>
            </div>

            <hr />

            <div class="flex items-center justify-between">
                <Link
                    :href="
                        route('staff-form.edit', data.staff.id) + '?step=salary'
                    "
                    class="rounded-md border border-orange-600 px-4 py-2 font-semibold text-orange-600 hover:bg-orange-700 hover:text-white"
                >
                    &#8592; পূর্ববর্তী ধাপ
                </Link>
                <Button
                    class="bg-green-600 hover:bg-green-500"
                    :disabled="form.processing"
                >
                    {{ buttonValue }}
                </Button>
            </div>
        </form>
    </div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";
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
    computed: {
        totalSalary() {
            let total = this.data.staff.default_salaries.reduce(function (prev, cur) {
                return prev + parseInt(cur.amount || 0);
            }, 0);

            return isNaN(total) ? 0 : total;
        },
    },
    data() {
        return {
            verifiedBy: this.$page.props.auth.user.name,
            form: this.$inertia.form({
                step: "complete",
                joining_date: "",
            }),
        };
    },
    methods: {
        submit() {
            return this.form.put(
                this.route("staff-form.update", this.data.staff.id) + '?step=complete'
            );
        },
    },
};
</script>
