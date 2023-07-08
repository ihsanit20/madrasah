<template>
    <div class="w-full max-w-4xl rounded border bg-white p-4 shadow">
        <validation-errors class="mb-4" />

        <form @submit.prevent="submit" class="">
        
            <form-heading class="mb-2 md:text-3xl">সাধারণ বার্তা</form-heading>

            <div class="grid grid-cols-3 gap-3">
                <div class="relative">
                    <div
                        class="px-6 py-2 rounded-lg border flex justify-between items-center cursor-pointer"
                        @click="isShowClassFilter = !isShowClassFilter"
                    >
                        <span>Class Filter</span>
                        <span>({{ classFilterIds.length || 0 }})</span>
                    </div>
                    <div
                        v-if="isShowClassFilter"
                        class="inset-0 fixed z-30 bg-gray-700/25"
                        @click="isShowClassFilter = false"
                    ></div>

                    <div 
                        v-if="isShowClassFilter"
                        class="absolute grid w-full left-0 top-full bg-white border rounded-lg shadow-lg z-40 px-2 py-1.5"
                    >
                        <div
                            class="py-1.5 text-left w-full block rounded"
                        >
                            <Input
                                type="checkbox"
                                :checked="classFilterIds.length === Object.keys(data.classes).length"
                                @change="classFilterHandler($event, 'all')"
                            />
                            All
                        </div>
                        <div
                            v-for="(class_name, class_id) in data.classes"
                            :key="class_id"
                            class="py-1.5 text-left w-full block border-t rounded"
                        >
                            <Input
                                type="checkbox"
                                :checked="classFilterIds.includes(parseInt(class_id))"
                                @change="classFilterHandler($event, parseInt(class_id))"
                            />
                            {{ class_name }}
                        </div>
                    </div>
                </div>
                <div
                    class="px-6 py-2 rounded-lg border flex justify-between items-center col-start-3 bg-gray-100"
                >
                    <span>Selected Number</span>
                    <span>({{ studentFilterIds.length || 0 }})</span>
                </div>
            </div>
            
            <div class="mt-5 h-60 overflow-hidden overflow-y-auto mb-5 z-10 bg-white shadow-sm">
                <table class="table w-full table-auto">
                    <thead class="sticky top-0 bg-gray-200 border-x">
                        <tr>
                            <th></th>
                            <th class="text-left font-bold px-1 py-2">শিক্ষার্থীর নাম</th>
                            <th class="text-center font-bold px-1 py-2">
                                ক্লাস নাম
                            </th>
                            <th class="text-center font-bold px-1 py-2">রোল</th>
                            <th class="text-left font-bold px-1 py-2">অভিভাবকের নাম</th>
                            <th class="text-center font-bold px-1 py-2">অভিভাবকের ফোন</th>
                        </tr>
                    </thead>
                    <tbody class="border">
                        <tr
                            v-for="(sms_data, key) in sms_filter_data"
                            :key="key"
                            :class="{
                                'bg-gray-100':key % 2,
                                'line-through':  !studentFilterIds.includes(parseInt(sms_data.student_id)) 
                            }"
                        >
                            <td class="text-center px-1 py-2">
                                <Input
                                    type="checkbox"
                                    :checked="studentFilterIds.includes(parseInt(sms_data.student_id))"
                                    @change="studentFilterHandler($event, parseInt(sms_data.student_id))"
                                />
                            </td>
                            <td class="text-left px-1 py-2">
                                {{ sms_data.student_name }}
                            </td>
                            <td class="text-center px-1 py-2">
                                {{ data.classes[sms_data.student_class_id] }}
                            </td>
                            <td class="text-center px-1 py-2">
                                {{ sms_data.student_class_roll }}
                            </td>
                            <td class="text-left px-1 py-2">
                                {{ sms_data.guardian_name }}
                            </td>
                            <td class="text-center px-1 py-2">
                                {{ sms_data.guardian_phone }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        
            <div class="grid">
                <div class="bg-gray-200 flex justify-between items-center px-2 py-3 rounded-lg -mb-2">
                    <div class="">SMS লিখুন (<span class="text-rose-600">
                        প্রতি SMS-এ বাংলা-<b>৬০</b>, ইংলিশ-<b>১৬০</b></span>)
                    </div>
                    <div>
                        SMS Character: <b class="text-rose-600">{{ $e2bnumber(form.body.length) }}</b>
                    </div>
                </div>
                <Textarea v-model="form.body" required/>
            </div>
            
            <form-group class="w-full mt-5" label="Sender ID">
                <Select v-model="form.sender" class="block w-full" required>
                    <option value="">-- নির্বাচন --</option>
                    <option
                        v-for="(sender, index) in data.senders"
                        :key="index"
                        :value="sender"
                    >
                        {{ sender }}
                    </option>
                </Select>
            </form-group>

            <hr class="my-4 w-full" />

            <div class="flex items-center justify-end">
                <Button
                    v-if="studentFilterIds.length"
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
            default: "Preview",
        },
        data: {
            type: Object,
            default: {},
        },
    },
    created() {
        this.selectAllFilterClass();
    },
    data() {
        return {
            isShowClassFilter: false,
            classFilterIds: [],
            studentFilterIds: [],
            form: this.$inertia.form({
                body: this.data.sms.body || "",
                sender: this.data.sms.sender || "",
                receivers: this.data.sms.receivers || [],
            }),
        };
    },
    computed: {
        sms_filter_data() {
            return Object.values(this.data.receivers).filter((receiver) => {
                return this.classFilterIds.includes(parseInt(receiver.student_class_id));
            });
        }
    },
    methods: {
        submit() {
            if (this.moduleAction == "store") {
                const smsFinalFilterData = Object.values(this.data.receivers).filter((receiver) => {
                    return this.studentFilterIds.includes(parseInt(receiver.student_id));
                });

                this.form.receivers = smsFinalFilterData.map((data) => {
                    return {
                        student_id: data.student_id,
                        guardian_phone: data.guardian_phone,
                    };
                });

                return this.form.post(this.route("sms-services.store"));
            }
            if (this.moduleAction == "update") {
                return this.form.put(
                    this.route("sms-services.update", this.data.sms.id)
                );
            }
        },
        classFilterHandler(event, class_id) {
            if(class_id === 'all' && event.target.checked) {
                return this.selectAllFilterClass();
            }

            if(class_id === 'all' && !event.target.checked) {
                this.classFilterIds.length = 0;

                return this.selectAllFilterStudent(); 
            }

            const index = this.classFilterIds.indexOf(class_id);

            if (index > -1) {
                this.classFilterIds.splice(index, 1);
            }

            if(event.target.checked) {
                this.classFilterIds.push(class_id);
            }

            return this.selectAllFilterStudent();
        },
        studentFilterHandler(event, class_id) {
            const index = this.studentFilterIds.indexOf(class_id);

            if (index > -1) {
                this.studentFilterIds.splice(index, 1);
            }

            if(event.target.checked) {
                this.studentFilterIds.push(class_id);
            }
        },
        selectAllFilterClass() {
            this.classFilterIds = Object.keys(this.data.classes).map((id) => parseInt(id));

            return this.selectAllFilterStudent();
        },
        selectAllFilterStudent() {
            this.studentFilterIds = Object.values(this.sms_filter_data).map((sms_data) => parseInt(sms_data.student_id));
        }
    },
};
</script>
