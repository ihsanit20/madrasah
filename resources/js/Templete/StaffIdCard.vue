<template>
    <div class="flex flex-wrap gap-8 md:flex-row font-noto-sans-bengali">
        <div class="w-[204px] space-y-2">
            <h3 class="text-center font-bold print:hidden">সামনের অংশ</h3>
            <div class="h-[324px] border bg-white">
                <div
                    class="flex flex-col items-center justify-center gap-1 pt-2.5 pb-1.5 bg-blue-900"
                >
                    <application-logo class="h-9 bg-white rounded-full p-0.5" />
                    <div
                        class="flex flex-col items-center justify-end space-y-1"
                    >
                        <h2
                            class="text-[13px] font-bold text-white"
                        >
                            {{ $page.props.settings.siteName }}
                        </h2>
                    </div>
                </div>
                <div class="flex h-[20px] items-center justify-center bg-blue-900 text-white mt-[-5px]">
                    <h2 class="text-[11px] mt-[3px]">পরিচয়পত্র</h2>
                </div>
                <div class="mt-[50px] h-[118px] bg-white">
                    <div
                        class="mx-auto -mb-11 aspect-[50/50] w-[90px] -translate-y-1/2 overflow-hidden border-2 border-orange-500 rounded-lg"
                    >
                        <img
                            :src="
                                staff.imageUrl ||
                                '/images/hijab-icon.jpg'
                            "
                            class="h-full w-full object-cover"
                        />
                    </div>
                    <div
                        class="text-center text-[13px] font-semibold text-black"
                    >
                        <h1 class="pb-[2px] line-clamp-1 mt-[2px] text-blue-900 font-bold">
                            {{ staff.name }}
                        </h1>
                        <div
                            class="flex items-center justify-center gap-2 text-[10px]"
                        >
                            <div class="w-20 shrink-0 grow-0 text-right">
                                পদবি :
                            </div>
                            <div class="shrink grow text-left">
                                {{ staff.designationTitle }}
                            </div>
                        </div>
                        <!-- <div
                            class="flex items-center justify-center gap-2 text-[10px]"
                        >
                            <div class="w-20 shrink-0 grow-0 text-right">
                                জন্ম :
                            </div>
                            <div class="shrink grow text-left">
                                {{
                                    $e2bnumber(staff.date_of_birth_with_format)
                                    }}
                            </div>
                        </div> -->
                        <div
                            class="flex items-center justify-center gap-2 text-[10px]"
                        >
                            <div class="w-20 shrink-0 grow-0 text-right">
                                আইডি :
                            </div>
                            <div class="shrink grow text-left">
                                ID{{ staff.id }}D{{ staff.designationId }}G{{ staff.gender }}
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="flex h-[38px] items-center justify-center">
                    <img
                        v-if="signature"
                        :src="signature"
                        class="h-full w-full object-contain"
                    />
                </div>
                <div class="flex items-center justify-center">
                    <p class="text-[10px] font-bold text-black">
                        অধ্যক্ষের স্বাক্ষর
                    </p>
                </div>
            </div>
        </div>
        <div class="w-[204px] space-y-2">
            <h3 class="text-center font-bold print:hidden">পিছনের অংশ</h3>
            <div class="relative h-[324px] border bg-white py-2.5">
                <div
                    class="flex items-center justify-center gap-1 text-[10px] font-bold"
                >
                    <div class="shrink-0 grow-0">মেয়াদ :</div>
                    <div class="shrink-0 grow-0">
                        {{ $page.props.settings.idCardTime }}
                    </div>
                </div>
                <p class="text-center text-[10px]">
                    তথ্য যাচাইয়ের জন্য স্ক্যান করুন
                </p>
                <div class="mt-1 flex items-center justify-center">
                    <Link
                        :href="
                            route('verifications.staff-id-card', [
                                staff.id,
                                $page.props.current_academic_session.value,
                            ])
                        "
                        class="h-[91px] w-[91px]"
                    >
                        <QrcodeVue
                            :value="
                                route('verifications.staff-id-card', [
                                    staff.id,
                                    $page.props.current_academic_session.value,
                                ])
                            "
                            class="border border-black p-1 rounded-lg"
                            :size="91"
                            level="L"
                        />
                    </Link>
                </div>
                <p class="mt-2 px-8 text-center text-[9px]">
                    পরিচয়পত্রটি কোথাও পাওয়া গেলে নিম্নোক্ত যেকোন ঠিকানায়
                    পৌঁছে দিন
                </p>
                <h3 class="mt-2 text-center text-[10px] font-bold">
                    ঠিকানা
                </h3>
                <div class="px-8 text-center text-[9px]">
                    {{ present_address_text }}
                </div>
                <div
                    class=" flex items-center justify-center gap-1 text-[9px] font-bold"
                >
                    <div class="shrink-0 grow-0">ফোন :</div>
                    <div class="shrink-0 grow-0">
                        {{ staff.phone }}
                    </div>
                </div>
                <div class="absolute bottom-0 left-0 right-0 z-10 w-full">
                    <div
                        class="flex flex-col items-center justify-end space-y-1 bg-blue-900 py-2 text-white"
                    >
                        <h2 class="text-[12px] font-bold text-yellow-200">
                            {{ $page.props.settings.siteName }}
                        </h2>
                        <h2
                            class="px-6 text-center text-[8px] font-bold text-white"
                        >
                            {{ $page.props.settings.siteAddress }}
                        </h2>
                        <div
                            class="flex items-center justify-center gap-1 text-[9px] font-bold"
                        >
                            <div class="shrink-0 grow-0">
                                ফোন :
                            </div>
                            <div class="shrink-0 grow-0">
                                {{ $page.props.settings.sitePhone }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import AvatarView from "@/Components/AvatarView.vue";
import AppLayout from "@/Layouts/Master.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import QrcodeVue from "qrcode.vue";
export default {
    components: {
        Head,
        Link,
        AppLayout,
        ApplicationLogo,
        AvatarView,
        QrcodeVue,
    },
    computed: {
        present_address_text() {
            let addressText = '';

            let presentAddress = this.staff.present_address_info.address;
            let presentPostOffice = this.staff.present_address_info.postoffice;

            let selectedArea = Object.values(this.data.areas).find((area) => {
                return parseInt(area.id) === parseInt(this.staff.present_address_info.area);
            })

            let selectedDistrict = Object.values(this.data.districts).find((district) => {
                return parseInt(district.id) === parseInt(this.staff.present_address_info.district);
            })

            let selectedDivision = Object.values(this.data.divisions).find((division) => {
                return parseInt(division.id) === parseInt(this.staff.present_address_info.division);
            })

            addressText += (presentAddress ? presentAddress : "");
            // addressText += ", " + (presentPostOffice ? presentPostOffice : "");
            addressText += ", " + (selectedArea ? selectedArea.name : "");
            addressText += ", " + (selectedArea ? selectedDistrict.name : "");
            addressText += ", " + (selectedArea ? selectedDivision.name : "");

            return addressText;
        },
    },
    props: {
        staff: {
            type: Object,
            default: {},
        },
        data: {
            type: Object,
            default: {},
        },
        signature: {
            type: String,
            default: "",
        },
        qrCode: {
            type: String,
            default: "",
        },
    },
    created() {
        console.log("qr", this.qrCode);
    },
};
</script>
