<template>
    <div class="w-full max-w-xl rounded border bg-white p-4 shadow">
        <validation-errors class="mb-4" />

        <form @submit.prevent="submit" class="">
            <div class="grid gap-4">
                <form-group class="w-full" label="প্রকাশের তারিখ">
                    <Input
                        type="date"
                        class="block w-full"
                        v-model="form.date"
                        required
                    />
                </form-group>
                <form-group class="w-full" label="বিষয়">
                    <Input
                        type="text"
                        class="block w-full"
                        v-model="form.title"
                        required
                    />
                </form-group>
                <form-group class="w-full" label="বিস্তারিত বিজ্ঞপ্তি">
                    <Textarea
                        class="block h-40 w-full text-sm md:h-32 md:text-lg"
                        v-model="form.body"
                        @keyup="resizeTextarea"
                        @focus="resizeTextarea"
                    ></Textarea>
                </form-group>
                <form-group class="w-full" label="আদেশক্রমে">
                    <Select
                        required
                        class="block w-full"
                        v-model="form.staff_id"
                    >
                        <option value="">-- Select --</option>
                        <option
                            v-for="(staff, index) in data.staffList"
                            :key="index"
                            :value="staff.id"
                        >
                            {{ staff.name }} ({{ staff.designationTitle }})
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
import Button from "@/Components/Button.vue";
import Input from "@/Components/Input.vue";
import Select from "@/Components/Select.vue";
import FormGroup from "@/Components/FormGroup.vue";
import Textarea from "@/Components/Textarea.vue";

export default {
    components: {
        ValidationErrors,
        Button,
        Input,
        Select,
        FormGroup,
        Textarea,
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
        if (this.moduleAction == "store") {
            this.form.staff_id = 1;
        }
    },
    data() {
        return {
            form: this.$inertia.form({
                date: this.data.notice.date || "",
                title: this.data.notice.title || "",
                body: this.data.notice.body || "",
                staff_id: this.data.notice.staffId || "",
            }),
        };
    },
    methods: {
        submit() {
            if (this.moduleAction == "store") {
                return this.form.post(this.route("notices.store"));
            }
            if (this.moduleAction == "update") {
                return this.form.put(
                    this.route("notices.update", this.data.notice.id)
                );
            }
        },
        resizeTextarea(e) {
            let area = e.target;
            area.style.overflow = "hidden";
            area.style.height = area.scrollHeight + "px";
            console.log(area.scrollHeight);
            console.dir(area);
        },
    },
};
</script>
