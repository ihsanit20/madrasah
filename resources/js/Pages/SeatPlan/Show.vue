<template>
    <Head title="Student" />

    <app-layout>
        <div class="w-full max-w-5xl rounded print:hidden">
            <div v-if="Object.keys(data.exam_classes).length">
                যে সকল ক্লাসের জন্য আসন নং করা হয় নাই
            </div>
            <form
                v-if="Object.keys(data.exam_classes).length"
                @submit.prevent="submit"
                class="mb-8"
            >
                <div class="grid gap-3 bg-white p-4 md:grid-cols-3">
                    <div
                        v-for="examClass in data.exam_classes"
                        :key="examClass.id"
                    >
                        <label class="flex items-center gap-2">
                            <Input
                                type="checkbox"
                                @change="changeClass"
                                :value="examClass.id"
                                :checked="
                                    form.class_ids.includes(
                                        Number(examClass.id) ||
                                            String(examClass.id)
                                    )
                                "
                            />
                            <span>{{ examClass.name }}</span>
                        </label>
                    </div>
                </div>
                <div class="mt-2 flex items-center justify-between">
                    <span class="text-sm">
                        প্রয়োজনীয় ক্লাস নির্বাচন করুন ও ‘আসন নং তৈরি করুন’ বাটনে
                        ক্লিক করুন
                    </span>
                    <button
                        type="submit"
                        class="bg-brand-600 py-1 px-3 text-white"
                        :class="{
                            'cursor-not-allowed opacity-50':
                                !form.class_ids.length,
                        }"
                        :disabled="!form.class_ids.length"
                    >
                        আসন নং তৈরি করুন
                    </button>
                </div>
            </form>

            <div
                v-if="Object.keys(data.seat_plans).length"
                class="mt-2 flex items-center justify-between"
            >
                <div>যে সকল ক্লাসের জন্য আসন নং করা হয়েছে</div>
                <form @submit.prevent="destroy">
                    <button
                        type="submit"
                        class="bg-rose-600 py-1 px-3 text-white"
                    >
                        আসন রিসেট করুন
                    </button>
                </form>
            </div>

            <div
                v-for="(seatPlan, index) in data.seat_plans"
                :key="index"
                class="py-1"
            >
                <div
                    class="grid gap-2 rounded border bg-white p-4 md:grid-cols-3"
                >
                    <div class="col-span-full">
                        আসন নং
                        <span class="rounded-md border px-3 py-0.5">
                            {{ $e2bnumber(getLimit(index)) }}
                        </span>
                    </div>
                    <hr class="col-span-full" />
                    <div v-for="classId in seatPlan.classes" :key="classId">
                        <label class="flex items-center gap-2">
                            <Input
                                type="checkbox"
                                :value="classId"
                                :checked="true"
                                :disabled="true"
                                class="text-brand-600"
                            />
                            <span>
                                {{
                                    data.classes.find(
                                        (examClass) =>
                                            Number(examClass.id) ==
                                            Number(classId)
                                    ).name
                                }}
                            </span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="grid gap-x-4 gap-y-[28px] print:grid-cols-3 md:grid-cols-3">
            <div
                v-for="(serial, index) in data.serials"
                :key="index"
                class="print:bottom-2 print:border"
            >
                <SeatPlan
                    :data="serial"
                    :exam="data.exam"
                    :bgClorClass="
                        bgClors[classNameArray.indexOf(serial.class_name)]
                    "
                    :seatNo="Number(index) + 1"
                />
            </div>
        </div>
        <div class="w-full max-w-5xl rounded py-6 print:hidden">
            <print-button />
        </div>
    </app-layout>
</template>

<script>
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import AvatarView from "@/Components/AvatarView.vue";
import PrintButton from "@/Components/PrintButton.vue";
import AppLayout from "@/Layouts/GridApp.vue";
import { Head, Link } from "@inertiajs/vue3";
import SeatPlan from "../../Templete/SeatPlan.vue";
import Input from "@/Components/Input.vue";
import Button from "@/Components/Button.vue";
export default {
    components: {
        Head,
        Link,
        AppLayout,
        ApplicationLogo,
        AvatarView,
        SeatPlan,
        PrintButton,
        Input,
        Button,
    },
    props: {
        data: {
            type: Object,
            default: {},
        },
    },
    created() {
        Object.values(this.data.serials).forEach((serial) => {
            this.classNameArray.push(serial.class_name);
        });

        this.classNameArray = [...new Set(this.classNameArray)];

        this.setLimit();
    },
    data() {
        return {
            classNameArray: [],
            total: 0,
            limit: [],
            form: this.$inertia.form({
                class_ids: [],
            }),
            destroy_form: this.$inertia.form({}),
            bgClors: [
                "bg-red-500/25",
                "bg-yellow-500/25",
                "bg-brand-600/25",
                "bg-brand-500/25",
                "bg-indigo-500/25",
                "bg-brand-600/25",
                "bg-pink-500/25",
                "bg-purple-500/25",
                "bg-teal-500/25",
                "bg-gray-500/25",
                "bg-rose-400/25",
                "bg-brand-400/25",
                "bg-lime-400/25",
                "bg-indigo-400/25",
                "bg-brand-400/25",
                "bg-pink-400/25",
                "bg-purple-400/25",
                "bg-teal-400/25",
                "bg-gray-400/25",
                "bg-red-400/25",
                "bg-yellow-400/25",
            ],
        };
    },
    methods: {
        submit() {
            return this.form.post(
                this.route("seat-plan.store", this.data.exam.id),
                {
                    onSuccess: () => {
                        this.form.reset("class_ids");
                        this.setLimit();
                    },
                }
            );
        },
        changeClass(event) {
            if (event.target.checked) {
                return this.form.class_ids.push(Number(event.target.value));
            }

            let index = this.form.class_ids.indexOf(event.target.value);

            return this.form.class_ids.splice(index, 1);
        },
        destroy() {
            if (!confirm("আপনি কি আসন রিসেট করতে চান?")) {
                return;
            }

            return this.destroy_form.delete(
                this.route("seat-plan.destroy", this.data.exam.id)
            );
        },
        getLimit(index) {
            return this.limit[index];
        },
        setLimit() {
            this.limit = [];
            this.total = 0;

            this.data.seat_plans.forEach((seatPlan) => {
                let initial = String(this.total + 1).padStart(3, "0");

                Object.keys(seatPlan.seats).forEach((seatNo) => {
                    this.total++;
                });

                let final = String(this.total).padStart(3, "0");

                this.limit.push(`${initial} - ${final}`);
            });
        },
    },
};
</script>
