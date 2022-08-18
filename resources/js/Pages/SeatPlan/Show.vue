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
                    <span class="text-sm"
                        >প্রয়োজনীয় ক্লাস নির্বাচন করুন ও ‘আসন নং তৈরি করুন’
                        বাটনে ক্লিক করুন
                    </span>
                    <button
                        type="submit"
                        class="bg-sky-400 py-1 px-3 text-white"
                    >
                        আসন নং তৈরি করুন
                    </button>
                </div>
            </form>
            <div>যে সকল ক্লাসের জন্য আসন নং করা হয়েছে</div>
            <div
                v-for="seatPlan in data.seat_plans"
                :key="seatPlan.id"
                class="py-1"
            >
                <div
                    class="grid gap-3 rounded border bg-white p-4 md:grid-cols-3"
                >
                    <div v-for="classId in seatPlan.classes" :key="classId">
                        <label class="flex items-center gap-2">
                            <Input
                                type="checkbox"
                                :value="classId"
                                :checked="true"
                                :disabled="true"
                                class="text-green-600"
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
        <div class="grid gap-4 print:grid-cols-3 md:grid-cols-3">
            <div
                v-for="(serial, index) in data.serials"
                :key="index"
                class="print:bottom-2 print:break-before-page print:border"
            >
                <SeatPlan
                    :data="serial"
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
import AppLayout from "@/Layouts/App.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
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

        this.total = Math.ceil(this.data.serials.length / 9);
    },
    data() {
        return {
            classNameArray: [],
            bgClors: [
                "bg-red-500/25",
                "bg-yellow-500/25",
                "bg-green-500/25",
                "bg-blue-500/25",
                "bg-indigo-500/25",
                "bg-orange-500/25",
                "bg-pink-500/25",
                "bg-purple-500/25",
                "bg-teal-500/25",
                "bg-gray-500/25",
            ],
            total: 0,
            form: this.$inertia.form({
                class_ids: [],
            }),
        };
    },
    methods: {
        submit() {
            return this.form.post(
                this.route("seat-plan.store", this.data.exam.id),
                {
                    onSuccess: () => {
                        this.form.reset("class_ids");
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
    },
};
</script>
