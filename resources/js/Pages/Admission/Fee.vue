<template>
    <div
        class="w-full max-w-3xl rounded border bg-white p-4 print:rounded-none print:border-0"
    >
        <validation-errors class="mb-4" />

        <form @submit.prevent="submit" class="space-y-4">
            <h2
                class="mt-4 mb-2 text-center text-2xl font-bold text-sky-600 print:text-black"
            >
                প্রদেয় ফি নির্ধারন
            </h2>
            <div class="grid gap-4 print:grid-cols-2 md:grid-cols-3">
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

            <hr class="print:hidden" />

            <div class="flex items-center justify-start print:hidden">
                <label class="flex items-center gap-2">
                    <Input
                        type="checkbox"
                        :checked="editable"
                        @click="editable = !editable"
                    />
                    <span class="-mb-0.5">ছাড় পরিবর্তন চালু করুন</span>
                </label>
            </div>

            <div class="grid gap-4 print:grid-cols-2 md:grid-cols-2">
                <simple-table
                    :columns="columns1"
                    :collections="fees.yearlyFees"
                    :totalRow="true"
                >
                    <template #header>
                        <table-th
                            v-if="editable"
                            class="text-right print:hidden"
                        >
                            ছাড়
                        </table-th>
                    </template>
                    <template #default="{ item: fee }">
                        <table-td class="text-left">
                            {{ fee.fee_name }}
                        </table-td>
                        <table-td class="text-right">
                            <div class="flex justify-end gap-2">
                                <del
                                    v-if="fee.concession"
                                    class="text-gray-400 print:hidden"
                                >
                                    {{ $e2bnumber(fee.fee_amount) }}
                                </del>
                                <span>
                                    {{
                                        $e2bnumber(
                                            fee.fee_amount - fee.concession
                                        )
                                    }}
                                </span>
                            </div>
                        </table-td>
                        <td class="pr-3 print:hidden" v-if="editable">
                            <div class="flex items-center justify-end">
                                <Input
                                    :disabled="!editable"
                                    type="number"
                                    v-model="fee.concession"
                                    class="block w-14 px-1 text-right"
                                    @input="concessionHandler(fee)"
                                />
                            </div>
                        </td>
                    </template>
                    <template #totalRow>
                        <table-th class="text-left">
                            <div v-if="getConcessionTotal('yearlyFees')">
                                ছাড়:
                                {{
                                    $e2bnumber(getConcessionTotal("yearlyFees"))
                                }}
                            </div>
                        </table-th>
                        <table-th class="text-right">
                            <div class="flex justify-end gap-2">
                                <span>মোট: </span>
                                <del
                                    v-if="getConcessionTotal('yearlyFees')"
                                    class="text-gray-400 print:hidden"
                                >
                                    {{ $e2bnumber(getFeeTotal("yearlyFees")) }}
                                </del>
                                <span>
                                    {{
                                        $e2bnumber(
                                            getFeeTotal("yearlyFees") -
                                                getConcessionTotal("yearlyFees")
                                        )
                                    }}
                                </span>
                            </div>
                        </table-th>
                        <th
                            v-if="editable"
                            class="pr-4 text-right text-rose-500 print:hidden"
                        >
                            {{ getConcessionTotal("yearlyFees") }}
                        </th>
                    </template>
                </simple-table>

                <simple-table
                    :columns="columns2"
                    :collections="fees.monthlyFees"
                    :totalRow="true"
                >
                    <template #header>
                        <table-th
                            v-if="editable"
                            class="text-right print:hidden"
                        >
                            ছাড়
                        </table-th>
                    </template>
                    <template #default="{ item: fee }">
                        <table-td class="text-left">
                            {{ fee.fee_name }}
                        </table-td>
                        <table-td class="text-right">
                            <div class="flex justify-end gap-2">
                                <del
                                    v-if="fee.concession"
                                    class="text-gray-400 print:hidden"
                                >
                                    {{ $e2bnumber(fee.fee_amount) }}
                                </del>
                                <span>
                                    {{
                                        $e2bnumber(
                                            fee.fee_amount - fee.concession
                                        )
                                    }}
                                </span>
                            </div>
                        </table-td>
                        <td class="pr-3 print:hidden" v-if="editable">
                            <div class="flex items-center justify-end">
                                <Input
                                    :disabled="!editable"
                                    type="number"
                                    v-model="fee.concession"
                                    class="block w-14 px-1 text-right"
                                    @input="concessionHandler(fee)"
                                />
                            </div>
                        </td>
                    </template>
                    <template #totalRow>
                        <table-th class="text-left">
                            <div v-if="getConcessionTotal('monthlyFees')">
                                ছাড়:
                                {{
                                    $e2bnumber(
                                        getConcessionTotal("monthlyFees")
                                    )
                                }}
                            </div>
                        </table-th>
                        <table-th class="text-right">
                            <div class="flex justify-end gap-2">
                                <span>মোট: </span>
                                <del
                                    v-if="getConcessionTotal('monthlyFees')"
                                    class="text-gray-400 print:hidden"
                                >
                                    {{ $e2bnumber(getFeeTotal("monthlyFees")) }}
                                </del>
                                <span>
                                    {{
                                        $e2bnumber(
                                            getFeeTotal("monthlyFees") -
                                                getConcessionTotal(
                                                    "monthlyFees"
                                                )
                                        )
                                    }}
                                </span>
                            </div>
                        </table-th>
                        <th
                            v-if="editable"
                            class="pr-4 text-right text-rose-500 print:hidden"
                        >
                            {{ getConcessionTotal("monthlyFees") }}
                        </th>
                    </template>
                </simple-table>
            </div>

            <div class="hidden space-y-4 print:block">
                <h3
                    class="mt-8 hidden text-center text-2xl font-bold text-sky-600 print:block print:text-black"
                >
                    অভিভাবকের অঙ্গিকার
                </h3>
                <div class="whitespace-pre-wrap text-justify">
                    {{ $page.props.settings.guardianAgreement }}
                </div>
                <div class="flex justify-between">
                    <div class="pt-8">
                        <inline-data
                            title="অভিভাবকের নাম:"
                            :value="data.student.guardianInfo.name"
                        />
                    </div>
                    <div class="pt-8">
                        <inline-data title="অভিভাবকের স্বাক্ষর" />
                    </div>
                </div>
            </div>

            <hr class="print:hidden" />

            <div class="flex items-center justify-between print:hidden">
                <Link
                    :href="
                        route('admissions.edit', data.admission.id) + '?step=2'
                    "
                    class="rounded-md border border-orange-600 px-4 py-2 font-semibold text-orange-600 hover:bg-orange-700 hover:text-white"
                >
                    &#8592; পূর্ববর্তী ধাপ
                </Link>
                <print-button />
                <Button
                    :class="{
                        'opacity-25': form.processing,
                    }"
                    :disabled="form.processing"
                    v-html="buttonValue"
                ></Button>
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
import TableTh from "@/Components/TableTh.vue";
import PrintButton from "@/Components/PrintButton.vue";

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
        TableTh,
        PrintButton,
    },
    props: {
        moduleAction: String,
        buttonValue: {
            type: String,
            default: "পরবর্তী ধাপ &#8594;",
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
                { title: "ভর্তিকালীন প্রদেয়", align: "left" },
                { title: "নির্ধারিত টাকা", align: "right" },
            ],
            columns2: [
                { title: "মাসিক প্রদেয়", align: "left" },
                { title: "নির্ধারিত টাকা", align: "right" },
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
                let concession = this.data.admission.concessions.filter(
                    (item) => item.id === fee.id
                )[0];

                this.fees[option].push({
                    fee_id: fee.id,
                    fee_name: fee.name,
                    fee_amount: fee.amount,
                    concession: concession ? concession.amount : 0,
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
                if (fee.concession) {
                    this.form.fees.push({
                        id: fee.fee_id,
                        amount: fee.concession,
                    });
                }
            });
        },

        getFeeTotal(option) {
            let total = 0;

            Object.values(this.fees[option]).forEach((fee) => {
                total += parseInt(fee.fee_amount);
            });

            return total;
        },

        getConcessionTotal(option) {
            let total = 0;

            Object.values(this.fees[option]).forEach((fee) => {
                total += parseInt(fee.concession);
            });

            return total;
        },
    },
};
</script>
