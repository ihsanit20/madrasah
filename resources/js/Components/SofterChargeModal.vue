<script setup>
import { computed, ref } from "vue";

const show = ref(true);

const props = defineProps({
    software_charge: {
        type: Object,
        default: {},
    },
});

const totalAmount = computed(
    () =>
        parseInt(props.software_charge?.total_student || 0) *
        (props.software_charge?.per_student_charge || 0)
);

const emit = defineEmits(["close"]);

const closeModal = () => {
    show.value = false;
};

const proceedToPayment = async () => {
    if (props.software_charge?.id) {
        window.location.href = `/software-charges/${props.software_charge.id}/bkash/create-payment`;
    }
};

const isWithin15Days = computed(() => {
    if (!props.software_charge?.created_at) {
        return false;
    }

    const createdAt = new Date(props.software_charge.created_at);
    const currentDate = new Date();

    const diffTime = currentDate - createdAt;
    const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));

    return diffDays <= 15;
});
</script>

<template>
    <div
        v-if="show"
        class="fixed inset-0 z-[9999] flex h-full w-full items-center justify-center bg-black/75"
    >
        <div class="relative w-full max-w-sm rounded-lg border bg-white p-4">
            <div class="flex items-center justify-between">
                <h1 class="text-center text-xl font-semibold">
                    মাসিক সাবস্ক্রিপশন চার্জ
                </h1>
                <button
                    v-if="isWithin15Days"
                    @click="closeModal"
                    class="text-gray-500 hover:text-gray-800"
                >
                    <svg
                        class="h-6 w-6"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"
                        ></path>
                    </svg>
                </button>
            </div>
            <hr class="my-3" />
            <div class="mb-4 space-y-2 text-center">
                <p class="text-lg">
                    মাস:
                    <strong>{{ software_charge?.purpose }}</strong>
                </p>
                <p class="text-lg">
                    শিক্ষার্থী সংখ্যা:
                    <strong>{{ software_charge?.total_student }}</strong>
                </p>
                <p class="text-lg">
                    চার্জ (শিক্ষার্থী প্রতি):
                    <strong>
                        {{ software_charge?.per_student_charge }} TK
                    </strong>
                </p>
                <p class="text-lg">
                    মোট চার্জ:
                    <strong>{{ Math.round(totalAmount) }} TK</strong>
                </p>
            </div>
            <hr class="my-3" />
            <div class="flex flex-col items-center justify-center space-y-2">
                <p>বিকাশের মাধ্যমে পেমেন্ট করুন</p>
                <button @click="proceedToPayment">
                    <img class="w-44" src="/images/bkash_payment_logo.png" />
                </button>
            </div>
        </div>
    </div>
</template>
