<template>
    <div class="w-full max-w-lg rounded border bg-white p-4 shadow">
        <validation-errors />

        <h2
            class="mb-2 text-center text-2xl font-bold text-sky-600 print:text-black"
        >
            টাকা জমার রশিদ
        </h2>

        <div class="grid gap-x-1 md:grid-cols-3">
            <div class="col-span-2">
                <inline-data title="তারিখ:" :value="$e2bnumber(data.date)" />
            </div>
            <div class="col-span-2">
                <inline-data
                    title="শ্রেণী:"
                    :value="data.admission.className"
                />
            </div>
            <div>
                <inline-data
                    title="রোল:"
                    :value="$e2bnumber(data.admission.roll)"
                />
            </div>
            <div class="col-span-2">
                <inline-data
                    title="শিক্ষার্থীর নাম:"
                    :value="data.admission.student.name"
                />
            </div>
            <div>
                <inline-data
                    title="রেজি. নং:"
                    :value="$e2bnumber(data.admission.student.registration)"
                />
            </div>
            <div class="col-span-2">
                <inline-data title="বাবদ:" :value="data.purposeText" />
            </div>
        </div>

        <form @submit.prevent="submit" class="my-2">
            <table
                class="min-w-full table-fixed divide-y divide-gray-200 dark:divide-gray-700 print:divide-black"
            >
                <thead class="bg-gray-300 dark:bg-gray-700">
                    <tr>
                        <th
                            class="py-2 px-2 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-400 print:text-black md:text-sm"
                        >
                            ক্রম
                        </th>
                        <th
                            class="py-2 px-2 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-400 print:text-black md:text-sm"
                        >
                            ফি বিবরণী
                        </th>
                        <th
                            class="py-2 px-2 text-right text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-400 print:text-black md:text-sm"
                        >
                            নির্ধারিত টাকা
                        </th>
                    </tr>
                </thead>
                <tr
                    v-for="(fee, index) in form.fees"
                    :key="index"
                    class="hover:bg-gray-100 dark:hover:bg-gray-700"
                >
                    <td
                        class="whitespace-nowrap py-2 px-2 text-left text-xs font-medium text-gray-900 dark:text-white md:text-sm"
                    >
                        {{ $e2bnumber(index + 1) }}
                    </td>
                    <td
                        class="whitespace-nowrap py-2 px-2 text-left text-xs font-medium text-gray-900 dark:text-white md:text-sm"
                    >
                        {{ fee.name }}
                    </td>
                    <td
                        class="whitespace-nowrap py-2 px-2 text-right text-xs font-medium text-gray-900 dark:text-white md:text-sm"
                    >
                        {{ fee.amount }}
                    </td>
                </tr>
                <tr>
                    <th
                        colspan="3"
                        class="py-2 px-2 text-right text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-400 print:text-black md:text-sm"
                    >
                        <div class="flex justify-end gap-2">
                            <span>মোট প্রদেয়:</span>
                            <span>{{ getFeeTotal() }}</span>
                        </div>
                    </th>
                </tr>
                <tr>
                    <th
                        colspan="3"
                        class="py-1 text-right text-xs font-bold uppercase tracking-wider text-green-600 dark:text-gray-400 print:text-black md:text-sm"
                    >
                        <div class="flex items-center justify-end gap-1">
                            <span>জমা:</span>
                            <Input
                                type="number"
                                v-model="form.paid"
                                class="block w-16 px-1 py-0.5 text-right"
                                required
                            />
                        </div>
                    </th>
                </tr>
                <tr>
                    <th
                        colspan="3"
                        class="py-2 px-2 text-right text-xs font-bold uppercase tracking-wider text-rose-600 dark:text-gray-400 print:text-black md:text-sm"
                    >
                        <div class="flex justify-end gap-2">
                            <span>বাকী:</span>
                            <span>
                                {{ getFeeTotal() - form.paid }}
                            </span>
                        </div>
                    </th>
                </tr>
            </table>

            <hr />

            <div
                class="col-span-full space-y-1 rounded-md border border-dashed border-gray-300 p-3"
            >
                <label class="flex items-center gap-2">
                    <Input
                        type="checkbox"
                        name="declaration"
                        :value="1"
                        :checked="declaration == '1'"
                        v-model="declaration"
                        @change="diclarationByAdmin"
                        required
                    />
                    <span>
                        আমি এই আবেদনকারীর দেওয়া সমস্ত তথ্য যাচাই করেছি
                    </span>
                </label>
                <div>
                    <inline-data title="আদায়কারী:" :value="verifiedBy" />
                </div>
            </div>

            <div class="mt-4 flex items-center justify-between">
                <Link
                    :href="route('payments.create')"
                    class="rounded-md border border-orange-600 px-4 py-2 font-semibold text-orange-600 hover:bg-orange-700 hover:text-white"
                >
                    &#8592; পূর্ববর্তী ধাপ
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
import ValidationErrors from "@/Components/ValidationErrors.vue";
import Button from "@/Components/Button.vue";
import Input from "@/Components/Input.vue";
import Select from "@/Components/Select.vue";
import FormGroup from "@/Components/FormGroup.vue";
import Textarea from "@/Components/Textarea.vue";
import LetterHead from "@/Templete/LetterHead.vue";
import { Link } from "@inertiajs/inertia-vue3";
import InlineData from "@/Components/InlineData.vue";

export default {
    components: {
        ValidationErrors,
        Button,
        Input,
        Select,
        FormGroup,
        Textarea,
        LetterHead,
        Link,
        InlineData,
    },
    props: {
        moduleAction: String,
        buttonValue: {
            type: String,
            default: "সংরক্ষণ করুণ",
        },
        data: {
            type: Object,
            default: {},
        },
    },
    created() {
        this.form.admission_id = this.data.admission.id;
        this.form.purpose = this.data.purpose;
        this.form.date = this.data.date;
    },
    data() {
        return {
            verifiedBy: this.$page.props.auth.user.name,
            form: this.$inertia.form({
                admission_id: "",
                purpose: "",
                date: "",
                total: "",
                paid: "",
                fees: this.data.fees,
            }),
        };
    },
    methods: {
        submit() {
            this.form.total = this.getFeeTotal();

            if (this.moduleAction == "store") {
                return this.form.post(this.route("payments.store"));
            }
            if (this.moduleAction == "update") {
                return this.form.put(
                    this.route("payments.update", this.data.payment.id)
                );
            }
        },
        getFeeTotal() {
            let total = 0;

            Object.values(this.form.fees).forEach((fee) => {
                total += parseInt(fee.amount);
            });

            return total;
        },
    },
};
</script>
