<template>
    <Head title="আয়-ব্যয় সামারি" />

    <app-layout pageTitle="আয়-ব্যয় সামারি">
        <div>
            <div class="w-full grid grid-cols-2 gap-2 md:grid-cols-4">
                <Input
                    type="date"
                    class="w-full"
                    @input="search"
                    v-model="data.from"
                />
                <Input
                    type="date"
                    class="w-full"
                    @input="search"
                    v-model="data.to"
                />
                <div
                    class="col-span-2 rounded-md border py-2 text-center text-white shadow"
                    :class="{
                        'bg-brand-600': totalIncome >= totalExpence,
                        'bg-rose-600': totalIncome < totalExpence,
                    }"
                >
                    {{ totalIncome >= totalExpence ? "উদ্বৃত্ত" : "ঘাটতি" }}
                    {{ $e2bnumber(Math.abs(totalIncome - totalExpence)) }}
                </div>
            </div>

            <hr class="my-3" />

            <div class="w-full grid gap-3 print:grid-cols-2 md:grid-cols-2">
                <simple-table
                    :collections="data.incomes"
                    :totalRow="true"
                    :columns="incomeColumns"
                >
                    <template #default="{ item: income }">
                        <table-td class="text-right">
                            {{ income.name }}
                        </table-td>
                        <table-td class="text-right">
                            <div class="flex justify-end gap-2">
                                {{ $e2bnumber(income.total) }}
                                <span>টাকা</span>
                            </div>
                        </table-td>
                    </template>
                    <template #totalRow>
                        <table-td class="bg-gray-200 text-right">
                            <span class="font-bold">মোট</span>
                        </table-td>
                        <table-td class="bg-gray-200 text-right">
                            <div class="flex justify-end gap-2 font-bold">
                                {{ $e2bnumber(totalIncome) }}
                                <span>টাকা</span>
                            </div>
                        </table-td>
                    </template>
                </simple-table>
                <simple-table
                    :collections="data.expenses"
                    :totalRow="true"
                    :columns="expenseColumns"
                >
                    <template #default="{ item: expense }">
                        <table-td class="text-right">
                            {{ expense.name }}
                        </table-td>
                        <table-td class="text-right">
                            <div class="flex justify-end gap-2">
                                {{ $e2bnumber(expense.total) }}
                                <span>টাকা</span>
                            </div>
                        </table-td>
                    </template>
                    <template #totalRow>
                        <table-td class="bg-gray-200 text-right">
                            <span class="font-bold">মোট</span>
                        </table-td>
                        <table-td class="bg-gray-200 text-right">
                            <div class="flex justify-end gap-2 font-bold">
                                {{ $e2bnumber(totalExpence) }}
                                <span>টাকা</span>
                            </div>
                        </table-td>
                    </template>
                </simple-table>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/GridApp.vue";
import { MoneyReceiptSvg } from "@/Layouts/Navigation/SvgIcon";
import { Head, Link } from "@inertiajs/inertia-vue3";
import SimpleTable from "@/Components/SimpleTable.vue";
import TableTd from "@/Components/TableTd.vue";
import Select from "@/Components/Select.vue";
import Input from "@/Components/Input.vue";

export default {
    components: {
        AppLayout,
        Head,
        Link,
        MoneyReceiptSvg,
        SimpleTable,
        TableTd,
        Select,
        Input,
    },
    props: {
        data: {
            type: Object,
            default: {},
        },
    },
    computed: {
        totalExpence() {
            let total = 0;

            Object.values(this.data.expenses).forEach((category) => {
                total += parseInt(category.total || 0);
            });

            return total;
        },
        totalIncome() {
            let total = 0;

            Object.values(this.data.incomes).forEach((classes) => {
                total += parseInt(classes.total || 0);
            });

            return total;
        },
    },
    data() {
        return {
            expenseColumns: [
                { title: "ব্যয়ের খাত", align: "right" },
                { title: "পরিমাণ", align: "right" },
            ],
            incomeColumns: [
                { title: "আয়ের খাত", align: "right" },
                { title: "পরিমাণ", align: "right" },
            ],
        };
    },
    methods: {
        search() {
            console.log({
                from: this.data.from,
                to: this.data.to,
            });

            return this.$inertia.get(this.route("summary"), {
                from: this.data.from,
                to: this.data.to,
            });
        },
    },
};
</script>
