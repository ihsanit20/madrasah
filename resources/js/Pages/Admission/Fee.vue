<template>
    <div class="w-full max-w-3xl rounded border bg-white p-4 shadow">
        <validation-errors class="mb-4" />

        <form @submit.prevent="submit" class="space-y-4">
            <h2
                class="mt-4 mb-2 text-center text-2xl font-bold text-sky-600 print:text-black"
            >
                প্রদেয় ফি নির্ধারন
            </h2>
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <inline-data
                        title="ফরম নাম্বার:"
                        :value="data.admission.id"
                    />
                </div>
                <div>
                    <inline-data
                        title="ভর্তিচ্ছু বিভাগ/শ্রেণী:"
                        :value="data.admission.className"
                    />
                </div>
                <div>
                    <inline-data
                        title="শিক্ষার্থীর নাম:"
                        :value="data.student.name"
                    />
                </div>
                <div>
                    <inline-data
                        title="পিতার নাম:"
                        :value="data.student.fatherInfo.name"
                    />
                </div>
            </div>

            <hr />

            <div class="flex items-center justify-start">
                <label class="flex items-center gap-2">
                    <Input
                        type="checkbox"
                        :checked="editable"
                        @click="editable = !editable"
                    />
                    <span class="-mb-0.5">ছাড় পরিবর্তন চালু করুন</span>
                </label>
            </div>

            <div class="overflow-auto">
                <simple-table
                    class="min-w-max"
                    :columns="columns1"
                    :collections="fees.yearlyFees"
                >
                    <template #default="{ item: fee }">
                        <table-td class="text-left">
                            <label
                                class="flex w-full items-center justify-start gap-2"
                            >
                                <Input
                                    type="checkbox"
                                    @click="fee.checked = !fee.checked"
                                    :checked="fee.checked"
                                />
                                <span>{{ fee.fee_name }}</span>
                            </label>
                        </table-td>
                        <table-td class="text-right">
                            {{ fee.fee_amount }}
                        </table-td>
                        <td class="md:w-40">
                            <div
                                v-if="fee.checked"
                                class="flex items-center justify-end"
                            >
                                <Input
                                    :disabled="!editable"
                                    type="number"
                                    v-model="fee.concession"
                                    class="block w-20 text-right"
                                    @input="concessionHandler(fee)"
                                />
                            </div>
                        </td>
                        <table-td class="text-right">
                            <div v-if="fee.checked">
                                {{ fee.fee_amount - fee.concession }}
                            </div>
                        </table-td>
                    </template>
                </simple-table>
            </div>

            <div class="overflow-auto">
                <simple-table
                    class="min-w-max"
                    :columns="columns2"
                    :collections="fees.monthlyFees"
                >
                    <template #default="{ item: fee }">
                        <table-td class="text-left">
                            <label
                                class="flex w-full items-center justify-start gap-2"
                            >
                                <Input
                                    type="checkbox"
                                    @click="fee.checked = !fee.checked"
                                    :checked="fee.checked"
                                />
                                <span>{{ fee.fee_name }}</span>
                            </label>
                        </table-td>
                        <table-td class="text-right">
                            {{ fee.fee_amount }}
                        </table-td>
                        <td class="md:w-40">
                            <div
                                v-if="fee.checked"
                                class="flex items-center justify-end"
                            >
                                <Input
                                    :disabled="!editable"
                                    type="number"
                                    v-model="fee.concession"
                                    class="block w-20 text-right"
                                    @input="concessionHandler(fee)"
                                />
                            </div>
                        </td>
                        <table-td class="text-right">
                            <div v-if="fee.checked">
                                {{ fee.fee_amount - fee.concession }}
                            </div>
                        </table-td>
                    </template>
                </simple-table>
            </div>

            <hr />

            <div class="flex items-center justify-between">
                <Link
                    :href="
                        route('admissions.edit', data.admission.id) + '?step=2'
                    "
                    class="rounded-md border border-orange-600 px-4 py-2 font-semibold text-orange-600 hover:bg-orange-700 hover:text-white"
                >
                    &#8592; পূর্ববর্তী ধাপ
                </Link>
                <Button
                    :class="{
                        'opacity-25': form.processing,
                    }"
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
import SimpleTable from "@/Components/SimpleTable.vue";
import TableTd from "@/Components/TableTd.vue";

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
        SimpleTable,
        TableTd,
    },
    props: {
        moduleAction: String,
        buttonValue: {
            type: String,
            default: "সংরক্ষণ করুন",
        },
        data: {
            type: Object,
            default: {},
        },
    },
    created() {
        this.dataPushIntoFeeArray("yearlyFees");
        this.dataPushIntoFeeArray("monthlyFees");
    },
    data() {
        return {
            form: this.$inertia.form({
                step: 3,
                fees: [],
            }),
            fees: {
                yearlyFees: [],
                monthlyFees: [],
            },
            editable: false,
            columns1: [
                { title: "ভর্তিকালীন ফি বিবরণী", align: "left" },
                { title: "নির্ধারিত ফি", align: "right" },
                { title: "ছাড়", align: "right" },
                { title: "শিক্ষার্থীর প্রদেয়", align: "right" },
            ],
            columns2: [
                { title: "মাসিক ফি বিবরণী", align: "left" },
                { title: "নির্ধারিত ফি", align: "right" },
                { title: "ছাড়", align: "right" },
                { title: "শিক্ষার্থীর প্রদেয়", align: "right" },
            ],
        };
    },
    methods: {
        submit() {
            if (this.moduleAction == "update") {
                this.updateFeeData();

                return this.form.put(
                    this.route("admissions.update", this.data.admission.id)
                );
            }
        },

        concessionHandler(fee) {
            if (fee.concession > fee.fee_amount) {
                fee.concession = fee.fee_amount;
            }

            if (!fee.concession || fee.concession < 0) {
                fee.concession = 0;
            }

            fee.concession = Number(fee.concession);
        },

        dataPushIntoFeeArray(option) {
            Object.values(this.data[option]).forEach((fee) => {
                this.fees[option].push({
                    fee_id: fee.id,
                    fee_name: fee.name,
                    fee_amount: fee.amount,
                    concession: 0,
                    checked: 0,
                });
            });
        },

        updateFeeData() {
            this.form.fees.length = 0;

            this.dataPushIntoFormFees("yearlyFees");
            this.dataPushIntoFormFees("monthlyFees");
        },

        dataPushIntoFormFees(option) {
            this.fees[option].forEach((fee) => {
                if (fee.checked) {
                    this.form.fees.push({
                        id: fee.fee_id,
                        concession: fee.concession,
                    });
                }
            });
        },
    },
};
</script>
