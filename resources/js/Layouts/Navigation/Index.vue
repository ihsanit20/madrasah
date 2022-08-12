<template>
    <div class="space-y-2 bg-white px-2 py-2 font-balooda2 md:px-4">
        <nav-link
            :href="route('dashboard')"
            :active="route().current('dashboard')"
            class="flex items-center gap-2 md:gap-4"
        >
            <MenuIcon class="h-6 w-6 md:h-8 md:w-8" />
            <span class="-mb-1" :class="{ 'hidden md:block': !navigation }">
                ড্যাশবোর্ড
            </span>
        </nav-link>

        <nav-link
            :href="route('students.class.index')"
            :active="route().current('students.*')"
            class="flex items-center gap-2 md:gap-4"
        >
            <ClassSvg class="h-5 w-5 md:h-8 md:w-8" />
            <span class="-mb-1" :class="{ 'hidden md:block': !navigation }">
                শিক্ষার্থী তালিকা
            </span>
        </nav-link>

        <dropdown-nav-link :active="route().current('(admissions).*')">
            <AdmissionSvg class="h-6 w-6 md:h-8 md:w-8" />
            <span class="-mb-1" :class="{ 'hidden md:block': !navigation }">
                ভর্তির আবেদন
            </span>
            <template #items>
                <nav-link
                    :href="route('admissions.create')"
                    :active="route().current('admissions.create')"
                    class="flex items-center gap-2 md:gap-4"
                >
                    <AdmissionSvg class="h-4 w-4 md:h-6 md:w-6" />
                    <span
                        class="-mb-1"
                        :class="{ 'hidden md:block': !navigation }"
                    >
                        নতুন আবেদন
                    </span>
                </nav-link>
                <nav-link
                    :href="route('admissions.index')"
                    :active="route().current('admissions.(index|show|edit)')"
                    class="flex items-center gap-2 md:gap-4"
                >
                    <AdmissionSvg class="h-4 w-4 md:h-6 md:w-6" />
                    <span
                        class="-mb-1"
                        :class="{ 'hidden md:block': !navigation }"
                    >
                        আবেদন তালিকা
                    </span>
                </nav-link>
            </template>
        </dropdown-nav-link>

        <dropdown-nav-link :active="route().current('(payments|others).*')">
            <MoneyReceiptSvg class="h-6 w-6 md:h-8 md:w-8" />
            <span class="-mb-1" :class="{ 'hidden md:block': !navigation }">
                টাকা জমার রশিদ
            </span>
            <template #items>
                <nav-link
                    :href="route('payments.create')"
                    :active="route().current('payments.create')"
                    class="flex items-center gap-2 md:gap-4"
                >
                    <MoneyReceiptSvg class="h-4 w-4 md:h-6 md:w-6" />
                    <span
                        class="-mb-1"
                        :class="{ 'hidden md:block': !navigation }"
                    >
                        নতুন রশিদ
                    </span>
                </nav-link>
                <nav-link
                    :href="route('payments.index')"
                    :active="route().current('payments.(index|show)')"
                    class="flex items-center gap-2 md:gap-4"
                >
                    <MoneyReceiptSvg class="h-4 w-4 md:h-6 md:w-6" />
                    <span
                        class="-mb-1"
                        :class="{ 'hidden md:block': !navigation }"
                    >
                        রশিদ তালিকা
                    </span>
                </nav-link>
                <nav-link
                    :href="route('payments.purpose.index')"
                    :active="route().current('payments.purpose.*')"
                    class="flex items-center gap-2 md:gap-4"
                >
                    <MoneyReceiptSvg class="h-4 w-4 md:h-6 md:w-6" />
                    <span
                        class="-mb-1"
                        :class="{ 'hidden md:block': !navigation }"
                    >
                        বাবদ সমুহ
                    </span>
                </nav-link>
                <nav-link
                    :href="route('others.purpose.index')"
                    :active="route().current('others.purpose.*')"
                    class="flex items-center gap-2 md:gap-4"
                >
                    <MoneyReceiptSvg class="h-4 w-4 md:h-6 md:w-6" />
                    <span
                        class="-mb-1"
                        :class="{ 'hidden md:block': !navigation }"
                    >
                        অন্যান্য বাবদ
                    </span>
                </nav-link>
            </template>
        </dropdown-nav-link>

        <dropdown-nav-link :active="route().current('expenses.*')">
            <PaymentSvg class="h-6 w-6 md:h-8 md:w-8" />
            <span class="-mb-1" :class="{ 'hidden md:block': !navigation }">
                ব্যয়/খরচ
            </span>

            <template #items>
                <nav-link
                    :href="route('expenses.create')"
                    :active="route().current('expenses.create')"
                    class="flex items-center gap-2 md:gap-4"
                >
                    <PaymentSvg class="h-4 w-4 md:h-6 md:w-6" />
                    <span
                        class="-mb-1"
                        :class="{ 'hidden md:block': !navigation }"
                    >
                        নতুন ভাউচার
                    </span>
                </nav-link>
                <nav-link
                    :href="route('expenses.index')"
                    :active="route().current('expenses.(index|show|edit)')"
                    class="flex items-center gap-2 md:gap-4"
                >
                    <PaymentSvg class="h-4 w-4 md:h-6 md:w-6" />
                    <span
                        class="-mb-1"
                        :class="{ 'hidden md:block': !navigation }"
                    >
                        ভাউচার তালিকা
                    </span>
                </nav-link>
            </template>
        </dropdown-nav-link>

        <nav-link
            :href="route('staff-list')"
            :active="route().current('staff-list')"
            class="flex items-center gap-2 md:gap-4"
        >
            <AdminSvg class="h-6 w-6 md:h-8 md:w-8" />
            <span class="-mb-1" :class="{ 'hidden md:block': !navigation }">
                শিক্ষক/স্টাফ
            </span>
        </nav-link>

        <nav-link
            :href="route('notices.index')"
            :active="route().current('notices.*')"
            class="flex items-center gap-2 md:gap-4"
        >
            <NoticeSvg class="h-6 w-6 md:h-8 md:w-8" />
            <span class="-mb-1" :class="{ 'hidden md:block': !navigation }">
                নোটিশ বোর্ড
            </span>
        </nav-link>

        <dropdown-nav-link
            :active="
                route().current(
                    '(classes|fees|staff|designations|categories|admins|settings|purposes).*'
                )
            "
        >
            <SettingsSvg class="h-6 w-6 md:h-8 md:w-8" />
            <span class="-mb-1" :class="{ 'hidden md:block': !navigation }">
                সেটিংস
            </span>
            <template #items>
                <nav-link
                    :href="route('classes.index')"
                    :active="route().current('classes.*')"
                    class="flex items-center gap-2 md:gap-4"
                >
                    <ClassSvg class="h-4 w-4 md:h-6 md:w-6" />
                    <span
                        class="-mb-1"
                        :class="{ 'hidden md:block': !navigation }"
                    >
                        ক্লাস/বিভাগ
                    </span>
                </nav-link>
                <nav-link
                    :href="route('fees.index')"
                    :active="route().current('fees.*')"
                    class="flex items-center gap-2 md:gap-4"
                >
                    <ClipboardListIcon class="h-4 w-4 md:h-6 md:w-6" />
                    <span
                        class="-mb-1"
                        :class="{ 'hidden md:block': !navigation }"
                    >
                        প্রদেয় ফি
                    </span>
                </nav-link>
                <nav-link
                    :href="route('purposes.index')"
                    :active="route().current('purposes.*')"
                    class="flex items-center gap-2 md:gap-4"
                >
                    <MoneyReceiptSvg class="h-4 w-4 md:h-6 md:w-6" />
                    <span
                        class="-mb-1"
                        :class="{ 'hidden md:block': !navigation }"
                    >
                        অন্যান্য বাবদ
                    </span>
                </nav-link>
                <nav-link
                    :href="route('staff.index')"
                    :active="route().current('staff.*')"
                    class="flex items-center gap-2 md:gap-4"
                >
                    <TeacherSvg class="h-4 w-4 md:h-6 md:w-6" />
                    <span
                        class="-mb-1"
                        :class="{ 'hidden md:block': !navigation }"
                    >
                        শিক্ষক/স্টাফ
                    </span>
                </nav-link>
                <nav-link
                    :href="route('designations.index')"
                    :active="route().current('designations.*')"
                    class="flex items-center gap-2 md:gap-4"
                >
                    <IdentificationIcon class="h-4 w-4 md:h-6 md:w-6" />
                    <span
                        class="-mb-1"
                        :class="{ 'hidden md:block': !navigation }"
                    >
                        পদবিসমূহ
                    </span>
                </nav-link>
                <nav-link
                    :href="route('categories.index')"
                    :active="route().current('categories.*')"
                    class="flex items-center gap-2 md:gap-4"
                >
                    <PaymentSvg class="h-4 w-4 md:h-6 md:w-6" />
                    <span
                        class="-mb-1"
                        :class="{ 'hidden md:block': !navigation }"
                    >
                        ব্যয়ের খাত
                    </span>
                </nav-link>
                <nav-link
                    :href="route('admins.index')"
                    :active="route().current('admins.*')"
                    class="flex items-center gap-2 md:gap-4"
                >
                    <AdminSvg class="h-4 w-4 md:h-6 md:w-6" />
                    <span
                        class="-mb-1"
                        :class="{ 'hidden md:block': !navigation }"
                    >
                        এ্যাডমিন সেটিং
                    </span>
                </nav-link>
                <nav-link
                    :href="route('settings.site-setup')"
                    :active="route().current('settings.site-setup')"
                    class="flex items-center gap-2 md:gap-4"
                >
                    <CogIcon class="h-4 w-4 md:h-6 md:w-6" />
                    <span
                        class="-mb-1"
                        :class="{ 'hidden md:block': !navigation }"
                    >
                        সাইট সেটিং
                    </span>
                </nav-link>
            </template>
        </dropdown-nav-link>
    </div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";
import NavLink from "@/Components/NavLink.vue";
import {
    MenuIcon,
    HomeIcon,
    IdentificationIcon,
    LibraryIcon,
    ClipboardListIcon,
    CogIcon,
} from "@heroicons/vue/outline";
import DropdownNavLink from "@/Components/DropdownNavLink.vue";
import {
    ClassSvg,
    StudentSvg,
    AdmissionSvg,
    MoneyReceiptSvg,
    PaymentSvg,
    TeacherSvg,
    AdminSvg,
    NoticeSvg,
    SettingsSvg,
} from "./SvgIcon";
export default {
    components: {
        Link,
        NavLink,
        MenuIcon,
        HomeIcon,
        IdentificationIcon,
        LibraryIcon,
        ClassSvg,
        StudentSvg,
        AdmissionSvg,
        MoneyReceiptSvg,
        PaymentSvg,
        TeacherSvg,
        AdminSvg,
        NoticeSvg,
        SettingsSvg,
        DropdownNavLink,
        ClipboardListIcon,
        CogIcon,
    },
    props: {
        navigation: {
            type: Boolean,
            default: false,
        },
    },
};
</script>
