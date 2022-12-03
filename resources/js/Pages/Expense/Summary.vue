<template>
    <Head title="ব্যয় সামারি" />

    <app-layout pageTitle="ব্যয় সামারি">
        <div class="max-w-xs space-y-2">
            <div class="grid grid-cols-2 gap-2">
                <Input type="date" class="w-full" @input="search" v-model="data.from" />
                <Input type="date" class="w-full" @input="search" v-model="data.to" />
            </div>

            <simple-table
                :collections="data.categories"
                :totalRow="true"
                :columns="columns"
            >
                <template #default="{ item: category }">
                    <table-td class="text-right">
                        {{ category.name }}
                    </table-td>
                    <table-td class="text-right">
                        <div class="flex justify-end gap-2">
                            {{ $e2bnumber(category.total) }}
                            <span>টাকা</span>
                        </div>
                    </table-td>
                </template>
                <template #totalRow>
                    <table-td class="text-right">
                        <span class="font-bold">মোট</span>
                    </table-td>
                    <table-td class="text-right">
                        <div class="flex justify-end gap-2 font-bold">
                            {{ $e2bnumber(total) }}
                            <span>টাকা</span>
                        </div>
                    </table-td>
                </template>
            </simple-table>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/App.vue";
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
        total() {
            let total = 0;

            Object.values(this.data.categories).forEach((category) => {
                total += parseInt(category.total || 0);
            });

            return total;
        },
    },
    data() {
        return {
            columns: [
                { title: "ব্যয়ের খাত", align: "right" },
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

            return this.$inertia.get(this.route("expenses.summary"), {
                from: this.data.from,
                to: this.data.to,
            });
        },
    },
};
</script>
