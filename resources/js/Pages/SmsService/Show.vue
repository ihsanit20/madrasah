<template>
    <Head title="SMS Preview" />

    <app-layout pageTitle="SMS Preview">
        <div class="max-w-3xl rounded border bg-white p-3 shadow md:p-4">
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
            <hr class="my-3">
                <div class="flex items-center justify-between">
                    <Link
                        :href="route('sms-services.index')"
                        class="w-40 bg-gray-400 text-white text-center rounded-lg pt-3 pb-2"
                    >
                        Back
                    </Link>
                    <button
                        v-if="data.sms_service.status === 1"
                        @click="deleteSms"
                        type="button"
                        class="w-40 bg-rose-500 text-white text-center rounded-lg pt-3 pb-2"
                    >
                        Delete
                    </button>
                    <button
                        v-if="data.sms_service.status === 1"
                        @click="sendSms"
                        type="button"
                        class="w-40 bg-green-600 text-white text-center rounded-lg pt-3 pb-2"
                    >
                        Send
                    </button>
                    <ul
                        v-if="data.sms_service.status === 2"
                        class="list-disc"
                    >
                        <li
                            class="pt-3 pb-2 text-green-600"
                        >
                            {{ data.sms_service.status_text }}
                        </li>
                    </ul>
                </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/App.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import ActionButtonEdit from "@/Components/ActionButtonEdit.vue";
import FormHeading from "@/Components/FormHeading.vue";
import InlineData from "@/Components/InlineData.vue";
import Button from "@/Components/Button.vue";

export default {
    components: {
        AppLayout,
        Head,
        Link,
        Button,
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
    data() {
        return {
            form: this.$inertia.form({
                status: this.data.sms_service.status,
            }),
        };
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
                ? 0.56
                : 0.25;
        },
    },
    methods: {
        deleteSms() {
            if(confirm("Are you want to delete?")) {
                return this.form.delete(
                    this.route("sms-services.destroy", this.data.sms_service.id)
                );
            }
            
            return "";
        },
        sendSms() {
            return this.form.put(
                this.route("sms-services.update", this.data.sms_service.id)
            );
        },
        checkIsOnlyEnglish() {
            const hasWithoutEnglish = (Boolean) (this.data.sms_service.body.match(/[^\x00-\x7F]+/gm));

            return (Boolean) (!hasWithoutEnglish);
        },
        getCharacterPerSms() {
            return this.checkIsOnlyEnglish()
                ? 160
                : 60;
        },
    }
};
</script>
