<template>
    <div class="w-full max-w-xl rounded border bg-white p-4 shadow">
        <h3 class="text-center text-2xl font-bold text-brand-600">
            বেতন নির্ধারণ
        </h3>

        <div class="grid md:grid-cols-2">
            <inline-data title="নাম:" :value="data.staff.name" />
            <inline-data class="justify-end" title="ফোন:" :value="data.staff.phone" />
            <inline-data
                title="পদ:"
                :value="data.staff.designation_title"
            />
            <inline-data
                class="justify-end"
                title="প্রত্যাশা:"
                :value="data.staff.expected_salary"
            />
            <inline-data
                class="justify-center col-span-full"
                title="মোট বেতন:"
                :value="$e2bnumber(totalSalary)"
            />
        </div>

        <hr class="my-3" />

        <validation-errors class="mb-4" />

        <form @submit.prevent="submit" class="">
            <div class="flex gap-4">
                <form-slot-group
                    :collections="form.default_salaries"
                    :addSlotMethod="addSalarySlot"
                    class="w-full"
                >
                    <template #header>
                        <div class="flex items-center">
                            <label
                                class="flex-shrink flex-grow bg-white px-2 font-bold line-clamp-1"
                            >
                                বেতন বিবরণ
                            </label>
                            <label
                                class="w-28 flex-shrink-0 flex-grow-0 bg-white px-2 font-bold line-clamp-1"
                            >
                                পরিমাণ
                            </label>
                        </div>
                    </template>
                    <template #default="{ item: salary }">
                        <form-group class="w-full flex-shrink flex-grow">
                            <Input
                                type="text"
                                class="block w-full"
                                v-model="salary.title"
                                required
                            />
                        </form-group>
                        <form-group class="w-20 flex-shrink-0 flex-grow-0">
                            <Input
                                type="number"
                                class="block w-full text-center"
                                v-model="salary.amount"
                                required
                            />
                        </form-group>
                    </template>
                </form-slot-group>
            </div>

            <hr class="my-4 w-full" />

            <div class="flex items-center justify-between print:hidden">
                <Link
                    :href="
                        route('staff-form.show', data.staff.id)
                    "
                    class="rounded-md border border-brand-600 px-4 py-2 font-semibold text-brand-600 hover:bg-brand-700 hover:text-white"
                >
                    &#8592; পূর্ববর্তী ধাপ
                </Link>
                <Button
                    v-if="form.default_salaries.length"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Save & পরবর্তী ধাপ &#8594;
                </Button>
            </div>
        </form>
    </div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3"
import ValidationErrors from "@/Components/ValidationErrors.vue";
import Button from "@/Components/Button.vue";
import Input from "@/Components/Input.vue";
import Select from "@/Components/Select.vue";
import FormSlotGroup from "@/Components/FormSlotGroup.vue";
import Textarea from "@/Components/Textarea.vue";
import InlineData from "@/Components/InlineData.vue";
import FormGroup from "@/Components/FormGroup.vue";

export default {
    components: {
        Link,
        ValidationErrors,
        Button,
        Input,
        Select,
        FormSlotGroup,
        Textarea,
        InlineData,
        FormGroup,
    },
    props: {
        buttonValue: {
            type: String,
            default: "Save",
        },
        data: {
            type: Object,
            default: {},
        },
    },
    computed: {
        totalSalary() {
            let total = this.form.default_salaries.reduce(function (prev, cur) {
                return prev + parseInt(cur.amount || 0);
            }, 0);

            return isNaN(total) ? 0 : total;
        },
    },
    created() {
        this.form.default_salaries = this.data.staff.default_salaries ?? [];
    },
    data() {
        return {
            form: this.$inertia.form({
                step: "salary",
                default_salaries: [],
            }),
        };
    },
    methods: {
        addSalarySlot() {
            this.form.default_salaries.push({
                title: "",
                amount: "",
            });
        },
        submit() {
            return this.form.put(
                this.route("staff-form.update", this.data.staff.id)
            );
        },
    },
};
</script>
