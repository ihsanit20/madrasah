<template>
    <div class="w-full max-w-xl rounded border bg-white p-4 shadow">
        <h3 class="text-center text-2xl font-bold text-brand-600">বেতন রশিদ</h3>

        <div class="flex items-center justify-between">
            <inline-data title="রশিদ নং:" />
            <inline-data title="তারিখ:" />
        </div>
        <div class="flex items-center justify-between">
            <inline-data title="নাম:" :value="data.staff.name" />
            <inline-data title="পদবি:" :value="data.staff.designationTitle" />
        </div>
        <form-group class="col-span-full" label="বাবদ নির্বাচন করুন">
            <Select
                class="block w-full"
                v-model="form.purpose_id"
                @change="purposeChangeHandler"
                required
            >
                <option value="">-- নির্বাচন করুন --</option>
                <option
                    v-for="(purpose, index) in data.purposes"
                    :key="index"
                    :value="index"
                    :disabled="
                        Number(data.staff.due_purpose_id) !== Number(index) &&
                        paidPurposeIds.includes(Number(index))
                    "
                    v-html="
                        (Number(data.staff.due_purpose_id) === Number(index)
                            ? '&#9888; (বকেয়া) '
                            : paidPurposeIds.includes(Number(index))
                            ? '&#x2713; '
                            : '') + purpose
                    "
                ></option>
            </Select>
        </form-group>

        <hr class="my-3" />

        <validation-errors class="mb-4" />

        <form @submit.prevent="submit" class="">
            <div class="grid">
                <div
                    class="flex justify-between bg-gray-200 py-2 px-3 font-bold"
                >
                    <div>বেতনের বিবরণ</div>
                    <div>নির্ধারিত টাকা</div>
                </div>
                <div
                    v-for="(salary, index) in form.salaries"
                    :key="index"
                    class="flex justify-between py-2 px-3 font-bold"
                    :class="index % 2 ? 'bg-gray-100' : ''"
                >
                    <div>{{ salary.title }}</div>
                    <div>{{ $e2bnumber(salary.amount) }}</div>
                </div>
                <div
                    class="flex justify-end gap-2 border-t py-2 px-3 font-bold"
                >
                    <div>মোট:</div>
                    <div>{{ $e2bnumber(totalSalary) }}</div>
                </div>
                <div
                    class="flex justify-end gap-2 border-t py-1 px-1.5 font-bold"
                >
                    <div>কর্তন:</div>
                    <div>
                        <Input
                            type="number"
                            v-model="form.cut"
                            class="w-12 py-0.5 px-1 text-right text-red-600"
                        />
                    </div>
                </div>
                <div
                    class="flex justify-end gap-2 border-t py-1 px-1.5 font-bold"
                >
                    <div>প্রদান:</div>
                    <div>
                        <Input
                            type="number"
                            v-model="form.paid"
                            class="w-12 py-0.5 px-1 text-right"
                        />
                    </div>
                </div>
                <div
                    class="flex justify-end gap-2 border-t py-2 px-2 font-bold"
                >
                    <div>বকেয়া:</div>
                    <div>{{ $e2bnumber(dueSalary) }}</div>
                </div>
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
import FormGroup from "@/Components/FormGroup.vue";
import InlineData from "@/Components/InlineData.vue";

export default {
    components: {
        ValidationErrors,
        Button,
        Input,
        Select,
        FormGroup,
        InlineData,
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
        paidPurposeIds: {
            type: Array,
            default: [],
        },
    },
    created() {
        if (this.moduleAction == "store") {
            this.setDefaultSaraly();
        }

        if (this.moduleAction == "update") {
            this.form.salaries =
                this.data.staff.salaries.find((salary) => {
                    return salary.purpose_id === this.form.purpose_id;
                }) || [];
        }
    },
    computed: {
        totalSalary() {
            let total = this.form.salaries.reduce(function (prev, cur) {
                return prev + parseInt(cur.amount);
            }, 0);

            total = isNaN(total) ? 0 : total;

            this.form.total = total;

            return total;
        },

        dueSalary() {
            let total = this.totalSalary;

            let cut = parseInt(this.form.cut || 0);

            let paid = parseInt(this.form.paid || 0);

            let due = total - cut - paid;

            this.form.due = due;

            return due;
        },
    },
    data() {
        return {
            form: this.$inertia.form({
                purpose_id: "",
                salaries: [],
                total: "",
                paid: "",
                due: "",
                cut: 0,
            }),
        };
    },
    methods: {
        submit() {
            if (!this.form.purpose_id) {
                return alert("বাবদ নির্বাচন করুন");
            }

            if (this.moduleAction == "store") {
                return this.form.post(
                    this.route("staff.salaries.store", this.data.staff.id)
                );
            }

            return alert("Something wrong...!");

            if (this.moduleAction == "update") {
                return this.form.put(
                    this.route("staff.salaries.update", this.data.staff.id)
                );
            }
        },
        setDefaultSaraly() {
            this.form.salaries = [...(this.data.staff.default_salaries || [])];

            if (this.data.staff.due) {
                this.form.salaries.unshift({
                    title: "বকেয়া",
                    amount: this.data.staff.due,
                });
            }
        },
        purposeChangeHandler() {
            let selectedPurpose = Object.values(
                this.data.staff.paid_salaries
            ).find(
                (salary) =>
                    Number(salary.purpose_id) === Number(this.form.purpose_id)
            );

            if (selectedPurpose) {
                this.form.salaries = [...selectedPurpose.salaries];

                console.log(selectedPurpose.paid);

                if (selectedPurpose.paid) {
                    this.form.salaries.push({
                        title: "কর্তন",
                        amount: -selectedPurpose.cut,
                    });
                    this.form.salaries.push({
                        title: "বেতন প্রদান",
                        amount: -selectedPurpose.paid,
                    });
                }
            } else {
                this.setDefaultSaraly();
            }

            // if (
            //     Number(this.form.purpose_id) ===
            //     Number(this.data.staff.due_purpose_id)
            // ) {

            // } else {
            //     console.log("select purpose");
            // }
        },
    },
};
</script>
