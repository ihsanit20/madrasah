<template>
    <Head title="Student" />

    <app-layout>
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
export default {
    components: {
        Head,
        Link,
        AppLayout,
        ApplicationLogo,
        AvatarView,
        SeatPlan,
        PrintButton,
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
        };
    },
};
</script>
