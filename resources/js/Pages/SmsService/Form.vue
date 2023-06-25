<template>
    <div class="w-full max-w-4xl rounded border bg-white p-4 shadow">
        <validation-errors class="mb-4" />

        <form @submit.prevent="submit" class="">
        
            <form-heading class="mb-2">সাধারণ বার্তা</form-heading>

            <div class="h-60 overflow-auto border p-4 mb-5">
                <div
                    v-for="(guardian, key) in data.guardians"
                    :key="key"
                    class="grid grid-cols-4 justify-between items-center"
                >
                    <div>{{ guardian.student_name }}</div>
                    <div>{{ guardian.student_class_id }}</div>
                    <div>{{ guardian.guardian_name }}</div>
                    <div>{{ guardian.guardian_phone }}</div>
                </div>
            </div>
        
            <div class="grid">
                <div class="bg-gray-200 flex justify-between items-center px-2 py-3 rounded-lg -mb-2">
                    <div class="">SMS লিখুন (<span class="text-rose-600">প্রতি SMS-এ বাংলা-৬০, ইংলিশ-১৬০</span>)</div>
                    <div>SMS সংখ্যা: </div>
                </div>
                <Textarea v-model="form.body" required/>
            </div>
            
            <form-group class="w-full mt-5" label="Sender ID">
                <Select v-model="form.sender" class="block w-full" required>
                    <option value="">-- নির্বাচন --</option>
                    <option
                        v-for="(sender, index) in data.senders"
                        :key="index"
                        :value="index"
                    >
                        {{ sender }}
                    </option>
                </Select>
            </form-group>

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
import Button from "@/Components/Button.vue";
import Input from "@/Components/Input.vue";
import Select from "@/Components/Select.vue";
import FormGroup from "@/Components/FormGroup.vue";
import Textarea from "@/Components/Textarea.vue";
import Label from "@/Components/Label.vue";
import FormHeading from '@/Components/FormHeading.vue';

export default {
    components: {
        ValidationErrors,
        Button,
        Input,
        Select,
        FormGroup,
        Textarea,
        Label,
        FormHeading,
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
    data() {
        return {
            form: this.$inertia.form({
                body: this.data.sms.body || "",
                sender: this.data.sms.sender || "",
            }),
        };
    },
    methods: {
        submit() {
            if (this.moduleAction == "store") {
                return this.form.post(this.route("sms-services.store"));
            }
            if (this.moduleAction == "update") {
                return this.form.put(
                    this.route("sms-services.update", this.data.sms.id)
                );
            }
        },
        toggleMonth(event) {
            const month = parseInt(event.target.value);
            const index = this.form.months.indexOf(month);
            if (index > -1) {
                this.form.months.splice(index, 1);
            } else {
                this.form.months.push(month);
            }
        },
    },
};
</script>
