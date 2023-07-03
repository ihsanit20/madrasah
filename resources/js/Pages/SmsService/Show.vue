<template>
    <Head title="SMS Preview" />

    <app-layout pageTitle="SMS Preview">
        <div class="max-w-4xl rounded border bg-white p-3 shadow md:p-4">
            <form-heading class="mb-2 md:text-3xl">
                {{ data.sms_service.title }}
            </form-heading>
            <div class="grid">
                <inline-data title="প্রাপক সংখ্যা:" :value="$e2bnumber(receiverCounter)" />
                <inline-data title="ক্যারেক্টার সংখ্যা:" :value="$e2bnumber(data.sms_service.body.length)" />
                <inline-data title="SMS সংখ্যা:" :value="$e2bnumber(smsCounter)" />
                <inline-data title="Sender ID:" :value="data.sms_service.sender" />
                <inline-data title="SMS প্রাইস:" :value="`${$e2bnumber(smsPrice)} টাকা`" />
                <inline-data title="মোট খরচ:" :value="`${$e2bnumber(smsPrice * smsCounter * receiverCounter)} টাকা`" />
            </div>
            <div class="whitespace-pre-wrap p-2 border rounded-lg">
                {{ data.sms_service.body }}
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/App.vue";
import { Head } from "@inertiajs/inertia-vue3";
import ActionButtonEdit from "@/Components/ActionButtonEdit.vue";
import FormHeading from "@/Components/FormHeading.vue";
import InlineData from "@/Components/InlineData.vue";

export default {
    components: {
        AppLayout,
        Head,
        ActionButtonEdit,
        FormHeading,
        InlineData,
    },
    props: {
        data: {
            type: Object,
            default: {},
            characterPerSms: 160,
        },
    },
    created() {
        this.characterPerSms = this.getCharacterPerSms();
    },
    computed: {
        receiverCounter() {
            return Object.keys(this.data.sms_service.receivers).length;
        },
        smsCounter() {
            return Math.ceil(this.data.sms_service.body.length / this.characterPerSms);
        },
        smsPrice() {
            return this.data.sms_service.sender === 'MSZannat'
                ? 0.5
                : 0.25;
        },
    },
    methods: {
        checkIsOnlyEnglish() {
            const hasWithoutEnglish = (Boolean) (this.data.sms_service.body.match(/[^\x00-\x7F]+/gm));

            return (Boolean) (!hasWithoutEnglish);
        },
        getCharacterPerSms() {
            return this.checkIsOnlyEnglish()
                ? 160
                : 60;
        }
    }
};
</script>
