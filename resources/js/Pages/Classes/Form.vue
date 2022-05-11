<template>
    <div class="w-full max-w-3xl rounded border bg-white p-4 shadow">
        <validation-errors class="mb-4" />

        <form @submit.prevent="submit" class="">
            <div class="grid gap-4">
                <div class="flex gap-2">
                    <form-group class="flex-grow" label="ক্লাস/বিভাগের নাম">
                        <Input
                            type="text"
                            class="block w-full"
                            v-model="form.name"
                            required
                        />
                    </form-group>
                </div>

                <form-group class="w-full" label="ক্লাস/বিভাগ সম্পর্কে তথ্য">
                    <Textarea
                        class="block h-40 w-full text-sm md:h-32 md:text-lg"
                        v-model="form.description"
                    ></Textarea>
                </form-group>

                <form-slot-group
                    label="বিষয় যুক্ত করুন"
                    :collections="form.subjects"
                    :addSlotMethod="addSubjectSlot"
                >
                    <template #default="{ item: subject }">
                        <form-group label="বিষয়ের নাম" class="w-1/3">
                            <Input
                                type="text"
                                class="block w-full"
                                v-model="subject.name"
                                required
                            />
                        </form-group>
                        <form-group
                            label="কিতাবের নাম (একাধিক হলে কমা ব্যবহার করুন)"
                            class="w-2/3"
                        >
                            <Input
                                type="text"
                                class="block w-full"
                                v-model="subject.book"
                                required
                            />
                        </form-group>
                    </template>
                </form-slot-group>

                <simple-table
                    :columns="columns1"
                    :collections="form.fees"
                    filter-row-name="period"
                    :filter-row-value="1"
                    :total-row="true"
                >
                    <template #header>
                        <th
                            v-for="(packageName, packageId) in data.packages"
                            :key="packageId"
                            class="py-3 px-2 text-center text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-400 print:text-black md:text-sm"
                        >
                            {{ packageName }}
                        </th>
                    </template>
                    <template #default="{ item: fee }">
                        <table-td class="whitespace-pre-wrap text-left">
                            <label
                                class="flex w-full items-center justify-start gap-2"
                            >
                                <Input
                                    type="checkbox"
                                    @click="fee.checked = !fee.checked"
                                    :checked="fee.checked"
                                />
                                <span>{{ fee.name }}</span>
                            </label>
                        </table-td>
                        <td class="px-3 text-center">
                            <div class="mx-auto w-20">
                                <Input
                                    v-if="fee.checked"
                                    type="number"
                                    v-model="fee.amount"
                                    class="w-20 text-right"
                                    required
                                />
                            </div>
                        </td>
                        <table-td
                            v-for="(packageName, packageId) in data.packages"
                            :key="packageId"
                            class="text-center"
                        >
                            <Input
                                v-if="fee.checked"
                                type="checkbox"
                                @change="packageHandler($event, fee, packageId)"
                                :checked="fee.package.includes(packageId)"
                            />
                        </table-td>
                    </template>
                    <template #totalRow>
                        <table-td class="text-right" colspan="2">
                            মোট ভর্তিকালীন প্রদেয়
                        </table-td>
                        <table-td
                            v-for="(packageName, packageId) in data.packages"
                            :key="packageId"
                            class="text-center"
                        >
                            {{ getFeeTotal(1, packageId) }}
                        </table-td>
                    </template>
                </simple-table>

                <simple-table
                    :columns="columns2"
                    :collections="form.fees"
                    filter-row-name="period"
                    :filter-row-value="2"
                    :total-row="true"
                >
                    <template #header>
                        <th
                            v-for="(packageName, packageId) in data.packages"
                            :key="packageId"
                            class="py-3 px-2 text-center text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-400 print:text-black md:text-sm"
                        >
                            {{ packageName }}
                        </th>
                    </template>
                    <template #default="{ item: fee }">
                        <table-td class="whitespace-pre-wrap text-left">
                            <label
                                class="flex w-full items-center justify-start gap-2"
                            >
                                <Input
                                    type="checkbox"
                                    @click="fee.checked = !fee.checked"
                                    :checked="fee.checked"
                                />
                                <span>{{ fee.name }}</span>
                            </label>
                        </table-td>
                        <td class="px-3 text-center">
                            <div class="mx-auto w-20">
                                <Input
                                    v-if="fee.checked"
                                    type="number"
                                    v-model="fee.amount"
                                    class="w-20 text-right"
                                    required
                                />
                            </div>
                        </td>
                        <table-td
                            v-for="(packageName, packageId) in data.packages"
                            :key="packageId"
                            class="text-center"
                        >
                            <Input
                                v-if="fee.checked"
                                type="checkbox"
                                @change="packageHandler($event, fee, packageId)"
                                :checked="fee.package.includes(packageId)"
                            />
                        </table-td>
                    </template>
                    <template #totalRow>
                        <table-td colspan="2" class="text-right">
                            মোট মাসিক প্রদেয়
                        </table-td>
                        <table-td
                            v-for="(packageName, packageId) in data.packages"
                            :key="packageId"
                            class="text-center"
                        >
                            {{ getFeeTotal(2, packageId) }}
                        </table-td>
                    </template>
                </simple-table>

                <form-group class="col-span-full" label="শ্রেণী শিক্ষক">
                    <Select v-model="form.staff_id" class="block w-full">
                        <option value="">-- নির্বাচন করুন --</option>
                        <option
                            v-for="(staff, index) in data.staffList"
                            :key="index"
                            :value="staff.id"
                        >
                            {{ staff.name }}
                        </option>
                    </Select>
                </form-group>
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
import { TrashIcon, PlusCircleIcon } from "@heroicons/vue/outline";
import Button from "@/Components/Button.vue";
import Input from "@/Components/Input.vue";
import Select from "@/Components/Select.vue";
import Textarea from "@/Components/Textarea.vue";
import AddButton from "@/Components/AddButton.vue";
import FormSlotGroup from "@/Components/FormSlotGroup.vue";
import FormGroup from "@/Components/FormGroup.vue";
import SimpleTable from "@/Components/SimpleTable.vue";
import TableTd from "@/Components/TableTd.vue";

export default {
    components: {
        ValidationErrors,
        Button,
        Input,
        Select,
        Textarea,
        TrashIcon,
        PlusCircleIcon,
        AddButton,
        FormSlotGroup,
        FormGroup,
        SimpleTable,
        TableTd,
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
    },
    created() {
        this.form.subjects = this.data.classes.subjects || [];

        Object.values(this.data.fees).forEach((fee) => {
            let classFee = Object.values(this.data.classes.classFees).filter(
                (classFee) => {
                    return classFee.feeId == fee.id;
                }
            )[0];

            this.form.fees.push({
                id: fee.id,
                name: fee.name,
                period: fee.period,
                amount: classFee ? classFee.amount : "",
                package: classFee ? classFee.package : [],
                checked: classFee ? 1 : 0,
            });
        });
    },
    data() {
        return {
            form: this.$inertia.form({
                name: this.data.classes.name,
                staff_id: this.data.classes.staffId,
                description: this.data.classes.description,
                subjects: [],
                fees: [],
            }),
            columns1: [
                { title: "ভর্তিকালীন প্রদেয়", align: "left" },
                { title: "পরিমাণ", align: "center" },
            ],
            columns2: [
                { title: "মাসিক প্রদেয়", align: "left" },
                { title: "পরিমাণ", align: "center" },
            ],
        };
    },
    methods: {
        addSubjectSlot() {
            this.form.subjects.push({
                name: "",
                book: "",
            });
        },
        packageHandler(event, fee, packageId) {
            if (event.target.checked) {
                return fee.package.push(packageId);
            }

            const index = fee.package.indexOf(packageId);

            if (index > -1) {
                fee.package.splice(index, 1);
            }
        },
        submit() {
            if (this.moduleAction == "store") {
                return this.form.post(this.route("classes.store"));
            }
            if (this.moduleAction == "update") {
                return this.form.put(
                    this.route("classes.update", this.data.classes.id)
                );
            }
        },
        getFeeTotal(period, packageId) {
            let total = 0;

            Object.values(this.form.fees).forEach((fee) => {
                if (
                    fee.checked &&
                    fee.period === period &&
                    fee.package.includes(packageId)
                ) {
                    total += fee.amount;
                }
            });

            return total;
        },
    },
};
</script>
